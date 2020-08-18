<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;


class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:level-list', ['only' => ['index','show']]);
        $this->middleware('permission:level-create', ['only' => ['create','store']]);
        $this->middleware('permission:level-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('levels.plural');
        $levels = level::all();
        // print_r($level);die;
        return view('admin.levels.index',compact('levels', 'page_title'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('levels.add_new');
        return view('admin.levels.create', compact('page_title'));
    }

    /**
     * Store a newly created item in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
            'level_name:ar' => 'required|max:30',
            'level_name:en' => 'required|max:30',
            'no_of_question' => 'required',
            'plus_point_per_que' => 'required',
            'minus_point_per_que' => 'required',
        ]);

        $data = $request->all();
        $level = level::create($data);
   
        if($level) {
            return redirect()->route('levels.index')->with('success',trans('levels.added'));
        } else {
            return redirect()->route('levels.index')->with('error',trans('common.something_went_wrong'));
        }

    }

    /**
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $page_title = trans('levels.show');
        $level = level::find($id);
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.levels.show',compact('level', 'page_title'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = trans('levels.edit');
        $level = level::find($id);
        return view('admin.levels.edit',compact('level', 'page_title'));
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
            'level_name:ar' => 'required|max:30',
            'level_name:en' => 'required|max:30',
            'no_of_question' => 'required',
            'plus_point_per_que' => 'required',
            'minus_point_per_que' => 'required',
        ]);

        $data = $request->all();
        $level = level::find($id);

        if($level->update($data)){
            return redirect()->route('levels.index')->with('success',trans('levels.updated'));
        } else {
            return redirect()->route('levels.index')->with('error',trans('common.something_went_wrong'));
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
        $level = level::find($id);

        if($level->delete()){
            return redirect()->route('levels.index')->with('success',trans('levels.deleted'));
        }else{
            return redirect()->route('levels.index')->with('error',trans('common.something_went_wrong'));
        }
    }
}
