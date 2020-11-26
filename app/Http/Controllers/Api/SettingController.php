<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\DeviceDetail;
use Validator;
class SettingController extends Controller
{
     public function SiteSetting()
    {
		$setting = Setting::where('status', 'active')->get();
		if (!$setting) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No Setting found",
				"data"=>array()
			], 200);
		}
		$data = array();
		$displayarry= array("facebook_url","twitter_url","instagram_url","snapchat_url","youtube_url","about_us_url","how_to_use");
		foreach($setting as $val){
			if(in_array($val->name,$displayarry)){
			$result[$val->name] = (string)$val->value;
			}
			
		}
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "General Site Setting",
			"data"=> $result],200
		);
		
    }
	public function UserSetting(request $request)
	{
			$urserdetail = $request->user();
			$setting = DeviceDetail::where('user_id', $urserdetail->id)->get();
			if (!$setting) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No Setting found",
				"data"=>array()
			], 200);
		}
		$data = array();
		foreach($setting as $val){
			$pushconfig = (strtolower($val->push_config) == "yes")? "True" : "False";
			
			$result['push_config'] = (string)$pushconfig;
			$result['country_name'] = (string)$val->country_name;
			$result['country_id'] = (string)$val->country_id;
			$result['currency'] = (string)$val->currency;
			
			
		}
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "User Setting got successfully",
			"data"=> $result],200
		);
	}
	
	public function updateSetting(request $request)
	{
			$urserdetail = $request->user();
			$data = $request->all();
			
			$message="";
				
		
			   foreach($data as $val)
			   {
					if($val == "")
					{
						$message = "This field is required";
					}
			   }
			

		   if ($message !="") {
			 return response()->json([
				"success"=> "0",
					"status"=> "201",
				'message' => $message
			], 201);
			
			}else{			
			
		
											
			$udata = DeviceDetail::where('user_id', $urserdetail->id)->update($data);
		
			$setting = DeviceDetail::where('user_id', $urserdetail->id)->get();
			foreach($setting as $val){
			
				$result['push_config'] = (string)$val->push_config;
				$result['country_name'] = (string)$val->country_name;
				$result['country_id'] = (string)$val->country_id;
				$result['currency'] = (string)$val->currency;
				
				
			}
			 return response()->json([
										"success"=> "1",
										"status"=> "200",	
										'message' => trans('user.updated'),
										'data'=>$result
							], 200);	
							
			}
	}
}
