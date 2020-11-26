<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use Validator;
use App\Helpers\CommonHelpers;

class TournamentController extends Controller
{
     /**
     * Get Tournament List
     *
     * @return [Json] tournament object
     */
	
       public function list()
    {	
		$tournament = Tournament::withTranslation()->select('id','country_id','status','start_date','end_date')->with('countries')->whereHas('countries', function($query) {
                $query->select('country_name');
            })->whereIn("status",['Announced','Running'])->orderBy('id', 'DESC')->get();
		if (count($tournament) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => trans('tournament.empty'),
				"data"=>array()
			], 200);
		}
	
		$data = array();
		 foreach ($tournament as $val) {
			 $result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			 $result['country_code'] = ($val["countries"]["country_code"] == null)? "" : $val["countries"]["country_code"];
			 $result['start_date'] = ($val["start_date"] == null)? "" : $val["start_date"];
			 $result['end_date'] = ($val["end_date"] == null)? "" : $val["end_date"];
			 $result['title'] = ($val["title"] == null)? "" : $val["title"];
			 $result['status'] = ($val["status"] == null)? "" : $val["status"];
			 $result['countryFlag'] =config('adminlte.imageurl')."/img/country/".strtolower($val["countries"]["country_code"]).".png";
			 $data[] = $result;
		 }
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Tournament list got successfully",
			"data"=>$data],200);
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
				"success"=> "0",
				"status"=> "200",
				'message' => trans('tournament.empty'),
				"data"=>array()
			], 200);
		}
			
			
			$userdata = Tournament::where('id', $request->id)->get();
			$imgurl = $thumburl = "";
			if(count($tournament->getMedia('tournament_image')) >0){
				$imgurl = $userdata[0]->getMedia('tournament_image')->last()->getUrl();
				$thumburl =$userdata[0]->getMedia('tournament_image')->last()->getUrl('thumb');
			}
			 $result['id'] = ($tournament->id == null)? "" : (string)$tournament->id;
			 $result['title'] = ($tournament->title == null)? "" : $tournament->title;
			 $result['start_date'] = ($tournament->start_date == null)? "" : $tournament->start_date;
			 $result['end_date'] = ($tournament->end_date == null)? "" : $tournament->end_date;
			 $result['maximum_Player'] = ($tournament->maximum_Player == null)? "" : (string)$tournament->maximum_Player;
			 $result['venue'] = ($tournament->venue == null)? "" : $tournament->venue;
			 $result['email'] = ($tournament->email == null)? "" : $tournament->email;
			 $result['hotel_name'] = ($tournament->hotel_name == null)? "" : $tournament->hotel_name;
			 $result['country_code'] = ($tournament->country_code == null)? "" : $tournament->country_code;
			 $result['phone_number'] = ($tournament->phone_number == null)? "" : $tournament->phone_number;
			 $result['description'] = ($tournament->description == null)? "" : $tournament->description;
			 $result['currency'] = ($tournament->currency == null)? "" : $tournament->currency;
			 $result['entry_fee'] = ($tournament->entry_fee == null)? "" : $tournament->entry_fee;
			 $result['priceMoney'] = ($tournament->priceMoney == null)? "" : $tournament->priceMoney;
			 $result['tornamentImage'] = CommonHelpers::getUrl($imgurl);
			 
			 $result['countryFlag'] = config('adminlte.imageurl')."/img/country/".strtolower($tournament["countries"]->country_code).".png";
			 $data[] = $result;
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Tournament detail got successfully",
			"data"=>$result],200);
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
        'title' => 'required',
        'description' => 'required',
        'country_id' => 'required',
        'venue' => 'required',
        'hotel_name' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'maximum_Player' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'entry_fee' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'priceMoney' => 'required|regex:/^\d+(\.\d{1,2})?$/'
		];
		 $customMessages = [
        'regex' => 'Please enter valid amount for :attribute'
		];
      $validator = Validator::make($request->all(),$rules,$customMessages);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        
		}else{
			$data = $request->all();
			$user = $request->user();
			
			 
			$data['created_at'] =date("Y-m-d");
			$data['updated_at'] = date("Y-m-d");
			$data['created_by'] = $user->id;
			$data['watch_live'] ="No";
			$data['status'] = "Announced";
			$data['amountPaid']="0";
			
			$tournament = Tournament::create($data);
			
			$tournament->save();
			
			if(isset($data['tornamentImage'])) {
				$tournament->addMediaFromRequest('tornamentImage')->toMediaCollection('tournament_image');
			}
			return response()->json([
				"success"=> "1",
				"status"=> "200",	
				'message' => 'Successfully created tournament!'
			], 200);
		}
    }
	
}
