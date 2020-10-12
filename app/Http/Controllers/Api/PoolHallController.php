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
		$poolhall = PoolHall::select('id')->where('status', 'active')->get();
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
			'title' => 'required|regex:/^[\pL\s\-]+$/u|min:5|max:100',
			'description' => 'required|min:50|max:500',
			'address' => 'required|min:50|max:500',
			'country_id' => 'required',
			'number_of_tables' => 'required|numeric',
			'email' => 'required|email|min:5|max:100',
			'country_code' => 'required',
			'phone_number' => 'required|numeric|digits:10',
			'start_time' => 'required',
			'end_time' => 'required',
			'price' => 'required|between:0,99.99'
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
	// public function update(Request $request,$id)
    // {
		// $rules= [
			// 'title' => 'required|regex:/^[\pL\s\-]+$/u|min:5|max:100',
			// 'description' => 'required|min:50|max:500',
			// 'address' => 'required|min:50|max:500',
			// 'country_id' => 'required',
			// 'number_of_tables' => 'required|numeric',
			// 'email' => 'required|email|min:5|max:100',
			// 'country_code' => 'required',
			// 'phone_number' => 'required|numeric|digits:10',
			// 'start_time' => 'required',
			// 'end_time' => 'required',
			// 'price' => 'required|between:0,99.99'
		// ];
		
      // $validator = Validator::make($request->all(),$rules);  
       // if ($validator->fails()) {
		 // return response()->json([
            // 'message' => $validator->errors()
        // ], 400);
        
		// }else{
			// $data = $request->all();
			// $poolhall = PoolHall::find($id);
			// $poolhall->update($data);
			// return response()->json([
				// 'message' => 'Successfully updated poolhall!'
			// ], 201);
		// }
    // }
	public function detail($id)
    {	
		$poolhall = PoolHall::with('countries')->find($id);
		if (!$poolhall) {
			return response()->json([
				'message' => trans('poolhall.empty')
			], 404);
		}
        return response()->json($poolhall);
    }
	
}
