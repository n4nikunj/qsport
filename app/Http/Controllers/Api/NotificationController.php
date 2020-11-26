<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifications;
class NotificationController extends Controller
{
    //
	public function getNotification(request $request)
    {	
		$user = $request->user();
	
		$notification = Notifications::all();
		if (count($notification) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "201",
				'message' => "No notification "
			], 201);
		}
	
		$data = array();
		 foreach ($notification as $val) {
			 
			 $ids = explode(",",$val["userid"]);
			 
			 if(in_array($user->id,$ids) or  in_array("All",$ids))
			 {
			 $date = date("Y-m-d", strtotime($val['created_at']));
			 $result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			 $result['title'] = ($val["title"] == null)? "" : $val["title"];
			 $result['message'] = ($val["message"] == null)? "" : $val["message"];
			 $data[$date][] = $result;
			 }
		 }
		
		
		$finalresult= array();
		foreach($data as $k => $v)
		{
			$finalres= array();
			$finalres['date']=$k;
			$finalres['notification_list']=$v;
			
			$finalresult[] = $finalres;
		}
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "notification list got successfully",
			"data"=>$finalresult],200);
    }
	public function clearNotification(request $request)
    {
		$user = $request->user();
	
		
		$notification = Notifications::all();
		if (count($notification) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "201",
				'message' => "No notification "
			], 201);
		}
	
		$data = array();
		 foreach ($notification as $val) {
			 
			 $ids = explode(",",$val["userid"]);
			 
			 if(in_array($user->id,$ids) or  in_array("All",$ids))
			 {
				 if (($key = array_search($user->id, $ids)) !== false) {
					unset($ids[$key]);
				}
				$updatedid['userid'] = implode(',',$ids);
				
				 Notifications::where("id",$val['id'])->update($updatedid);
			
			 }
		 }
		
		
		$finalresult= array();
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "notification list got successfully",
			"data"=>$finalresult],200);
	}
}
