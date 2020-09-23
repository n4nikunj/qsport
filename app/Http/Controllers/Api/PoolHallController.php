<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PoolHall; 

class PoolHallController extends Controller
{
    /**
     * Get Sports List
     *
     * @return [Json] poolhall object
     */
	
    public function list()
    {
		$poolhall = PoolHall::where('status', 'active')->get();
		if (!$poolhall) {
			return response()->json([
				'message' => trans('poolhall.empty')
			], 404);
		}
        return response()->json($poolhall);
    }
	public function createPool(Request $request)
    {
        $request->validate([
            'title:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
			'description:en' => 'required',
			'address:en' => 'required',
			'country_id' => 'required',
			'number_of_tables' => 'required',
			'types_of_tables' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required',
			'social_media_link' => 'required',
			'start_time' => 'required',
			'end_time' => 'required',
			'price' => 'required'
        ]);
		
        $data = $request->all();
		$poolhall = PoolHall::create($data);
		
        return response()->json([
            'message' => 'Successfully created Pool Hall!'
        ], 201);
		
		
    }
	public function updatePool(Request $request,$id)
    {
        $request->validate([
            'title:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
			'description:en' => 'required',
			'address:en' => 'required',
			'country_id' => 'required',
			'number_of_tables' => 'required',
			'types_of_tables' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required',
			'social_media_link' => 'required',
			'start_time' => 'required',
			'end_time' => 'required',
			'price' => 'required'
        ]);
		
        $data = $request->all();
        $poolhall = PoolHall::find($id);
        $poolhall->update($data);

		
        return response()->json([
            'message' => 'Successfully updated Pool Hall!'
        ], 201);
		
		
    }
}
