<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;


class GameController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        $this->middleware('permission:game-list', ['only' => ['index','show']]);
        $this->middleware('permission:game-create', ['only' => ['create','store']]);
        $this->middleware('permission:game-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:game-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('games.plural');
        $games = Game::all();
        // print_r($level);die;
        return view('admin.games.index',compact('games', 'page_title'));
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

        $query = new game();
    
        ## Total number of records without filtering
        $total = $query->count();
        $totalRecords = $total;

        ## Total number of record with filtering
        $filter = $query;

        if($searchValue != ''){
        $filter = $filter->where(function($q)use ($searchValue) {
                            $q->whereHas('translation',function($query) use ($searchValue){
                                    $query->where('game_name','like','%'.$searchValue.'%');
                                        })
                            ->orWhere('game_icon','like','%'.$searchValue.'%')
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
            if($emp->getMedia('games')->last() != null){
            $emp['icon']= "<img src=".str_replace('http://localhost',url("/"),$emp->getMedia('games')->last()->getUrl('thumb'))." style='width:50px;'>";
            }else{
            $emp['icon'] = 'no image';    
            }
            $emp['edit']= route("games.edit",$emp["id"]);
            $emp['show']= route("games.show",$emp["id"]);
            $emp['delete'] = route("games.destroy",$emp["id"]);
            
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

    public function create(){
        $page_title = trans('games.add_new');
        return view('admin.games.create', compact('page_title'));
    }

    /**
     * Store a newly created item in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
            'game_name:ar' => 'required|max:30',
            'game_name:en' => 'required|max:30',
            'game_icon' => 'required',
        ]);

        try {
            $data = $request->all();
            $game = Game::create($data);

            if(isset($data['game_icon'])) {
                $game->addMediaFromRequest('game_icon')->toMediaCollection('games');
        }
       
            if($game) {
                return redirect()->route('games.index')->with('success',trans('games.added'));
            } else {
                return redirect()->route('games.index')->with('error',trans('common.something_went_wrong'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        try {
            $page_title = trans('games.show');
            $game = Game::find($id);

            return view('admin.games.show',compact('game', 'page_title'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());            
        }
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        try {
            $page_title = trans('games.edit');
            $game = Game::find($id);
            return view('admin.games.edit',compact('game', 'page_title'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());                        
        }
    }

    /**
     * Update the specified itm in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
        $validator= $request->validate([
            'game_name:ar' => 'required|max:30',
            'game_name:en' => 'required|max:30',
            'game_icon' => 'required',
        ]);
        try {
            $data = $request->all();
            $game = Game::find($id);

            if(isset($data['game_icon'])) {
                $game->addMediaFromRequest('game_icon')->toMediaCollection('games');
            }

            if($game->update($data)){
                return redirect()->route('games.index')->with('success',trans('games.updated'));
            } else {
                return redirect()->route('games.index')->with('error',trans('common.something_went_wrong'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());                           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        try {
            $game = Game::find($id);

            if($game->delete()){
                return redirect()->route('games.index')->with('success',trans('games.deleted'));
            }else{
                return redirect()->route('games.index')->with('error',trans('common.something_went_wrong'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());                                       
        }
    }

      public function status(Request $request)
    {
        $games= game::where('id',$request->id)
               ->update(['status'=>$request->status]);
    
       if($games){
        return response()->json(['success' => trans('games.game_status_update_sucessfully')]);
       }else{
        return response()->json(['error' => trans('games.game_status_update_unsucessfully')]);
       }
    }
}
