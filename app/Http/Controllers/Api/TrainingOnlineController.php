<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingOnline;

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
				'message' => trans('training_online.empty')
			], 404);
		}
     
		return response()->json($TrainingOnline, 201);
    }
}
