<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\ChatChannel;
use Validator;
class ChatController extends Controller
{
    //
	
	public function getToken(request $request){
		
		$setting = Setting::pluck('value', 'name')->all();
		//$setting = Setting::where('status', 'active')->get();
		//	$token = "";
		/* foreach($setting as $val){
			if($val->name=="TWILIO_AUTH_TOKEN"){
				$token = (string)$val->value;
			}
		} */
	//	print_r($setting);exit;
		$id = $setting['TWILIO_AUTH_SID'];
		$token = $setting['TWILIO_AUTH_TOKEN'];
		$user = $request->user();
			
		$data = array (
			'type' => "android",
			'userID' => $user->id
		);
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://127.0.0.1:8000/api/twillio/accessToken',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $data,
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
		
		print_r($response);
		exit;
		
		
		return response()->json([
				"success"=> "1",
				"status"=> "200",
				'message' => "Twilio Token",
				"data"=>array(
				"twilio_token"=>(string)$token
				)
			], 200);
	}
	public function chatToken(request $request)
	{
		echo "asdf";exit;
	}
	public function createChannel(request $request)
	{
		$data = $request->all();
		
		
		$rules= [
        'created_by' => 'required',
        'joined_by' => 'required',
        'create_chat_module' => 'required',
        'channel_unique_name' => 'required',
        'channel_sid' => 'required',
		];
		 
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
	   }
		
		
		
		$chennel = ChatChannel::create($data);
		$chennel->save();
		$response = array("created_by"=> (string)$data['created_by'],
							"joined_by"=>(string)$data['joined_by'],
							"create_chat_module"=>(string)$data['create_chat_module'],
							"channel_unique_name"=> (string)$data['channel_unique_name'],
							"channel_sid"=> (string)$data['channel_sid']
						);
		
		return response()->json([
				"success"=> "1",
				"status"=> "200",
				'message' => "New chat channel has been created",
				"data"=>$response
			], 200);
		
	}
	public function myMessage(request $request){
		
	
		$user = $request->user();
			
			$message = ChatChannel::where('created_by',$user->id)->orwhere("joined_by",$user->id)->get();
			$result = array();
			$response = array();
			foreach($message as $val)
			{
				$result= array(
				  "user_id"=> (string)$user->id,
				  "user_profile"=> (string)"",
				  "user_name"=> (string)$user->name,
				  "last_message"=> (string)$val->last_message,
				  "last_message_date"=> (string)$val->last_message_date,
				  "channel_unique_name"=> (string)$val->channel_unique_name,
				  "channel_sid"=> (string)$val->channel_sid,
					);
				$response[] = $result;		
			}
		
		
		
		
		return response()->json([
				"success"=> "1",
				"status"=> "200",
				'message' => "Twilio Token",
				"data"=>$response
			], 200);
	}
	public function updateLastMessage(request $request)
	{
		$data = $request->all();
		
		$rules= [
       
        'channel_sid' => 'required',
		];
		 
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
	   }
			
			$where =array("channel_sid"=>$data['channel_sid']);
			$updateData['last_message']=$data['message'];
			$updateData['last_message_date']=$data['message_date'];
			ChatChannel::where($where)->update($updateData);
			
			return response()->json([
					"success"=> "1",
				  "status"=> "200",
				  "message"=> "Message has been updated successfully",
				  "data"=>array()
			], 200);
		
	}
}
