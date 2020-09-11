<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingSheet;
use App\Models\PoolHall;
use App\Models\Tournament;
use App\Models\Country;
use App\Models\Helpers\GeneralConfigurationHelpers;

class PoolHallController extends Controller
{
	use GeneralConfigurationHelpers;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:pool_hall-list', ['only' => ['index','show']]);
        $this->middleware('permission:pool_hall-create', ['only' => ['create','store']]);
        $this->middleware('permission:pool_hall-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:pool_hall-delete', ['only' => ['destroy']]);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$page_title = trans('poolhall.plural');
        $poolhall = PoolHall::with('countries')->get();
        return view('admin.poolhall.index',compact('poolhall', 'page_title'));
    }
	public function index_ajax(Request $request)
    {
        $request         =    $request->all();
		//print_r($request);exit;
        $draw            =    $request['draw'];
        $row             =    $request['start'];
        $rowperpage      =    $request['length']; // Rows display per page
        $columnIndex     =    $request['order'][0]['column']; // Column index
        $columnName      =    $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder =    $request['order'][0]['dir']; // asc or desc
        $searchValue     =    $request['search']['value']; // Search value

        $query = new PoolHall();
		
        ## Total number of records without filtering
        $total = $query->count();
        $totalRecords = $total;

        ## Total number of record with filtering
         $filter = $query;
        if($searchValue != ''){
        $filter = $filter->where(function($q)use ($searchValue) {
                            $q->whereHas('translation',function($query) use ($searchValue){
                                    $query->where('title','like','%'.$searchValue.'%');
                                        })
                            ->orWhere('id','like','%'.$searchValue.'%')
                            ->orWhere('status','like','%'.$searchValue.'%');
                     });
        }

        $filter_count = $filter->count();
        $totalRecordwithFilter = $filter_count;

        ## Fetch records
		
        $empQuery = $filter;
		if($columnName == 'title') {
			$empQuery = $empQuery->with('translations')->orderByTranslation($columnName,$columnSortOrder)->get();
		}
		else{
			$empQuery = $empQuery->orderBy($columnName,$columnSortOrder)->offset($row)->limit($rowperpage)->get();
		}
		
        $data = array();
        foreach ($empQuery as $emp) {
			
        # Set dynamic route for action buttons
             $emp['country_id'] = $emp["countries"]['country_name'];
            $emp['edit']= route("pool_hall.edit",$emp["id"]);
            $emp['show']= route("pool_hall.show",$emp["id"]);
            $emp['delete'] = route("pool_hall.destroy",$emp["id"]);
          $data[]=$emp;
        }
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = trans('poolhall.show');
        $poolhall = PoolHall::find($id);
        $countries = Country::where('status','active')->get();
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.poolhall.show',compact('countries', 'poolhall', 'page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = trans('poolhall.edit');
        $countries = Country::where('status','active')->get();
        $poolhall = PoolHall::find($id);
        return view('admin.poolhall.edit',compact('countries', 'poolhall', 'page_title'));
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
        'title:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'description:en' => 'required',
        'country_id' => 'required',
        'number_of_tables' => 'required',
        'types_of_tables' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'price' => 'required',
        'address' => 'required',
        ]);

        $data = $request->all();
        $poolhall = PoolHall::find($id);
         if(isset($data['pool_image'])) {
            $poolhall->addMediaFromRequest('pool_image')->toMediaCollection('pool_image');
        }


        if($poolhall->update($data)){
            return redirect()->route('pool_hall.index')->with('success',trans('poolhall.updated'));
        } else {
            return redirect()->route('pool_hall.index')->with('error',trans('common.something_went_wrong'));
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
        $PoolHall = PoolHall::find($id);

        if($PoolHall->delete()){
            return redirect()->route('pool_hall.index')->with('success',trans('poolhall.deleted'));
        }else{
            return redirect()->route('pool_hall.index')->with('error',trans('common.something_went_wrong'));
        }
    }
	public function status(Request $request)
    {
        $PoolHall= PoolHall::where('id',$request->id)
               ->update(['status'=>$request->status]);
    
       if($PoolHall){
        return response()->json(['success' => trans('poolhall.pool_hall_status_update_sucessfully')]);
       }else{
        return response()->json(['error' => trans('poolhall.pool_hall_status_update_unsucessfully')]);
       }
    }
}
