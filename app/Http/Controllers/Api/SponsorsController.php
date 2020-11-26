<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsors; 
use Validator;
use Carbon\Carbon;
use App\Helpers\CommonHelpers;

class SponsorsController extends Controller
{
    /**
     * Get Sports List
     *
     * @return [Json] sponsor object
     */
	
    public function list()
    {
		$sponsor = Sponsors::select('id','name','sponsors_category')->where('status', 'active')->where('publishDuration', '<', Carbon::now()->startOfDay())->get();
		if (!$sponsor) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => trans('sponsor.empty'),
				"data"=>array()
			], 200);
		}
		
		
		$data['Premium']= array();
		$data['Standard']= array();
		 foreach ($sponsor as $val) {
			 
			 $imgurl = "";
			$userdata = Sponsors::where('id', $val->id)->get();
			if(count($userdata[0]->getMedia('sponsor_logo')) >0){
				$imgurl = $userdata[0]->getMedia('sponsor_logo')->last()->getUrl();
				
			}
		
			 
			 $result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			 $result['name'] = ($val["name"] == null)? "" : $val["name"];
			$result['sponsorImage'] = CommonHelpers::getUrl($imgurl);
			
			 $data[$val["sponsors_category"]][] = $result;
		 }
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> trans('sponsor.dataFond'),
			"data"=> $data],200
		);
		
		
    }
	public function create(Request $request)
    {
		$user = $request->user();
		$rules= [
        'name' => 'required',
        'website' => 'required|url',
        'country_code' => 'required',
        'phone_number' => 'required|numeric|digits:10',
        'email' => 'required|email',
        'sponsors_category' => 'in:Standard,Premium',
        'publishDuration' => 'required'
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        
		}else{
			$data = $request->all();
			
			$data['user_id'] = $user->id;
			$data['amountPaid'] = "0";
			$data['status'] = "Active";
			
			
			$sponsor = Sponsors::create($data);
			
			if(isset($data['sponsorLogo'])) {
				$sponsor->addMediaFromRequest('sponsorLogo')->toMediaCollection('sponsor_logo');
			}
			
			
			$sponsor->save();
			
		
		
				$imgurl = $sponsor->getMedia('sponsor_logo')->last()->getUrl();
				
		$data['sponsorLogo'] = CommonHelpers::getUrl($imgurl);
			
			
			
			return response()->json([
				"success"=> "1",
				"status"=> "200",
				'message' => trans('sponsors.createSuccess')
			], 200);
		}
		
		
    }
	
	public function detail(request $request)
    {	
		$sponsor = Sponsors::find($request->id);
		if (empty($sponsor)) {
			return response()->json([
				"success"=> "1",
				"status"=> "200",
				'message' => trans('sponsor.empty'),
				"data"=>array()
			], 200);
		}
		
		 $imgurl = "";
			
			if(count($sponsor->getMedia('sponsor_logo')) >0){
				$imgurl = $sponsor->getMedia('sponsor_logo')->last()->getUrl();
				
			}
		
		$data = array();
		
			 
			
			 
			 $result['id'] = (string)$sponsor->id;
			 $result['fullName'] = (string)$sponsor["name"];
			 $result['sponsors_category'] = (string)$sponsor["sponsors_category"];
			 $result['website'] = (string)$sponsor["website"];
			 $result['phone_number'] = (string)$sponsor["phone_number"];
			 $result['country_code'] = (string)$sponsor["country_code"];
			 $result['email'] = (string)$sponsor["email"];
			 $result['publishDuration'] = (string)$sponsor["publishDuration"];
			 $result['sponsorImage'] = CommonHelpers::getUrl($imgurl);
			
			
		 
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Sponsors got successfully",
			"data"=> $result],200
		);
		
		
        return response()->json($sponsor);
    }
	
}
