<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Country;
use App\Models\Helpers\GeneralConfigurationHelpers;

class TournamentsController extends Controller
{
    use GeneralConfigurationHelpers;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:tournament-list', ['only' => ['index','show']]);
        $this->middleware('permission:tournament-create', ['only' => ['create','store']]);
        $this->middleware('permission:tournament-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('tournament.plural');
        $tournament = Tournament::with('countries')->get();
        return view('admin.tournament.index',compact('tournament', 'page_title'));
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

        $query = new Tournament();
   
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
                            ->orWhere('hotel_name','like','%'.$searchValue.'%')
                            ->orWhere('venue','like','%'.$searchValue.'%')
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
             $emp['country_name'] = $emp["countries"]['country_name'];
            $emp['edit']= route("tournaments.edit",$emp["id"]);
            $emp['show']= route("tournaments.show",$emp["id"]);
            $emp['delete'] = route("tournaments.destroy",$emp["id"]);
            
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
		
        $page_title = trans('tournament.show');
        $tournament = Tournament::find($id);
        $countries = Country::where('status','active')->get();
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.tournament.show',compact('countries', 'tournament', 'page_title'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
		
        $page_title = trans('tournament.edit');
        $countries = Country::where('status','active')->get();
        $tournament = Tournament::find($id);
        return view('admin.tournament.edit',compact('countries', 'tournament', 'page_title'));
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
        'title:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
         'description:en' => 'required',
        'country_id' => 'required',
        'venue' => 'required',
        'hotel_name' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'maximum_Player' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'entry_fee' => 'required',
        'priceMoney' => 'required',
        'entry_fee' => 'required',
        'currency' => 'required'
        ]);

        $data = $request->all();
        $tournament = Tournament::find($id);
         if(isset($data['tournament_image'])) {
            $tournament->addMediaFromRequest('tournament_image')->toMediaCollection('tournament_image');
        }


        if($tournament->update($data)){
            return redirect()->route('tournaments.index')->with('success',trans('tournament.updated'));
        } else {
            return redirect()->route('tournaments.index')->with('error',trans('common.something_went_wrong'));
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
        $Tournament = Tournament::find($id);

        if($Tournament->delete()){
            return redirect()->route('tournaments.index')->with('success',trans('tournament.deleted'));
        }else{
            return redirect()->route('tournaments.index')->with('error',trans('common.something_went_wrong'));
        }
    }
	public function status(Request $request)
    {
        $Tournament= Tournament::where('id',$request->id)
               ->update(['status'=>$request->status]);
    
       if($Tournament){
        return response()->json(['success' => trans('tournament.tournament_status_update_sucessfully')]);
       }else{
        return response()->json(['error' => trans('tournament.tournament_status_update_unsucessfully')]);
       }
    }
}
