<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsors;
use App\Models\User;
use App\Models\Country;
class SponsorsController extends Controller
{
    /**
     * Display a Sponsor listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index()
    {
        $page_title = trans('sponsors.plural');
        $sponsor = Sponsors::with('users')->get();
        return view('admin.sponsor.index',compact('sponsor', 'page_title'));
    }
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

        $query = new Sponsors();
   
        ## Total number of records without filtering
        $total = $query->count();
        $totalRecords = $total;

        ## Total number of record with filtering
         $filter = $query;
        if($searchValue != ''){
        $filter = $filter->Where('name','like','%'.$searchValue.'%')
                            ->orWhere('id','like','%'.$searchValue.'%')
                            ->orWhere('status','like','%'.$searchValue.'%');
                     
        }

        $filter_count = $filter->count();
        $totalRecordwithFilter = $filter_count;

        ## Fetch records
        $empQuery = $filter;
		
        $empQuery = $empQuery->orderBy($columnName, $columnSortOrder)->offset($row)->limit($rowperpage)->get();
		/* $d =  $query->getMedia('sponsors_logo')->first()->getUrl('thumb');
		print_r($d);
		exit; */
        $data = array();
        foreach ($empQuery as $emp) {
        # Set dynamic route for action buttons
		
		
			$emp['logo'] = str_replace('http://localhost',url("/"),$emp->getMedia('sponsor_logo')->last()->getUrl('thumb'));
            $emp['show']= route("sponsors.show",$emp["id"]);
			$emp['edit']= route("sponsors.edit",$emp["id"]);
            $emp['delete'] = route("sponsors.destroy",$emp["id"]);
            
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
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('sponsors.add_new');
        $users = User::where('status','active')->get();
		 $countries = Country::where('status','active')->get();
        return view('admin.sponsor.create', compact('page_title', 'users','countries'));
    }
	 /**
     * Store a newly created item in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
        'user_id' => 'required',
        'name' => 'required',
        
        'website' => 'required|url',
        'phoneno' => 'required',
        'email' => 'required|email',
        'sponsor_logo' => 'required',
        ]);
        
        $data = $request->all();
		$data['status']= "Active";
        $sponsors = Sponsors::create($data);
        
        if(isset($data['sponsor_logo'])) {
            $sponsors->addMediaFromRequest('sponsor_logo')->toMediaCollection('sponsors');
        }

      
        if($sponsors) {
            return redirect()->route('sponsors.index')->with('success',trans('sponsors.added'));
        } else {
            return redirect()->route('sponsors.index')->with('error',trans('common.something_went_wrong'));
        }

    }
	public function edit($id)
    {
		$page_title = trans('sponsors.edit');
		$sponsors = Sponsors::find($id);
        $users = User::where('status','active')->get();
		$countries = Country::where('status','active')->get();
        return view('admin.sponsor.edit', compact('page_title','sponsors','users','countries'));
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
        
		$validator= $request->validate([
        'user_id' => 'required',
        'name' => 'required',
        'website' => 'required|url',
        'phoneno' => 'required',
        'email' => 'required|email',
        ]);
        
        $data = $request->all();
		$sponsors = Sponsors::find($id);
		
         if(isset($data['sponsor_logo'])) {
            $sponsors->addMediaFromRequest('sponsor_logo')->toMediaCollection('sponsor_logo');
        }


        if($sponsors->update($data)){
            return redirect()->route('sponsors.index')->with('success',trans('sponsors.updated'));
        } else {
            return redirect()->route('sponsors.index')->with('error',trans('common.something_went_wrong'));
        }
    }
	
	public function show($id)
    {
        $page_title = trans('sponsors.show');
        $sponsors = Sponsors::find($id);
		$users = User::where('status','active')->get();
        $countries = Country::where('status','active')->get();
        return view('admin.sponsor.show',compact('countries','users','sponsors', 'page_title'));
    }
	
	public function status(Request $request)
    {
        $Sponsors= Sponsors::where('id',$request->id)
               ->update(['status'=>$request->status]);
    
       if($Sponsors){
        return response()->json(['success' => trans('sponsors.sponsor_status_update_sucessfully')]);
       }else{
        return response()->json(['error' => trans('sponsors.sponsor_status_update_unsucessfully')]);
       }
    }
	
	  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $Sponsors = Sponsors::find($id);

        if($Sponsors->delete()){
            return redirect()->route('sponsors.index')->with('success',trans('sponsor.deleted'));
        }else{
            return redirect()->route('sponsors.index')->with('error',trans('common.something_went_wrong'));
        }
    }
}
