<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\FavouritesProduct;
use App\Helpers\CommonHelpers;
use App\Models\User;
use Validator;
class ProductController extends Controller
{
    
	public function productList(Request $request)
	{
		$products = Product::all();
		
				if (count($products)==0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "Product not found",
				"data"=>array()
			], 200);
		}
		
		$data = array();
		$user = $request->user();
		
		foreach($products as $val)
		{
			
			$imgurl = "";
			if(count($val->getMedia('products')) >0){
				$imgurl = $val->getMedia('products')->last()->getUrl();
			}
			$whrarr= array("product_id"=>$val->id,"user_id"=>$user->id);
			$favourite = FavouritesProduct::where($whrarr)->count();
			$isfav="0";
			if($favourite >0)
			{
				$isfav = "1";
			}
			
			$data['id']=(string)$val->id;
			$data['name']=(string)$val->name;
			$data['currency']=(string)$val->currency;
			$data['category_id']=(string)$val->category_id;
			$data['price']=(string)$val->rate;
			$data['is_favourite']=(string)$isfav;
			$data['image']=CommonHelpers::getUrl($imgurl);
			$result[$val['Category']->name][] = $data;
		}
		
		foreach($result as $key=>$val)
		{
			$result1 = array();
			$result1['category_id'] = $val[0]['category_id'];
			$result1['category_title'] = $key;
			$result1['product_list'] = $val;
			$productList[]=$result1;
		}
		
		
		
		   return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Online market list got successfully",
			"data"=>$productList],200);
		
	}
	public function categoryProductList(Request $request)
	{
		// $query = new Category();
		
		 // $filter = $query;
		// $cat =$request->category;
		// $filter =  $filter->where(function($q) use ($cat) {
			
                            // $q->whereHas('translation',function($query) use ($cat){
                                    // $query->where('name',$cat);
                                        // })
										// ->where('status', '1');	
								// });
		
		
		// $category = $filter->get();
		// if (count($category) == 0) {
			// return response()->json([
				// "success"=> "0",
				// "status"=> "201",
				// 'message' => "Category not found"
			// ], 201);
		// }
		//$category = Category::with('translations')->where("name","Main")->get();
		
		$products = Product::where('category_id',$request->category_id)->get();
		
		
		if (count($products)==0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "Product not found",
				"data"=>array()
			], 200);
		}
		$data = array();
		$user = $request->user();
		foreach($products as $val)
		{
			
			$imgurl = "";
			if(count($val->getMedia('products')) >0){
				$imgurl = $val->getMedia('products')->last()->getUrl();
			}
			
			$whrarr= array("product_id"=>$val->id,"user_id"=>$user->id);
			$favourite = FavouritesProduct::where($whrarr)->count();
			$isfav="0";
			if($favourite >0)
			{
				$isfav = "1";
			}
			
			$data['id']=(string)$val->id;
			$data['name']=(string)$val->name;
			$data['currency']=(string)$val->currency;
			$data['price']=(string)$val->rate;
			$data['is_favourite']=(string)$isfav;
			$data['image']=CommonHelpers::getUrl($imgurl);
			$result[] = $data;
		}
		
		   return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Online market list got successfully",
			"data"=>$result],200);
		
	}
	
     public function detail(Request $request)
    {	
		$product = Product::find($request->id);
		
		if (empty($product)) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' =>"Product not found",
				"data"=>array()
			], 200);
		}
		
		$user = $request->user();
		$whrarr= array("product_id"=>$product->id,"user_id"=>$user->id);
		$favourite = FavouritesProduct::where($whrarr)->count();
		$isfav="0";
		if($favourite >0)
		{
			$isfav = "1";
		}
			
			
			$productimgarray=array();
			$imgurl = $imgurl1= $imgurl2 = $imgurl3 = $imgurl4 = "";
			if(count($product->getMedia('products')) >0){
				$imgurl = CommonHelpers::getUrl($product->getMedia('products')->last()->getUrl());
				$productimgarray[]=$imgurl;
			}
			if(count($product->getMedia('products1')) >0){
				$imgurl1 =CommonHelpers::getUrl( $product->getMedia('products1')->last()->getUrl());
				$productimgarray[]=$imgurl1;
			}
			if(count($product->getMedia('products2')) >0){
				$imgurl2 = CommonHelpers::getUrl($product->getMedia('products2')->last()->getUrl());
				$productimgarray[]=$imgurl2;
			}
			if(count($product->getMedia('products3')) >0){
				$imgurl3 = CommonHelpers::getUrl($product->getMedia('products3')->last()->getUrl());
				$productimgarray[]=$imgurl3;
			}
			if(count($product->getMedia('products4')) >0){
				$imgurl4 = CommonHelpers::getUrl($product->getMedia('products4')->last()->getUrl());
				$productimgarray[]=$imgurl4;
			}
			$usrdata = User::find($product->user_id);
			$usrimg="";
			if(count($usrdata->getMedia('user')) >0){
				$usrimg = CommonHelpers::getUrl($usrdata->getMedia('user')->last()->getUrl());
				
			}
			
			
			$data['id']=(string)$product->id;
			$data['name']=(string)$product->name;
			$data['currency']=(string)$product->currency;
			$data['price']=(string)$product->rate;
			$data['user']=(string)$usrdata->name;
			$data['userimg']=(string)$usrimg;
			$data['phoneNumber']=(string)$product->country_code." ".$product->phoneNumber;
			$data['is_favourite']=(string)$isfav;
			$data['image']=$productimgarray;
			//$data['time']=date('Y M d g:i A',strtotime($product->created_at));
			$data['time']=$product->created_at;
			 
			 
			
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Product detail got successfully",
			"data"=>$data],200);
    }
	
	public function create(Request $request)
	{
		$rules= [
        'name' => 'required',
        'category_id' => 'required',
        'rate' => 'required',
        'productimg' => 'required'
		];
		
		   $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        
		}else{
				
				$data = $request->all();
			$user = $request->user();
			
			
			$data['user_id'] = $user->id;
			$data['currency'] = "USD";
			
			
			$product = Product::create($data);
			
			if(isset($data['productimg'])) {
				$product->addMediaFromRequest('productimg')->toMediaCollection('products');
			}
			if(isset($data['productimg1'])) {
				$product->addMediaFromRequest('productimg1')->toMediaCollection('products1');
			}
			if(isset($data['productimg2'])) {
				$product->addMediaFromRequest('productimg2')->toMediaCollection('products2');
			}
			if(isset($data['productimg3'])) {
				$product->addMediaFromRequest('productimg3')->toMediaCollection('products3');
			}
			if(isset($data['productimg4'])) {
				$product->addMediaFromRequest('productimg4')->toMediaCollection('products4');
			}
			
			
			$product->save();
			
			
			return response()->json([
				"success"=> "1",
				"status"=> "200",	
				'message' => 'Successfully created product!'
			], 200);
			
			
			
		}
	}
	public function addfavourites(Request $request)
	{
		$rules= [
        'product_id' => 'required'
		];
		
		   $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        
		}else{
			$data = $request->all();
			$user = $request->user();
			$data['user_id'] = $user->id;
			
			$whrarr= array("product_id"=>$data['product_id'],"user_id"=>$user->id);
			$favproduct = FavouritesProduct::where($whrarr)->count();
			
			if($favproduct >0){
				$product = FavouritesProduct::where($whrarr)->delete();
				return response()->json([
					"success"=> "1",
					"status"=> "200",	
					'message' => '1 product remove in your Favourites Product list!'
				], 200);
			}else{
				$product = FavouritesProduct::create($data);
				$product->save();
				
				return response()->json([
					"success"=> "1",
					"status"=> "200",	
					'message' => '1 product added in your Favourites Product list!'
				], 200);
			}
			
			
			
		}
	}
	public function unfavourite(Request $request)
	{
		$rules= [
        'product_id' => 'required'
		];
		
		   $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        
		}else{
			$data = $request->all();
			$user = $request->user();
			$data['user_id'] = $user->id;
			$whrarr= array("product_id"=>$data['product_id'],"user_id"=>$user->id);
			$product = FavouritesProduct::where($whrarr)->delete($data);
			
			
			return response()->json([
				"success"=> "1",
				"status"=> "200",	
				'message' => '1 product remove in your Favourites Product list!'
			], 200);
		}
	}
	public function favouritesProduct(Request $request)
	{
		$user = $request->user();
		$favourite = FavouritesProduct::where('user_id',$user->id)->get();
		$data = array();
		$result = array();
		$productList = array();
		
		if(count($favourite) == 0)
		{
			return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "No favourite product",
			"data"=>array()],200);
		}
		foreach($favourite as $va)
		{
			$val = Product::find($va->product_id);
			$imgurl = "";
			if(count($val->getMedia('products')) >0){
				$imgurl = $val->getMedia('products')->last()->getUrl();
			}
			
			$data['id']=(string)$val->id;
			$data['name']=(string)$val->name;
			$data['currency']=(string)$val->currency;
			$data['price']=(string)$val->rate;
			$data['category_id']=(string)$val->category_id;
			$data['image']=CommonHelpers::getUrl($imgurl);
			$result[$val['Category']->name][] = $data;
		}
		
		foreach($result as $key=>$val)
		{
			$result1 = array();
			$result1['category_id'] = $val[0]['category_id'];
			$result1['category_title'] = $key;
			$result1['product_list'] = $val;
			$productList[]=$result1;
		}
		
		
		   return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "favourite list got successfully",
			"data"=>$productList],200);
	}
}

