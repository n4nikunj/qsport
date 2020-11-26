<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingOnline;
use Carbon\Carbon;
use App\Helpers\CommonHelpers;

class TrainingOnlineController extends Controller
{
    //
	
     /**
     * Get Training Online List
     *
     * @return [Json] Training  Online object
     */
	
       public function onlinelist()
    {	
		$TrainingOnline = TrainingOnline::all();
		if (!$TrainingOnline) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => trans('training_online.empty'),
				'data'=>array()
			], 200);
		}
     
		return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=> $TrainingOnline], 200);
    }
	public function upcoming()
    {	
		$TrainingOnline = TrainingOnline::where('session_date', '>', Carbon::now()->startOfDay())->get();
		if (count($TrainingOnline)==0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No training session available",
				'data'=>array()
			], 200);
		}
     $data = array();
		 foreach ($TrainingOnline as $val) {
			 
			 $imgurl = "";
			
			if(count($val->getMedia('training_online_images')) >0){
				$imgurl = $val->getMedia('training_online_images')->last()->getUrl();
				
			}
		
			$result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			$result['title'] = ($val["title"] == null)? "" : $val["title"];
			$result['tutor_name'] = ($val["tutor_name"] == null)? "" : (string)$val["tutor_name"];
			$result['session_date'] = ($val["session_date"] == null)? "" :  date("d M Y", strtotime($val["session_date"]));
			$result['start_time'] = ($val["start_time"] == null)? "" : date("h:i A", strtotime($val["start_time"]));
			$result['end_time'] = ($val["end_time"] == null)? "" : date("h:i A", strtotime($val["end_time"]));
			$result['TrainingImage'] = CommonHelpers::getUrl($imgurl);
			
			 $data[] = $result;
		 }
		return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=> $data], 200);
    }
	public function liveSession()
    {	
		$TrainingOnline = TrainingOnline::where('session_date', '=', Carbon::now()->startOfDay())->get();
		if (count($TrainingOnline) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No live training session available",
				'data'=>array()
			], 200);
		}
     $data = array();
		 foreach ($TrainingOnline as $val) {
			 
			 $imgurl = "";
			
			if(count($val->getMedia('training_online_images')) >0){
				$imgurl = $val->getMedia('training_online_images')->last()->getUrl();
				
			}
		
			$result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			$result['title'] = ($val["title"] == null)? "" : $val["title"];
			$result['tutor_name'] = ($val["tutor_name"] == null)? "" : (string)$val["tutor_name"];
			$result['session_date'] = ($val["session_date"] == null)? "" :  date("d M Y", strtotime($val["session_date"]));
			$result['start_time'] = ($val["start_time"] == null)? "" : date("h:i A", strtotime($val["start_time"]));
			$result['end_time'] = ($val["end_time"] == null)? "" : date("h:i A", strtotime($val["end_time"]));
			$result['TrainingImage'] = CommonHelpers::getUrl($imgurl);
			
			 $data[] = $result;
		 }
		return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=> $data], 200);
    }
	public function sessiondetail(request $request)
    {	
		$TrainingOnline = TrainingOnline::where('id', $request->id)->get();
		if (count($TrainingOnline) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No live training session available",
				'data'=>array()
			], 200);
		}
     $data = array();
		 foreach ($TrainingOnline as $val) {
			 
			 $imgurl = "";
			
			if(count($val->getMedia('training_online_images')) >0){
				$imgurl = $val->getMedia('training_online_images')->last()->getUrl();
				
			}
		
			$result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			$result['title'] = ($val["title"] == null)? "" : $val["title"];
			$result['tutor_name'] = ($val["tutor_name"] == null)? "" : (string)$val["tutor_name"];
			$result['session_date'] = ($val["session_date"] == null)? "" :  date("d M Y", strtotime($val["session_date"]));
			$result['description'] = ($val["description"] == null)? "" : $val["description"];
			$result['TrainingImage'] = CommonHelpers::getUrl($imgurl);
		 $result['link'] = (string) $val['link'];
			
			 $data[] = $result;
		 }
		return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=> $result], 200);
    }
}
