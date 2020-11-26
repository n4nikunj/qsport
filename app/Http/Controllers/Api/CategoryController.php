<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
     public function list()
    {
		$where=array("status"=>'1',"parent_id"=>null);
	$cagegory = Category::where($where)->get();
		
		if (count($cagegory) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No category found",
				"data" => array()
			], 200);
		}
		
		
		$data = array();
		 foreach ($cagegory as $val) {
			 
			 $result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			 $result['name'] = ($val["name"] == null)? "" :(string) $val["name"];
			
			
			 $data[] = $result;
		 }
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=>"Category list got successfully",
			"data"=> $data],200
		);
		
		
    }
}
