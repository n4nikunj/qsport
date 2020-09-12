<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\User;
use App\Models\Tutors;

class TutorsController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:tutor-list', ['only' => ['index','show']]);
        $this->middleware('permission:tutor-create', ['only' => ['create','store']]);
        $this->middleware('permission:tutor-edit', ['only' => ['edit','update']]);
    }
	 public function index()
    {
        $page_title = trans('tutor.plural');
        $tutor = Tutors::all();
		
        return view('admin.tutor.index',compact('tutor', 'page_title'));
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

        $query = new Tutors();
   
        ## Total number of records without filtering
        $total = $query->count();
        $totalRecords = $total;

        ## Total number of record with filtering
         $filter = $query;
        if($searchValue != ''){
        $filter = $filter->where(function($q)use ($searchValue) {
                            $q->whereHas('translation',function($query) use ($searchValue){
                                    $query->where('name','like','%'.$searchValue.'%');
                                        })
                            ->orWhere('id','like','%'.$searchValue.'%')
                            ->orWhere('status','like','%'.$searchValue.'%');
                     });
        }

        $filter_count = $filter->count();
        $totalRecordwithFilter = $filter_count;

        ## Fetch records
        $empQuery = $filter;
		
        $empQuery = $empQuery->orderBy($columnName, $columnSortOrder)->offset($row)->limit($rowperpage)->get();

        $data = array();
        foreach ($empQuery as $emp) {
        # Set dynamic route for action buttons
			$emp['image'] = str_replace('http://localhost',url("/"),$emp->getMedia('tutors')->last()->getUrl('thumb'));
			$emp['certificate'] = str_replace('http://localhost',url("/"),$emp->getMedia('tutorscerty')->last()->getUrl('thumb'));
             $emp['country_name'] = $emp["countries"]['country_name'];
            $emp['edit']= route("tutors.edit",$emp["id"]);
            $emp['show']= route("tutors.show",$emp["id"]);
            $emp['delete'] = route("tutors.destroy",$emp["id"]);
            
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
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
		
        $page_title = trans('tutor.show');
        $tutor = Tutors::find($id);
		
        
        $countries = Country::where('status','active')->get();
        // echo '<pre>'; print_r($category->childs()); die;
		
        return view('admin.tutor.show',compact('countries', 'tutor', 'page_title'));
    }
	/**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('tutor.add_new');
        $users = User::where('status','active')->get();
		 $countries = Country::where('status','active')->get();
        return view('admin.tutor.create', compact('page_title', 'users','countries'));
    }
	
    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = trans('tutor.edit');
        $users = User::where('status','active')->get();
		 $countries = Country::where('status','active')->get();
        $tutor = Tutors::find($id);
        return view('admin.tutor.edit',compact('users', 'countries', 'tutor', 'page_title'));
    }
	/**
     * Update the specified itm in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator= $request->validate([
		 'name:en' => 'required|max:100',
         'description:en' => 'required',
        'phoneno' => 'required',
        'country_id' => 'required',
        'address' => 'required',
        'lat' => 'required',
        'long' => 'required',
        'email' => 'required|email',
        'rate' => 'required',
        ]);

        $data = $request->all();
        $tutors = Tutors::find($id);
       
		 if(isset($data['tutor_image'])) {
            $tutors->addMediaFromRequest('tutor_image')->toMediaCollection('tutors');
        } 
		if(isset($data['tutor_certificate'])) {
            $tutors->addMediaFromRequest('tutor_certificate')->toMediaCollection('tutorscerty');
        }


        if($tutors->update($data)){
            return redirect()->route('tutors.index')->with('success',trans('tutor.updated'));
        } else {
            return redirect()->route('tutors.index')->with('error',trans('common.something_went_wrong'));
        }
    }
	/**
     * Store a newly created item in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
		 'name:en' => 'required|max:100',
         'description:en' => 'required',
        'user_id' => 'required|unique:tutors',
        'phoneno' => 'required',
        'tutor_certificate' => 'required',
        'country_id' => 'required',
        'address' => 'required',
        'lat' => 'required',
        'long' => 'required',
        'email' => 'required|email',
        'rate' => 'required',
        ]);
        
        $data = $request->all();
		$data['status']= "Active";
		$data['profile_status']= "Approved";
        $Tutors = Tutors::create($data);
        
        if(isset($data['tutor_image'])) {
            $Tutors->addMediaFromRequest('tutor_image')->toMediaCollection('tutors');
        } 
		if(isset($data['tutor_certificate'])) {
            $Tutors->addMediaFromRequest('tutor_certificate')->toMediaCollection('tutorscerty');
        }

      
        if($Tutors) {
            return redirect()->route('tutors.index')->with('success',trans('tutor.added'));
        } else {
            return redirect()->route('tutors.index')->with('error',trans('common.something_went_wrong'));
        }

    }
	public function status(Request $request)
    {
        $Tutors= Tutors::where('id',$request->id)
               ->update(['status'=>$request->status]);
    
       if($Tutors){
        return response()->json(['success' => trans('tutors.tutor_status_update_sucessfully')]);
       }else{
        return response()->json(['error' => trans('tutors.tutor_status_update_unsucessfully')]);
       }
    }
	public function prostatus(Request $request)
    {
        $Tutors= Tutors::where('id',$request->id)
               ->update(['profile_status'=>$request->profilestatus]);
    
       if($Tutors){
        return response()->json(['success' => trans('tutors.tutor_status_update_sucessfully')]);
       }else{
        return response()->json(['error' => trans('tutors.tutor_status_update_unsucessfully')]);
       }
    }
}
