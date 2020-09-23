<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use Validator;
class TournamentController extends Controller
{
     /**
     * Get Tournament List
     *
     * @return [Json] tournament object
     */
	
       public function list()
    {	
		$tournament = Tournament::withTranslation()->select('id','country_id','start_date','end_date')->with('countries') ->whereHas('countries', function($query) {
                $query->select('country_name');
            })->get();
		if (!$tournament) {
			return response()->json([
				'message' => trans('tournament.empty')
			], 404);
		}
        return response()->json($tournament);
    }
	
     /**
     * Get tournament detail
     *
     * @param  [integer] id
     * @return [Json] Tournament Object
     */
	
     public function detail(Request $request)
    {	
		$tournament = Tournament::with('countries')->find($request->id);
		if (!$tournament) {
			return response()->json([
				'message' => trans('tournament.empty')
			], 404);
		}
        return response()->json($tournament);
    }
	/**
     * Tournament create 
     *
     * @param  [string] title
     * @param  [string] description
     * @param [string] access_token
     * @param [string] token_type
     * @param [string] expires_at
	 * @param [Integer] country_id
	 * @param [string] venue
	 * @param [string] hotel_name
	 * @param [string] email
	 * @param [string] country_code
	 * @param [string] phone_number
	 * @param [Integer] maximum_Player
	 * @param [date] start_date
	 * @param [date] end_date
	 * @param [string] currency->nullable()
	 * @param [decimal] entry_fee
	 * @param [decimal] priceMoney
	 * @param [decimal] amountPaid
	 * @param [enum] status,
	 * @param [enum] watch_live ['yes','no']  default('no')
	 * @return [Json] message
     */
	public function create(Request $request)
    {
        
        
		$rules= [
        'title' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'description' => 'required',
        'country_id' => 'required',
        'venue' => 'required',
        'hotel_name' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'maximum_Player' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'entry_fee' => 'required',
        'priceMoney' => 'required',
        'amountPaid' => 'required',
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
            'message' => $validator->errors()
        ], 400);
        
		}else{
			$data = $request->all();
			$tournament = Tournament::create($data);
			$tournament->save();
			return response()->json([
				'message' => 'Successfully created tournament!'
			], 201);
		}
    }
	
}
