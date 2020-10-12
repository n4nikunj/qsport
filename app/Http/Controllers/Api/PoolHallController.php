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
	
	public function createPool(Request $request)
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
			'created_by'=>'required'
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
	public function updatePool(Request $request,$id)
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
			'created_by'=>'required'
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
            'message' => 'Successfully updated Pool Hall!'
        ], 201);
		}
		
    }
}
