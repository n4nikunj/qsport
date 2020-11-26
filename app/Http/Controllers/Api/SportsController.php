<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game; 
use App\Helpers\CommonHelpers;
class SportsController extends Controller
{
    /**
     * Get Sports List
     *
     * @return [Json] game object
     */
	
    public function list()
    {
		$game = Game::where('status', 'active')->get();
		if (!$game) {
			return response()->json([
			"success"=> "0",
				"status"=> "200",
				'message' =>"No Games Found",
				"data"=>array()
			], 200);
		}
		
		 $data = array();
		 foreach ($game as $val) {
			 
			 $imgurl = "";
			
			if(count($val->getMedia('games')) >0){
				$imgurl = $val->getMedia('games')->last()->getUrl();
				
			}
		
			$result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			$result['game_name'] = ($val["game_name"] == null)? "" : $val["game_name"];
			$result['gameImage'] = CommonHelpers::getUrl($imgurl);
			
			 $data[] = $result;
		 }
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=> $data],200);
    }
}
