<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingSheet;


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
		if (!$TrainingSheet) {
			return response()->json([
				'message' => trans('training_sheets.empty')
			], 404);
		}
     
		return response()->json($TrainingSheet, 201);
    }
}
