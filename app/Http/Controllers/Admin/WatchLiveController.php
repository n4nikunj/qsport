<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingSheet;
use App\Models\WatchLive;
use App\Models\Helpers\GeneralConfigurationHelpers;

class WatchLiveController extends Controller
{
	use GeneralConfigurationHelpers;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:watch_live-list', ['only' => ['index','show']]);
        $this->middleware('permission:watch_live-create', ['only' => ['create','store']]);
        $this->middleware('permission:watch_live-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:watch_live-delete', ['only' => ['destroy']]);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$page_title = trans('watchlive.plural');
        $watchlive = WatchLive::all();
        return view('admin.watchlive.index',compact('watchlive', 'page_title'));
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

        $query = new WatchLive();
		
        ## Total number of records without filtering
        $total = $query->count();
        $totalRecords = $total;

        ## Total number of record with filtering
         $filter = $query;
        if($searchValue != ''){
        $filter = $filter->where(function($q)use ($searchValue) {
                            $q->whereHas('translation',function($query) use ($searchValue){
                                    $query->where('match_name','like','%'.$searchValue.'%');
                                        })
                            ->orWhere('id','like','%'.$searchValue.'%')
                            ->orWhere('status','like','%'.$searchValue.'%');
                     });
        }

        $filter_count = $filter->count();
        $totalRecordwithFilter = $filter_count;

        ## Fetch records
		
        $empQuery = $filter;
		if($columnName == 'match_name') {
			$empQuery = $empQuery->with('translations')->orderByTranslation($columnName,$columnSortOrder)->get();
		}
		else{
			$empQuery = $empQuery->orderBy($columnName,$columnSortOrder)->offset($row)->limit($rowperpage)->get();
		}
		
        $data = array();
        foreach ($empQuery as $emp) {
			
        # Set dynamic route for action buttons
            $emp['edit']= route("watch_live.edit",$emp["id"]);
            $emp['show']= route("watch_live.show",$emp["id"]);
            $emp['delete'] = route("watch_live.destroy",$emp["id"]);
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
        $page_title = trans('watchlive.add_new');
        return view('admin.watchlive.create', compact('page_title'));
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
        'match_name:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'start_date'  =>  'required|date',
		'end_date'    =>  'required|date|after_or_equal:start_date',
        'price' => 'required',
        'online_link' => 'required|url',
        'match_image' => 'required'
        ]);

        $data = $request->all();
		$watchlive = WatchLive::create($data);
        
        if(isset($data['match_image'])) {
            //$watchlive->addMediaFromRequest('match_image')->toMediaCollection('match_image');
        }

		if($watchlive) {
            return redirect()->route('watch_live.index')->with('success',trans('watchlive.added'));
        } else {
            return redirect()->route('watch_live.index')->with('error',trans('common.something_went_wrong'));
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
        $page_title = trans('watchlive.show');
        $watchlive = WatchLive::find($id);
        return view('admin.watchlive.show',compact('watchlive', 'page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = trans('watchlive.edit');
        $watchlive = WatchLive::find($id);
        return view('admin.watchlive.edit',compact('watchlive', 'page_title'));
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
        'match_name:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'start_date'  =>  'required|date',
		'end_date'    =>  'required|date|after_or_equal:start_date',
        'price' => 'required',
        'online_link' => 'required|url',
        ]);

        $data = $request->all();
		$watchlive = WatchLive::find($id);
        if(isset($data['match_image'])) {
            $watchlive->addMediaFromRequest('match_image')->toMediaCollection('match_image');
        }


        if($watchlive->update($data)){
            return redirect()->route('watch_live.index')->with('success',trans('watchlive.updated'));
        } else {
            return redirect()->route('watch_live.index')->with('error',trans('common.something_went_wrong'));
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
        $WatchLive = WatchLive::find($id);

        if($WatchLive->delete()){
            return redirect()->route('watch_live.index')->with('success',trans('watchlive.deleted'));
        }else{
            return redirect()->route('watch_live.index')->with('error',trans('common.something_went_wrong'));
        }
    }
	public function status(Request $request)
    {
        $WatchLive= WatchLive::where('id',$request->id)
               ->update(['status'=>$request->status]);
    
       if($WatchLive){
        return response()->json(['success' => trans('watchlive.watch_live_status_update_sucessfully')]);
       }else{
        return response()->json(['error' => trans('watchlive.watch_live_status_update_unsucessfully')]);
       }
    }
}
