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

	
	/**
     * Create Pool Hall
     *
     * @param  [string] title
     * @param  [string] description
     * @param  [string] address
     * @param  [integer] country_id
     * @return [integer] number_of_tables
     * @return [string] types_of_tables
     * @return [string] email
     * @return [string] phone_number
     * @return [string] start_time
     * @return [string] end_time
     * @return [integer] created_by
     */
	

	public function create(Request $request)
    {
		$rules= [
<<<<<<< HEAD
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
=======
			'title' => 'required',
			'description' => 'required',
			'address' => 'required',
			'country_id' => 'required',
			'number_of_tables' => 'required',
			'types_of_tables' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required',
			'start_time' => 'required',
			'end_time' => 'required',
			'created_by'=>'required'
>>>>>>> e247d7a53e0ddfc83c05086d09019c13cb684508
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
            'message' => $validator->errors()
        ], 400);
        
		}else{
			
		
        $data = $request->all();
		$data['social_media_link']="http://www.facebook.com";
		$data['price']=0;
		$poolhall = PoolHall::create($data);
		
        return response()->json([
            'message' => 'Successfully created Pool Hall!'
        ], 201);

		
		}
    }
<<<<<<< HEAD
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
=======
	public function update(Request $request,$id)
    {

        	$rules= [
			'title' => 'required',
			'description' => 'required',
			'address' => 'required',
			'country_id' => 'required',
			'number_of_tables' => 'required',
			'types_of_tables' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required',
			'start_time' => 'required',
			'end_time' => 'required',
			'price' => 'required'
		];
>>>>>>> e247d7a53e0ddfc83c05086d09019c13cb684508
		
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
