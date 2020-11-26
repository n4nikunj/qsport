<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\User;
class NotificationController extends Controller
{
    //
	 public function index()
    {
        $page_title = trans('notification.plural');
        $notification = Notifications::all();
        return view('admin.notification.index',compact('notification', 'page_title'));
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

        $query = new Notifications();
   
        ## Total number of records without filtering
        $total = $query->count();
        $totalRecords = $total;

        ## Total number of record with filtering
         $filter = $query;
        if($searchValue != ''){
        $filter = $filter->Where('title','like','%'.$searchValue.'%')
                            ->orWhere('message','like','%'.$searchValue.'%');
        }

        $filter_count = $filter->count();
        $totalRecordwithFilter = $filter_count;

        ## Fetch records
        $empQuery = $filter;
		
        $empQuery = $empQuery->orderBy($columnName, $columnSortOrder)->offset($row)->limit($rowperpage)->get();

        $data = array();
        foreach ($empQuery as $emp) {
        # Set dynamic route for action buttons
			
            $emp['edit']= route("notification.edit",$emp["id"]);
            $emp['show']= route("notification.show",$emp["id"]);
            $emp['delete'] = route("notification.destroy",$emp["id"]);
            
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
	public function show($id)
    {
        $page_title = trans('notification.show');
        $notification = Notifications::find($id);
	$users = User::where('status','active')->get();
	$userdata = array();
		foreach($users as $val)
		{
			$userdata[$val->id] = $val->name;
		}
	
        return view('admin.notification.show',compact('userdata','notification','page_title'));
    }
		
	/**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('sponsors.add_new');
		$where =array("status"=>'active',"user_type"=>"Customer");
        $users = User::where($where)->get();
        return view('admin.notification.create', compact('page_title', 'users'));
    }
	 /**
     * Store a newly created item in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
        'users' => 'required',
        'title' => 'required',
        'message' => 'required'
        ]);
        
        $data = $request->all();
		/*
		if(in_array("All",$data['users']))
		{
			$ids = "All";
		}else{
			$ids = implode(',',$data['users']);
		}*/
		$ids = implode(',',$data['users']);
       $insdata['userid']=$ids;
       $insdata['title']=$data['title'];
       $insdata['message']=$data['message'];
		$sponsors = Notifications::create($insdata);
        
       
      
        if($sponsors) {
            return redirect()->route('notification.index')->with('success',trans('notification.added'));
        } else {
            return redirect()->route('notification.index')->with('error',trans('common.something_went_wrong'));
        }

    }
}
