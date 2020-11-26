<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use App\Models\Translations\CmsTranslation;


class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:cms-list', ['only' => ['index','show']]);
        $this->middleware('permission:cms-create', ['only' => ['create','store']]);
        $this->middleware('permission:cms-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $page_title = trans('cms.heading');
        $cms = Cms::all();
        return view('admin.cms.index',compact('cms','page_title'));
    
    }
 public function index_ajax(Request $request){
        // print_r($request);

        $request         =    $request->all();
        $draw            =    $request['draw'];
        $row             =    $request['start'];
        $rowperpage      =    $request['length']; // Rows display per page
        $columnIndex     =    $request['order'][0]['column']; // Column index
        $columnName      =    $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder =    $request['order'][0]['dir']; // asc or desc
        $searchValue     =    $request['search']['value']; // Search value

        $query = Cms::query();
    
        ## Total number of records without filtering
        $totalRecords = $query->count();

        ## Total number of record with filtering
        $filter= $query;
        if($searchValue != ''){
            $filter =   $filter->whereHas('translation',function($query) use ($searchValue){
                          $query->where('content','like','%'.$searchValue.'%')->orWhere('page_name','like','%'.$searchValue.'%')->orWhere('display_order','like','%'.$searchValue.'%')->orWhere('slug','like','%'.$searchValue.'%');
                         });
        }
        $filter = $query;
        $totalRecordwithFilter = $filter->count();

        ## Fetch records
        $empQuery = $filter->orderBy($columnName, $columnSortOrder)->offset($row)->limit($rowperpage)->get();
        $data = array();

        foreach ($empQuery as $emp) {
        ## Set dynamic route for action buttons
            $emp['edit'] = route("cms.edit",$emp["id"]);
            $emp['show'] = route("cms.show",$emp["id"]);
            $emp['delete'] = route("cms.destroy",$emp["id"]);
            $data[]      = $emp;
        }

        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
        );

        echo json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $page_title = trans('cms.add_new');
  
        return view('admin.cms.create',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
            'page_name:ar' => 'required|max:255',
            'page_name:en' => 'required|max:255',
            'content:ar' => 'required|max:255',
            'content:en' => 'required|max:255',
            'slug' => 'required',
            'display_order' => 'required|integer',
        ]);
        $data = $request->all();
        // echo '<pre>'; print_r($data); die;
        if(Cms::create($data)) {
            return redirect()->route('cms.index')->with('success',trans('cms.cms_saved_successfully'));
        } else {
            return redirect()->route('cms.index')->with('error',trans('cms.cms_saved_unsuccessfully'));
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
        $page_title = trans('cms.show');
        $cms = Cms::find($id);
        return view('admin.cms.show',compact('cms','page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = trans('cms.update');
        $cms = Cms::find($id);
        return view('admin.cms.edit',compact('cms','page_title'));
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

        $data = $request->all();
        $cms = Cms::find($id);
        
        if(empty($cms)){
            return redirect()->route('cms.index')->with('error',trans('cms.something_went_wrong'));
        }

        if($request->locale == 'en'){
            $validator= $request->validate([
                'page_name:en' => 'required|max:255',
                'content:en' => 'required|max:255',
                'slug' => 'required|max:255',
                'display_order' => 'required|integer|max:255',
            ]);
        }else
        if($request->locale == 'ar'){
            $validator= $request->validate([
                'page_name:ar' => 'required|max:255',
                'content:ar' => 'required|max:255',
                'slug' => 'required|max:255',
                'display_order' => 'required|integer|max:255',
            ]);
        }else{
            $validator= $request->validate([
                'page_name:ar' => 'required|max:255',
                'page_name:en' => 'required|max:255',
                'content:ar' => 'required|max:255',
                'content:en' => 'required|max:255',
                'slug' => 'required|max:255',
                'display_order' => 'required|integer|max:255',
            ]);
        }
        

        if($cms->update($data)){
            return redirect()->route('cms.index')->with('success',trans('cms.cms_update_success'));
        } else {
            return redirect()->route('cms.index')->with('error',trans('cms.cms_update_unsuccess'));
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
        $cms = Cms::find($id);

        if($cms->delete()){
            return redirect()->route('cms.index')->with('success',trans('cms.cms_deleted_Successfully'));
        }else{
            return redirect()->route('cms.index')->with('error',trans('cms.cms_deleted_UnSuccessfully'));
        }
    }

    public function status(Request $request)
    {
        $cms= Cms::where('id',$request->id)
               ->update(['status'=>$request->status]);
    
       if($cms){
        return response()->json(['success' => trans('cms.cms_status_update_sucess')]);
       }else{
        return response()->json(['error' => trans('cms.cms_status_update_unsucess')]);
       }
    }
	    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pageName($pageName)
    {
       
        $cms = Cms::where('slug',$pageName)->get();
		
        return view('admin.cms.page',compact('cms'));
    }
}
   