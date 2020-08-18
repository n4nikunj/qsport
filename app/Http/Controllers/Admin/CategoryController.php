<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:category-list', ['only' => ['index','show']]);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('categories.plural');
        $categories = Category::all();
        return view('admin.categories.index',compact('categories', 'page_title'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$page_title = trans('categories.add_new');
    	$categories = Category::all();
    	return view('admin.categories.create', compact('page_title', 'categories'));
    }

   	/**
     * Store a newly created item in storage.
  	 * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
            'name:ar' => 'required',
            'name:en' => 'required|regex:/^[\pL\s\-]+$/u',
        ]);

        $data = $request->all();
        // echo '<pre>'; print_r($data); die;
        if(Category::create($data)) {
            return redirect()->route('categories.index')->with('success',trans('categories.added'));
        } else {
            return redirect()->route('categories.index')->with('error',trans('common.something_went_wrong'));
        }
    }

    /**
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $page_title = trans('categories.show');
        $category = Category::find($id);
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.categories.show',compact('category', 'page_title'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = trans('categories.edit');
        $category = Category::find($id);
        $subs = Category::where('parent_id', $id)->pluck('id');
        // echo $subs; die;
        $categories = Category::where('id','!=',$id)->whereNotIn('id', $subs)->get();
        return view('admin.categories.edit',compact('category', 'categories', 'page_title'));
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
            'name:ar' => 'required',
            'name:en' => 'required|regex:/^[\pL\s\-]+$/u',
        ]);

        $data = $request->all();
        $category = Category::find($id);
        if($category->update($data)){
            return redirect()->route('categories.index')->with('success',trans('categories.updated'));
        } else {
            return redirect()->route('categories.index')->with('error',trans('common.something_went_wrong'));
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
        $category = Category::find($id);

        if($category->delete()){
            return redirect()->route('categories.index')->with('success',trans('categories.deleted'));
        }else{
            return redirect()->route('categories.index')->with('error',trans('common.something_went_wrong'));
        }
    }
}
