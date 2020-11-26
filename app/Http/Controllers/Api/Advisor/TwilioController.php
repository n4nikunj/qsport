<?php

namespace App\Http\Controllers\Api\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Http\Controllers\Api\BaseController;
use App\Models\Helpers\TwilioHelpers;
use Twilio\Rest\Client;
use Validator;
use Auth;
use App\Models\Setting;
use App\Models\User;
use App\Models\CallLog;
use Twilio\TwiML\VoiceResponse;

class TwilioController extends Controller
{
    use TwilioHelpers;


    /**
    * Advisor Twilio Token
    * @return \Illuminate\Http\Response
    */
    public function advisor_twilio_token(Request $request){


  $user =  $request->user();
     
        $token = $this->advisorToken($user->userid,"android");

        if(empty($token) || $token['code'] == '205'){
           return $this->sendError($this->object,$token['message']);
        }

        if($token['code'] == '200'){

            $response = array();
            $response['twilio_token'] = $token['token'];
			
			
			return response()->json([
				"success"=> "1",
				"status"=> "200",
				'message' => "Twilio Token",
				"data"=>array(
				"twilio_token"=>(string)$token['token']
				)
			], 200);
        }else{
            return response()->json([
				"success"=> "0",
				"status"=> "201",
				'message' => "Something went wrongs",
				"data"=>array(
				"twilio_token"=>""
				)
			], 201);
        }
    }

    /**
    * Client Twilio Token
    * @return \Illuminate\Http\Response
    */
    public function client_twilio_token(Request $request){

        $validator = Validator::make($request->all(),[
            'type' => 'required|in:ios,android'
        ]);

        if($validator->fails()){
          return $this->sendError($this->object, $validator->errors()->first());       
        }

        $user = Auth::user();
       
        $token = $this->clientToken($user->id,$request->type);

        if(empty($token) || $token['code'] == '205'){
           return $this->sendError($this->object,$token['message']);
        }

        if($token['code'] == '200'){

            $response = array();
            $response['twilio_token'] = $token['token'];

            return $this->sendResponse($response,$token['message']);
        }else{
            return $this->sendError($this->object,'Something went wrong');
        }
    }

     /**
    * Twilio Token
    * @return \Illuminate\Http\Response
    */
    public function twilio_chat_token(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
        ]);

         if($validator->fails()){
          return $this->sendError($this->object, $validator->errors()->first());       
        }
       
        $token = $this->createChatToken($request->name);

        if(empty($token) || $token['code'] == '205'){
           return $this->sendError($this->object,$token['message']);
        }

        if($token['code'] == '200'){

            $response = array();
            $response['twilio_token'] = $token['token'];

            return $this->sendResponse($response,$token['message']);
        }else{
            return $this->sendError($this->object,'Something went wrong');
        }
    }  

    public function twilio_call_token(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
        ]);

         if($validator->fails()){
          return $this->sendError($this->object, $validator->errors()->first());       
        }
       
        $token = $this->createCallToken($request->name);

        if(empty($token) || $token['code'] == '205'){
           return $this->sendError($this->object,$token['message']);
        }

        if($token['code'] == '200'){

            $response = array();
            $response['twilio_call_token'] = $token['token'];

            return $this->sendResponse($response,$token['message']);
        }else{
            return $this->sendError($this->object,'Something went wrong');
        }
    }

    /**
    * Twilio Token
    * @return \Illuminate\Http\Response
    */
    public function twilio_token(Request $request){

       /*  $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'type' => 'required|in:ios,android'
        ]);

         if($validator->fails()){
          return $this->sendError($this->object, $validator->errors()->first());       
        } */
      $user =  $request->user();
        $token = $this->createToken($user->name,"android");

        if(empty($token) || $token['code'] == '205'){
           return $this->sendError($this->object,$token['message']);
        }

        // print_r($token);
        // exit;

        if($token['code'] == '200'){

            $response = array();
            $response['twilio_token'] = $token['token'];

            return $this->sendResponse($response,$token['message']);
        }else{
            return $this->sendError($this->object,'Something went wrong');
        }
    }

    public function makeCall(Request $request){

        // try{

            $app_settings = Setting::pluck('value', 'name')->all();

            // Your Account SID and Auth Token from twilio.com/console
            $account_sid   =  $app_settings['twilio_account_sid'];
            $auth_token    =  $app_settings['twilio_auth_token'];
           
            // A Twilio number you own with Voice capabilities
            $twilio_number =  $app_settings['twilio_phone_number'];

            if($request->to != null){
                $to   = $request->to;
            }else{
                $to   = 'dummyto';
            }

            if($request->from != null){
                 $from = $request->from;
            }else{
                 $from = 'quick_start';
            }

            //Caller Name
            $from_name =  User::find($request->from);

            if($from_name == null){
                $caller_name = 'quick_start';
            }else{
                $caller_name = $from_name->name;
            }

            //Calling Name
            $to_name =  User::find($request->to);

            if($to_name == null){
                $calling_name = 'dummyto';
            }else{
                $calling_name = $to_name->name;
            }

            // $log = new CallLog();
            // $log->client_from = $from;
            // $log->client_to = $to;
            // $log->type = 'outgoing';
            // $log->save(); 
           
            $response = new \Twilio\Twiml();
            $dial = $response->dial('',['callerId' => 'client:'.$from,'answerOnBridge'=>'true']);
            // $dial->client($to);
            $client   = $dial->client($to);
            $identity = $client->Identity($to);

            $client->parameter([
                 "name" => "from_name",
                 "value" => $caller_name,
            ]);

            $client->parameter([
                "name"  => "to_name",
                "value" => $calling_name,
            ]);
    
            echo $response;

        // }catch(\Exception $e){
        //     return $this->sendError('',$e->getMessage());
        // } 
    }

    public function placeCall(Request $request){

        try{

            $app_settings = Setting::pluck('value', 'name')->all();
            // Your Account SID and Auth Token from twilio.com/console
            $api_key       =  $app_settings['twilio_api_key'];
            $api_secret    =  $app_settings['twilio_api_secret'];
            $account_sid   =  $app_settings['twilio_account_sid'];
            $auth_token    =  $app_settings['twilio_auth_token'];
           
            // A Twilio number you own with Voice capabilities
            $twilio_number =  $app_settings['twilio_phone_number'];

            // Where to make a voice call (your cell phone?)
            if($request->to != null){
                $to   = $request->to;
            }else{
                $to   = 'dummyto';
            }

            if($request->from != null){
                 $from = $request->from;
            }else{
                 $from = 'quick_start';
            }

            $log = new CallLog();
            $log->client_from = $from;
            $log->client_to = $to;
            $log->type = 'incoming';
            $log->save(); 
           
            $client = new Client($api_key,$api_secret,$account_sid);
            $call = $client->calls->create(  
               'client:'.$to,
               'client:'.$from,
                array(
                    // "url" => 'https://handler.twilio.com/twiml/EH8c56bf3d68a71f749de190eb9b40311d?to='.$to
                    "url" => route('twilio.dial_code',$to)
                     // "twiml" => "<Response>Dial><Client>".$to."</Client></Dial></Response>"
                )
            );
        
           echo $call->sid;

        }catch(\Exception $e){
            return $this->sendError('',$e->getMessage());
        } 
    }

    public function dialCall($to){

        $response = new \Twilio\Twiml();
        $dial = $response->dial('',['answerOnBridge'=>'true']);
        $dial->client($to);
        
        echo $response;
    }  
}
