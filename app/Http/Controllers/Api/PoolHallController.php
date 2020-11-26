<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PoolHall; 
use Validator;
use App\Helpers\CommonHelpers;

class PoolHallController extends Controller
{
    /**
     * Get Sports List
     *
     * @return [Json] poolhall object
     */
	
    public function list_()
    {
		$poolhall = PoolHall::select('id')->where('status', 'active')->get();
		if (!$poolhall) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => trans('poolhall.empty'),
				"data"=>array()
			], 200);
		}
		
		

			
		$data = array();
		 foreach ($poolhall as $val) {
			 
			 $imgurl = $imgurl1 = $imgurl2="";
			$userdata = poolhall::where('id', $val->id)->get();
			if(count($userdata[0]->getMedia('poolhall_image')) >0){
				$imgurl = $userdata[0]->getMedia('poolhall_image')->last()->getUrl();
				
			}
		
			 
			 $result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			 $result['title'] = ($val["title"] == null)? "" : $val["title"];
			 $result['description'] = ($val["description"] == null)? "" : $val["description"];
			 $result['address'] = ($val["address"] == null)? "" : $val["address"];
			$result['poolhallImage'] = CommonHelpers::getUrl($imgurl);
			
			 $data[] = $result;
		 }
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=> $data],200
		);
		
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
			'title' => 'required',
			'description' => 'required|min:50|max:500',
			'address' => 'required',
			'country_id' => 'required',
			'number_of_tables' => 'required|numeric',
			'email' => 'required|email|min:5|max:100',
			'country_code' => 'required',
			'phone_number' => 'required|numeric|digits:10',
			'start_time' => 'required|date_format:h:iA',
			'end_time' => 'required|date_format:h:iA|after:start_time',
			'poolhallimg' => 'required',
		];
		 $customMessages = [
        'date_format' => 'The :attribute field does not match with 12 Hrs time formate like 09:00AM'
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
		
		$data['social_media_link']="http://www.facebook.com";
		$data['price']=0;
		$data['latitude']="";
		$data['longitude']="";
		$data['types_of_tables']="";
		$data['start_time']=date("H:i", strtotime($data['start_time']));
		$data['end_time']=date("H:i", strtotime($data['end_time']));
		$data['created_at'] =date("Y-m-d");
		$data['updated_at'] = date("Y-m-d");
		$data['created_by'] = $user->id;
		
		$poolhall = PoolHall::create($data);
		
		if(isset($data['poolhallimg'])) {
				$poolhall->addMediaFromRequest('poolhallimg')->toMediaCollection('poolhall_image');
			}
		if(isset($data['poolhallimg1'])) {
			$poolhall->addMediaFromRequest('poolhallimg1')->toMediaCollection('poolhall_image1');
		}
		if(isset($data['poolhallimg2'])) {
			$poolhall->addMediaFromRequest('poolhallimg2')->toMediaCollection('poolhall_image2');
		}
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Pool Hall created Successfully! "
        ], 200);

		
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
			'price' => 'required'
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
			 $poolhall = PoolHall::find($id);
			 $poolhall->update($data);
			 return response()->json([
				"success"=> "1",
			"status"=> "200",
				 'message' => 'Successfully updated poolhall!'
			 ], 200);
		 }
     }
	public function detail(Request $request)
    {	
		$poolhall = PoolHall::with('countries')->find($request->id);
		if (!$poolhall) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => trans('poolhall.empty'),
				"data"=>array()
			], 200);
		}
		
			$imgurl = $thumburl = "";
			
			$userdata = poolhall::where('id', $request->id)->get();
	
			$imgurl = $imgurl1 = $imgurl2="";
			
			if(count($userdata[0]->getMedia('poolhall_image')) >0){
				$imgurl = $userdata[0]->getMedia('poolhall_image')->last()->getUrl();
				
			}
			if(count($userdata[0]->getMedia('poolhall_image1')) >0){
				$imgurl1 = $userdata[0]->getMedia('poolhall_image1')->last()->getUrl();
				
			}
			if(count($userdata[0]->getMedia('poolhall_image2')) >0){
				$imgurl2 = $userdata[0]->getMedia('poolhall_image2')->last()->getUrl();
				
			}
			
			
			
			
			
			 $result['id'] = ($poolhall->id == null)? "" : (string)$poolhall->id;
			 $result['title'] = ($poolhall->title == null)? "" : $poolhall->title;
			 $result['address'] = ($poolhall->address == null)? "" : $poolhall->address;
			 $result['description'] = ($poolhall->description == null)? "" : $poolhall->description;
			 $result['email'] = ($poolhall->email == null)? "" : $poolhall->email;
			 $result['country_code'] = ($poolhall->country_code == null)? "" : $poolhall->country_code;
			 $result['phone_number'] = ($poolhall->phone_number == null)? "" : $poolhall->phone_number;
			 $result['number_of_tables'] = ($poolhall->number_of_tables == null)? "" : $poolhall->number_of_tables;
			 $result['start_time'] = ($poolhall->start_time == null)? "" : date("h:iA", strtotime($poolhall->start_time));
			 $result['end_time'] = ($poolhall->end_time == null)? "" : date("h:iA", strtotime($poolhall->end_time));
			 $result['more_info'] = ($poolhall->more_info == null)? "" : $poolhall->more_info;
			
			 $result['poolhallImage'] = CommonHelpers::getUrl($imgurl);
			$result['poolhallImage1'] = CommonHelpers::getUrl($imgurl1);
			$result['poolhallImage2'] = CommonHelpers::getUrl($imgurl2);
			 
			 $data[] = $result;
			 
			 
			 
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=> $result],200);
    }
	public function list(Request $request)
    {	
		$rules= [
			'country_id' => 'required',
		];
			
       $validator = Validator::make($request->all(),$rules);  
        if ($validator->fails()) {
		  return response()->json([
		  "success"=> "0",
				"status"=> "201",
             'message' => $validator->errors()
         ], 201);
        
		 }
	
		 $searchValue = (isset($request->search))? $request->search : ""; 
		 $country_id = $request->country_id; 
	
        $query = new PoolHall();
   
       
        ## Total number of record with filtering
         $filter = $query;
		$query = new PoolHall();
		
		 $filter = $query;
        if($searchValue != ''){
        $filter = $filter->where(function($q)use ($searchValue,$country_id) {
                            $q->whereHas('translation',function($query) use ($searchValue){
                                    $query->where('title','like','%'.$searchValue.'%')
									->orWhere('address','like','%'.$searchValue.'%')
									;
                                        })
								 ->Where('country_id',$country_id)
								->where('status', 'active');			
								});
        }else{
			$filter = PoolHall::select('id')->where('status', 'active')->Where('country_id',$country_id);
		}
		
		
	//	print_r($filter->with('translations')->get());exit;
		
		//$filter =  PoolHall::with('translations')->where('title', 'like', 't%')->get();
		$res = $filter->get();
		
			if (count($res) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' =>"Data not found",
				"data"=>array()
			], 200);
		}
		
		
		$data=array();
		foreach($res as $val)
		{
			 $imgurl = $imgurl1 = $imgurl2="";
			$userdata = poolhall::where('id', $val->id)->get();
			if(count($userdata[0]->getMedia('poolhall_image')) >0){
				$imgurl = $userdata[0]->getMedia('poolhall_image')->last()->getUrl();
				
			}
		
			 
			 $result['id'] = ($val["id"] == null)? "" : (string)$val["id"];
			 $result['title'] = ($val["title"] == null)? "" : $val["title"];
			 $result['description'] = ($val["description"] == null)? "" : $val["description"];
			 $result['address'] = ($val["address"] == null)? "" : $val["address"];
			$result['poolhallImage'] = CommonHelpers::getUrl($imgurl);
			
			 $data[] = $result;
		}
		
	
		
			 
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "PoolHall data got successfully",
			"data"=> $data],200);
    }
}
