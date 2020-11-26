<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiamondsPackage;
use App\Models\Helpers\GeneralConfigurationHelpers;
use Carbon\Carbon;

class DiamondsPackageController extends Controller
{
	use GeneralConfigurationHelpers;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:diamonds_package-list', ['only' => ['index','show']]);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$page_title = trans('diamonds_package.plural');
        $diamonds_package = DiamondsPackage::all();
        return view('admin.diamonds_package.index',compact('diamonds_package', 'page_title'));
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

        $query = new DiamondsPackage();
		
        ## Total number of records without filtering
        $total = $query->count();
        $totalRecords = $total;

        ## Total number of record with filtering
         $filter = $query;
        if($searchValue != ''){
        $filter = $filter->where(function($q)use ($searchValue) {
                            $q->where('id','like','%'.$searchValue.'%');
                     });
        }

        $filter_count = $filter->count();
        $totalRecordwithFilter = $filter_count;

        ## Fetch records
		
        $empQuery = $filter;
		$empQuery = $empQuery->orderBy($columnName,$columnSortOrder)->offset($row)->limit($rowperpage)->get();
		
        $data = array();
        foreach ($empQuery as $emp) {
        # Set dynamic route for action buttons
            $emp['show'] = route("diamonds_package.show",$emp["id"]);
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = trans('diamonds_package.show');
        $diamonds_package = DiamondsPackage::find($id);
        return view('admin.diamonds_package.show',compact('diamonds_package', 'page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
	public function status(Request $request)
    {
       
    }
}
