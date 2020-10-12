<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PoolHall; 
use Validator;

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
	public function create(Request $request)
    {
		$rules= [
			'title' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
			'description' => 'required',
			'address' => 'required',
			'country_id' => 'required',
			'number_of_tables' => 'required',
			'types_of_tables' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required',
			'social_media_link' => 'required',
			'start_time' => 'required',
			'end_time' => 'required',
			'price' => 'required'
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
            'message' => $validator->errors()
        ], 400);
        
		}else{
			$data = $request->all();
			$poolhall = PoolHall::create($data);
			$poolhall->save();
			return response()->json([
				'message' => 'Successfully created poolhall!'
			], 201);
		}
		
		
    }
	public function update(Request $request,$id)
    {
		$rules= [
			'title' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
			'description' => 'required',
			'address' => 'required',
			'country_id' => 'required',
			'number_of_tables' => 'required',
			'types_of_tables' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required',
			'social_media_link' => 'required',
			'start_time' => 'required',
			'end_time' => 'required',
			'price' => 'required'
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
            'message' => $validator->errors()
        ], 400);
        
		}else{
			$data = $request->all();
			$poolhall = PoolHall::find($id);
			$poolhall->update($data);
			return response()->json([
				'message' => 'Successfully updated poolhall!'
			], 201);
		}
    }
	public function detail($id)
    {	
		$tournament = Tournament::with('countries')->find($request->id);
		if (!$tournament) {
			return response()->json([
				'message' => trans('tournament.empty')
			], 404);
		}
        return response()->json($tournament);
    }
}
