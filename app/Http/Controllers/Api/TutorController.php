<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutors;
use Validator;
use App\Helpers\CommonHelpers;


class TutorController extends Controller
{
     /**
     * Get Tutor List
     *
     * @return [Json] Tutor object
     */
	
       public function list()
    {	
	$data = array();
		$Tutor = Tutors::withTranslation()->select('id','country_id','rate','currency','phoneno','country_code')->with('countries') ->whereHas('countries', function($query) {
                $query->select('country_name');
            })->get();
			
			
			
		if (count($Tutor) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => trans('tutor.empty'),
				"data"=>array()
			], 200);
		}else{
			 foreach ($Tutor as $emp) {
				 
				  $imgurl = $imgurl1 = $imgurl2="";
				if(count($emp->getMedia('tutors')) >0){
					$imgurl = $emp->getMedia('tutors')->last()->getUrl();
					
				}
				 
				 
				# Set dynamic route for action buttons
				$result['id']=($emp["id"] == null)? "" : (string)$emp["id"];
				$result['rate']=($emp["rate"] == null)? "" : $emp["rate"] ;
				$result['currency']=($emp["currency"] == null)? "" : $emp["currency"];
				$result['phoneno']=($emp["phoneno"] == null)? "" : $emp["phoneno"];
				$result['country_code']=($emp["country_code"] == null)? "" : $emp["country_code"];
				$result['name']=($emp["name"] == null)? "" : $emp["name"];
				$result['tutor-image'] =CommonHelpers::getUrl($imgurl);
				$result['country_id'] = ($emp["country_id"] == null)? "" : (string)$emp["country_id"]; 
				$result['countryFlag'] =config('adminlte.imageurl')."/img/country/".strtolower($emp["countries"]["country_code"]).".png";
					//https://www.countryflags.io/in/flat/64.png
					//https://www.countryflags.io/kw/flat/64.png
				$data[]=$result;
			}
			   return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=>$data],200);
		}
     
    }
	
     /**
     * Get Tutor detail
     *
     * @param  [integer] id
     * @return [Json] Tutor Object
     */
	
     public function detail(Request $request)
    {	
	
		
		$Tutor = Tutors::with('countries')->find($request->id);
		
		
		if (!$Tutor) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => trans('tutor.empty'),
				"data"=>array()
			], 200);
		}
		else{
			$certyarray=array();
				  $imgurl = $certi = $certi1 = $certi2 ="";
				if(count($Tutor->getMedia('tutors')) >0){
					$imgurl = $Tutor->getMedia('tutors')->last()->getUrl();
					
				}
				if(count($Tutor->getMedia('tutorscerty')) >0){
					$certi = CommonHelpers::getUrl($Tutor->getMedia('tutorscerty')->last()->getUrl());
					if($certi != "") 
						$certyarray[]=$certi;
				}
				if(count($Tutor->getMedia('tutorscerty1')) >0){
					$certi1 = CommonHelpers::getUrl($Tutor->getMedia('tutorscerty1')->last()->getUrl());
					if($certi1 != "") 
						$certyarray[]=$certi1;
				}
				if(count($Tutor->getMedia('tutorscerty2')) >0){
					$certi2 = CommonHelpers::getUrl($Tutor->getMedia('tutorscerty2')->last()->getUrl());
					if($certi2 != "") 
						$certyarray[]=$certi2;
				}
			
				$result['id']=($Tutor->id == null)? "" : (string)$Tutor->id;
				$result['rate']=($Tutor->rate == null)? "" : (string)$Tutor->rate;
				$result['currency']= (string)$Tutor->currency;
				$result['phoneno']=($Tutor->phoneno == null)? "" : (string)$Tutor->phoneno;
				$result['country_code']= (string)$Tutor->country_code;
				$result['name']= (string)$Tutor->name;
				$result['email']= (string)$Tutor->email;
				$result['address']= (string)$Tutor->address;
				$result['description']= (string)$Tutor->description;
				$result['tutor-image'] = CommonHelpers::getUrl($imgurl);
				$result['certificate-image'] = $certyarray;
				$result['country_name'] =  (string)$Tutor->countries['country_name'];
				$result['country_id'] =  (string)$Tutor->country_id;
				$result['facebook'] =  (string)$Tutor->facebook;
				$result['youtube'] =  (string)$Tutor->youtube;
				$result['twitter'] = (string) $Tutor->twitter;
				$result['insta'] =  (string)$Tutor->insta;
				$result['snapchat'] =  (string)$Tutor->snapchat;
				$result['countryFlag'] = config('adminlte.imageurl')."/img/country/".strtolower($Tutor->countries['country_code']).".png";
					//https://www.countryflags.io/in/flat/64.png
					//https://www.countryflags.io/kw/flat/64.png
				$data[]=$result;
			
			return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=>$result],200);
		}
    }
	/**
     * Tutor create 
     *
     * @param  [file] tutor_image
     * @param  [string] name
     * @param  [string] email
	 * @param  [string] country_code
	 * @param  [string] phone_number
	 * @param  [Integer] country_id
	 * @param  [string] address
	 * @param  [string] facebook
     * @param  [string] youtube
	 * @param  [string] twitter
	 * @param  [string] insta
	 * @param  [string] snapchat
	 * @param  [string] website
	 * @param  [file] certificate
	 * @param  [file] certificate1
	 * @param  [file] certificate2
	 * @param  [string] description

     */
	public function create(Request $request)
    {
        
        
		$rules= [
        'name' => 'required',
		'email' => 'required|email',
        'country_code' => 'required',
        'phoneno' => 'required',
        'country_id' => 'required',
        'address' => 'required',
		'tutor_image' => 'required'
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "200",
            'message' => $validator->errors(),
			"data"=>array()
        ], 200);
        
		}else{
			$data = $request->all();
			$user = $request->user();
			
			$Tutordata = Tutors::where('user_id',$user->id)->get();
			
			if(count($Tutordata)>0){
				 return response()->json([
					"success"=> "0",
					"status"=> "200",
					'message' => "User can created only one profile",
					"data"=>array()
				], 200);
			}
			
			$data['user_id'] = $user->id;
			$data['rate'] = "0";
			$data['lat'] = "0";
			$data['long'] = "0";
			$data['profile_status'] = "New";
			$data['status'] = "Active";
			$data['created_at'] =date("Y-m-d");
			$data['updated_at'] = date("Y-m-d");
			
			
			$Tutor = Tutors::create($data);
			
			if(isset($data['tutor_image'])) {
				$Tutor->addMediaFromRequest('tutor_image')->toMediaCollection('tutors');
			}
			if(isset($data['certificate'])) {
				$Tutor->addMediaFromRequest('certificate')->toMediaCollection('tutorscerty');
			}
			if(isset($data['certificate1'])) {
				$Tutor->addMediaFromRequest('certificate1')->toMediaCollection('tutorscerty1');
			}
			if(isset($data['certificate2'])) {
				$Tutor->addMediaFromRequest('certificate2')->toMediaCollection('tutorscerty2');
			}
			
			
			$Tutor->save();
			return response()->json([
				"success"=> "1",
			"status"=> "200",
				'message' => 'Tutor created Successfully!'
			], 200);
		}
    }
	
}
