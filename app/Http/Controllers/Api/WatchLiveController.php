<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WatchLive; 
use Validator;

class WatchLiveController extends Controller
{
    /**
     * Get Sports List
     *
     * @return [Json] watchlive object
     */
	
    public function list()
    {
		$watchlive = WatchLive::select('id','start_date','end_date','price')->where('status', 'active')->get();
		if (!$watchlive) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No watchlive recored found",
				"data"=>array()
			], 200);
		}
        return response()->json($watchlive);
		
    }
	public function detail($id)
    {	
		$watchlive = WatchLive::find($id);
		if (!$watchlive) {
			return response()->json([
				"success"=> "0",
				"status"=> "201",
				'message' => trans('watchlive.empty')
			], 201);
		}
        return response()->json($watchlive);
    }
	
}
