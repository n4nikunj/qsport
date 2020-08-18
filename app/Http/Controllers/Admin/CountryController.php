<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Cms;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:country-list', ['only' => ['index','show']]);
        $this->middleware('permission:country-create', ['only' => ['create','store']]);
        $this->middleware('permission:country-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:country-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $page_title = trans('cms.heading'); 
       $countrys= Country::all();
       return view('admin.country.index',compact(['countrys','page_title']));
    }

    /**
     * Serverside DataTable.
     *
     * @return \Illuminate\Http\Response
     */

     public function index_ajax(Request $request)
    {
        $request         =    $request->all();
        $draw            =    $request['draw'];
        $row             =    $request['start'];
        $rowperpage      =    $request['length']; // Rows display per page
        $columnIndex     =    $request['order'][0]['column']; // Column index
        $columnName      =    $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder =    $request['order'][0]['dir']; // asc or desc
        $searchValue     =    $request['search']['value']; // Search value

        $query = new Country();   
    
        ## Total number of records without filtering
        $total = $query->count();
        $totalRecords = $total;

        ## Total number of record with filtering
        $filter = $query;

        if($searchValue != ''){
        $filter = $filter->where(function($q)use ($searchValue) {
                            $q->where('country_name','like','%'.$searchValue.'%')
                            ->orWhere('dial_code','like','%'.$searchValue.'%')
                            ->orWhere('currency','like','%'.$searchValue.'%')
                            ->orWhere('currency_symbol','like','%'.$searchValue.'%')
                            ->orWhere('status','like','%'.$searchValue.'%')
                            ->orWhere('id','like','%'.$searchValue.'%');
                     });
        }

        $filter_count = $filter->count();
        $totalRecordwithFilter = $filter_count;

        ## Fetch records
        $empQuery = $filter;
        $empQuery = $empQuery->orderBy($columnName, $columnSortOrder)->offset($row)->limit($rowperpage)->get();
        $data = array();
        foreach ($empQuery as $emp) {
        ## Set dynamic route for action buttons
            $emp['edit']= route("country.edit",$emp["id"]);
            $emp['show']= route("country.show",$emp["id"]);
            $emp['delete'] = route("country.destroy",$emp["id"]);
            
          $data[]=$emp;
        }

        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecordwithFilter,
          "iTotalDisplayRecords" => $totalRecords,
          "aaData" => $data
        );

        echo json_encode($response);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = trans('country.add_new'); 
        return view('admin.country.create',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'country_name'     =>  'required|regex:/(^[\pL0-9 ]+)$/u|unique:countries',
            'country_code'     =>  'required|regex:/(^[\pL0-9 ]+)$/u|unique:countries',
            'dial_code'        =>  'required|unique:countries',
            'currency'         =>  'required|regex:/(^[\pL0-9 ]+)$/u|unique:countries',
            'currency_code'    =>  'required|regex:/(^[\pL0-9 ]+)$/u|unique:countries',
            'currency_symbol'  =>  'required|unique:countries',
            'status'           =>  'required|in:active,inactive',
        ]);

        $country = new Country();
        $createArray = $request->all();
        $createArray['country_code']  = strtoupper($createArray['country_code']);
        $createArray['currency_code'] = strtoupper($createArray['currency_code']);
        $country->fill($createArray);

        if($country->save()){
            return redirect()->route('country.index')->with('success', trans('country.creat_country_success'));
        }else{
            return redirect()->route('country.index')->with('error', trans('country.creat_country_error'));
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $page_title = trans('country.show'); 
        $country = Country::find($id);
        if($country){
            return view('admin.country.show',compact(['country','page_title']));
        }else{
            return redirect()->route('country.index')->with('error', trans('country.creat_country_error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $page_title = trans('country.update'); 
        $country = Country::find($id);
        if($country){
            return view('admin.country.edit',compact(['country','page_title']));
        }else{
            return redirect()->route('country.index')->with('error', trans('country.creat_country_error'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $country = Country::find($id);

        $this->validate($request, [
            'country_name'      =>  ['required','regex:/(^[\pL0-9 ]+)$/u','max:30',Rule::unique('countries')->ignore($country->id)],
            'country_code'      =>  ['required','regex:/(^[\pL0-9 ]+)$/u','max:30',Rule::unique('countries')->ignore($country->id)],
            'dial_code'         => 'required',
            'currency'          =>  ['required','regex:/(^[\pL0-9 ]+)$/u','max:30',Rule::unique('countries')->ignore($country->id)],
            'currency_code'     =>  ['required','regex:/(^[\pL0-9 ]+)$/u','max:30',Rule::unique('countries')->ignore($country->id)],
            'currency_symbol'   => 'required',
            'status'            => 'required',
        ]);


        
        $updateArray = $request->all();
        $updateArray['country_code']  = strtoupper($updateArray['country_code']);
        $updateArray['currency_code'] = strtoupper($updateArray['currency_code']);
        $country->fill($updateArray);

        if($country->save()){
            return redirect()->route('country.index',compact('country'))->with('success', trans('country.update_country_success'));
        }else{
            return redirect()->route('country.index')->with('error', trans('country.update_country_unsuccess'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);

        if(empty($country) && $country->count() == 0){
            return redirect()->route('country.index')->with('error', trans('country.no_found_country'));
        }

        if($country->delete()){
            return redirect()->route('country.index')->with('success', trans('country.delete_country_success'));
        }else{
            return redirect()->route('country.index')->with('error', trans('country.not_delete_country'));
        }
    }

    /**
    * Ajax for index page status dropdown.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function status(Request $request)
    {
        $country= Country::where('id',$request->id)
               ->update(['status'=>$request->status]);
    
       if($country){
        return response()->json(['success' => trans('country.county_status_update')]);
       }else{
        return response()->json(['error' => trans('country.not_status_update')]);
       }
    }
}
