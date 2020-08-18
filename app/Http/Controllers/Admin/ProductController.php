<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Country;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:product-list', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('products.plural');
        $products = Product::all();
        // print_r($product);die;
        return view('admin.products.index',compact('products', 'page_title'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('products.add_new');
        $categories = Category::all();
        $countries = Country::where('status','active')->get();
        return view('admin.products.create', compact('page_title', 'categories', 'countries'));
    }

    /**
     * Store a newly created item in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
        'name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'description' => 'required',
        'rate' => 'required',
        'currency' => 'required',
        'user_id' => 'required',
        'category_id' => 'required',
        'product_image' => 'required',
        ]);

        $data = $request->all();
        $product = Product::create($data);
        
        if(isset($data['product_image'])) {
            $product->addMediaFromRequest('product_image')->toMediaCollection('products');
        }
   
        if($product) {
            return redirect()->route('products.index')->with('success',trans('products.added'));
        } else {
            return redirect()->route('products.index')->with('error',trans('common.something_went_wrong'));
        }

    }

    /**
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $page_title = trans('products.show');
        $product = Product::find($id);
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.products.show',compact('product', 'page_title'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = trans('products.edit');
        $categories = Category::all();
        $countries = Country::where('status','active')->get();
        $product = Product::find($id);
        return view('admin.products.edit',compact('categories', 'countries', 'product', 'page_title'));
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
        'name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'description' => 'required',
        'rate' => 'required',
        'currency' => 'required',
        'user_id' => 'required',
        'category_id' => 'required',
        // 'product_image' => 'required',
        ]);

        $data = $request->all();
        $product = Product::find($id);

        if(isset($data['product_image'])) {
            $product->addMediaFromRequest('product_image')->toMediaCollection('products');
        }

        if($product->update($data)){
            return redirect()->route('products.index')->with('success',trans('products.updated'));
        } else {
            return redirect()->route('products.index')->with('error',trans('common.something_went_wrong'));
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
        $product = Product::find($id);

        if($product->delete()){
            return redirect()->route('products.index')->with('success',trans('products.deleted'));
        }else{
            return redirect()->route('products.index')->with('error',trans('common.something_went_wrong'));
        }
    }
}
