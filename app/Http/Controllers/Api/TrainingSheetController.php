<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingSheet;
use App\Helpers\CommonHelpers;

class TrainingSheetController extends Controller
{
    //
	
     /**
     * Get Training sheet List
     *
     * @return [Json] Training sheet object
     */
	    public function sheets()
    {	
		$TrainingSheet = TrainingSheet::all();
		if (count($TrainingSheet) ==0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No drills available",
				"data"=>array()
			], 200);
		}
      $data = array();
		 foreach ($TrainingSheet as $val) {
			 
			
			$result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			$result['title'] = ($val["title"] == null)? "" : $val["title"];
			 $data[] = $result;
		 }
		return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Drill got successfully",
			"data"=> $data], 200);
    }
	
	 public function instructions(request $request)
    {	
		//$TrainingSheet = TrainingSheet::all();
		$TrainingSheet = TrainingSheet::where('id', $request->id)->get();
		if (count($TrainingSheet) ==0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No drills available",
				"data"=>array()
			], 200);
		}
      $data = array();
		 foreach ($TrainingSheet as $val) {
			 
			
			$result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			$result['drill_instructions'] = ($val["drill_instructions"] == null)? "" : $val["drill_instructions"];
			 $data[] = $result;
		 }
		return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Drill got successfully",
			"data"=> $data], 200);
    }
	public function detail(request $request)
    {	
		//$TrainingSheet = TrainingSheet::all();
		$TrainingSheet = TrainingSheet::where('id', $request->id)->get();
		if (count($TrainingSheet) ==0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No drills available",
				"data"=>array()
			], 200);
		}
      $data = array();
		 foreach ($TrainingSheet as $val) {
			 
			$imgurl = "";
			$videourl = "";
			
			if(count($val->getMedia('training_sheet_images')) >0){
				$imgurl = $val->getMedia('training_sheet_images')->last()->getUrl();
				
			}
			if(count($val->getMedia('training_sheet_videos')) >0){
				$videourl = $val->getMedia('training_sheet_videos')->last()->getUrl();
				
			}
			
			$result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			$result['title'] = ($val["title"] == null)? "" : $val["title"];
			$result['drillImage'] = CommonHelpers::getUrl($imgurl);
			$result['drillVideo'] = CommonHelpers::getUrl($videourl);
			 $data[] = $result;
		 }
		return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Drill got successfully",
			"data"=> $result], 200);
    }
}
