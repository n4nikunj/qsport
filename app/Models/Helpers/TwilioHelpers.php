<?php

namespace App\Models\Helpers;

use Twilio\Jwt\ClientToken;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\VoiceGrant;
// use GuzzleHttp\Exception\GuzzleException;
// use GuzzleHttp\Client;
use App\Models\Setting;
use Twilio\Rest\Client;
use DB;

trait TwilioHelpers
{

    public static function advisorToken($id,$type)
    {
        $app_settings = Setting::pluck('value', 'name')->all();
		
		//print_r($app_settings);exit;
		

        if($app_settings['TWILIO_AUTH_SID'] == null || $app_settings['TWILIO_AUTH_TOKEN'] == null ){
   
            $response = array('code'=>'205','message'=>trans('auth.twilio_account'),'token'=>'');
            return $response;    
        }

        // Required for all Twilio access tokens
        $twilioAccountSid = $app_settings['TWILIO_AUTH_SID'];
        $twilioApiKey     = $app_settings['TWILIO_API_KEY'];
        $twilioApiSecret  = $app_settings['TWILIO_API_SECRET'];

        // Required for Chat grant
        $serviceSid = $app_settings['TWILLIO_CHAT_SID'];

        // Required for Voice grant
        $outgoingApplicationSid = $app_settings['TWILLIO_CHAT_SID'];
    
      /*   if($type == 'ios'){
            $ios_chat_sid    = $app_settings['ios_chat_advisor_key'];
            $ios_call_sid    = $app_settings['ios_call_advisor_key'];
        }else{
            $android_chat_id = $app_settings['android_chat_advisor_key'];
            $android_call_id = $app_settings['android_call_advisor_key'];
        } */
         
        // choose a random username for the connecting user
        $identity = $id;

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            28800,
            $identity
        );

        // Create Chat grant
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid($serviceSid);
       /*  if($type == 'ios'){
            $chatGrant->setPushCredentialSid($ios_chat_sid);
        }else{
            $chatGrant->setPushCredentialSid($android_chat_id);
        } */

        // Create Voice grant
        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid($outgoingApplicationSid);
 /*
        if($type == 'ios'){
            $voiceGrant->setPushCredentialSid($ios_call_sid);
        }else{
            $voiceGrant->setPushCredentialSid($android_call_id);
        } */
        
       
        $voiceGrant->setIncomingAllow(true);

        // Add grant to token
        $token->addGrant($chatGrant);
        $token->addGrant($voiceGrant);

        // render token to string
        $response = array('code'=>'200','message'=>'Access Token','token'=>$token->toJWT());
		
            return $response;
        return $response;
    }

    public static function clientToken($id,$type)
    {
        $app_settings = Setting::pluck('value', 'name')->all();

        if($app_settings['twilio_account_sid'] == null || $app_settings['twilio_auth_token'] == null || $app_settings['twilio_phone_number'] == null){
   
            $response = array('code'=>'205','message'=>trans('auth.twilio_account'),'token'=>'');
            return $response;    
        }

        // Required for all Twilio access tokens
        $twilioAccountSid = $app_settings['twilio_account_sid'];
        $twilioApiKey     = $app_settings['twilio_api_key'];
        $twilioApiSecret  = $app_settings['twilio_api_secret'];

        // Required for Chat grant
        $serviceSid = $app_settings['twilio_chat_sid'];

        // Required for Voice grant
        $outgoingApplicationSid = $app_settings['twilio_call_sid'];
    
        if($type == 'ios'){
            $ios_chat_sid    = $app_settings['ios_chat_client_key'];
            $ios_call_sid    = $app_settings['ios_call_client_key'];
        }else{
            $android_chat_id = $app_settings['android_chat_client_key'];
            $android_call_id = $app_settings['android_call_client_key'];
        }

        // choose a random username for the connecting user
        $identity = $id;

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            28800,
            $identity
        );

        // Create Chat grant
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid($serviceSid);
        if($type == 'ios'){
            $chatGrant->setPushCredentialSid($ios_chat_sid);
        }else{
            $chatGrant->setPushCredentialSid($android_chat_id);
        }

        // Create Voice grant
        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid($outgoingApplicationSid);

        if($type == 'ios'){
            $voiceGrant->setPushCredentialSid($ios_call_sid);
        }else{
            $voiceGrant->setPushCredentialSid($android_call_id);
        }
        
        $voiceGrant->setIncomingAllow(true);

        // Add grant to token
        $token->addGrant($chatGrant);
        $token->addGrant($voiceGrant);

        // render token to string
        $response = array('code'=>'200','message'=>'Access Token','token'=>$token->toJWT());
            return $response;
        return $response;
    }

    public static function createToken($name,$type)
    {
        $app_settings = Setting::pluck('value', 'name')->all();

        if($app_settings['twilio_account_sid'] == null || $app_settings['twilio_auth_token'] == null || $app_settings['twilio_phone_number'] == null){
   
            $response = array('code'=>'205','message'=>trans('auth.twilio_account'),'token'=>'');
            return $response;    
        }

        // Required for all Twilio access tokens
        $twilioAccountSid = $app_settings['twilio_account_sid'];
        $twilioApiKey     = $app_settings['twilio_api_key'];
        $twilioApiSecret  = $app_settings['twilio_api_secret'];

        // Required for Chat grant
        $serviceSid = $app_settings['twilio_chat_sid'];

        // Required for Voice grant
        $outgoingApplicationSid = $app_settings['twilio_call_sid'];
        // $push_sid = 'CRd7f7cd8582354816e01306b38b359eab';
        if($type == 'ios'){
            $ios_sid    = $app_settings['advisor_ios_push_key'];
        }else{
            $android_id = $app_settings['advisor_android_push_key'];
        }
         
         
        // choose a random username for the connecting user
        $identity = $name;

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            28800,
            $identity
        );

        // Create Chat grant
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid($serviceSid);
        if($type == 'ios'){
            $chatGrant->setPushCredentialSid($ios_sid);
        }else{
            $chatGrant->setPushCredentialSid($android_id);
        }

        // Create Voice grant
        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid($outgoingApplicationSid);

        if($type == 'ios'){
            $voiceGrant->setPushCredentialSid($ios_sid);
        }else{
            $voiceGrant->setPushCredentialSid($android_id);
        }
        
       
        $voiceGrant->setIncomingAllow(true);

        // Add grant to token
        $token->addGrant($chatGrant);
        $token->addGrant($voiceGrant);

        // render token to string
        $response = array('code'=>'200','message'=>'Access Token','token'=>$token->toJWT());
            return $response;
        return $response;
    }

    public static function chatDetails()
    {
        $app_settings = Setting::pluck('value', 'name')->all();

        // if($app_settings['twilio_account_sid'] == null || $app_settings['twilio_auth_token'] == null){
   
        //     $response = array('code'=>'205','message'=>trans('auth.twilio_account'),'data'=>'');
        //     return $response;    
        // }

        // Required for all Twilio access tokens
        $account_sid    = $app_settings['twilio_account_sid'];
        $auth_token     = $app_settings['twilio_auth_token'];
        $service_sid    = $app_settings['twilio_chat_sid'];
       
        $twilio         = new Client($account_sid, $auth_token);

        $channel        = $twilio->chat->v2->services($service_sid)
                            ->update(array(
                                         "notificationsNewMessageEnabled" => True,
                                         "notificationsNewMessageSound" => "default",
                                         "notificationsNewMessageTemplate" => "New Message Arrived"
                                     )
                            );
        

        // Return data
        $response = $channel;
            
        return $response;
    }

     public static function channelDetails($sid)
    {
        $app_settings = Setting::pluck('value', 'name')->all();

        // if($app_settings['twilio_account_sid'] == null || $app_settings['twilio_auth_token'] == null){
   
        //     $response = array('code'=>'205','message'=>trans('auth.twilio_account'),'data'=>'');
        //     return $response;    
        // }

        // Required for all Twilio access tokens
        $account_sid    = $app_settings['twilio_account_sid'];
        $auth_token     = $app_settings['twilio_auth_token'];
        $service_sid    = $app_settings['twilio_chat_sid'];
       
        $twilio         = new Client($account_sid, $auth_token);

        DB::beginTransaction();
        try{

            $channel        = $twilio->chat->v2->services($service_sid)
                                ->channels($sid)
                                ->fetch();


            // Return data
            $response = $channel;
                
            return $response;

        }catch(\Exception $e){

            $response = '0';
            return $response;
        
        }
    }

      public static function messageDetails($sid,$mid)
    {
        $app_settings = Setting::pluck('value', 'name')->all();

        // if($app_settings['twilio_account_sid'] == null || $app_settings['twilio_auth_token'] == null){
   
        //     $response = array('code'=>'205','message'=>trans('auth.twilio_account'),'data'=>'');
        //     return $response;    
        // }

        // Required for all Twilio access tokens
        $account_sid    = $app_settings['twilio_account_sid'];
        $auth_token     = $app_settings['twilio_auth_token'];
        $service_sid    = $app_settings['twilio_chat_sid'];    
    
        $twilio         = new Client($account_sid, $auth_token);

        $channel        = $twilio->chat->v2->services($service_sid)
                            ->channels($sid)
                            ->messages($mid)
                            ->fetch();

        // Return data
        $response = $channel;
            
        return $response;
    }

    public static function createChatToken($name)
    {
        $app_settings = Setting::pluck('value', 'name')->all();

        if($app_settings['twilio_account_sid'] == null || $app_settings['twilio_auth_token'] == null || $app_settings['twilio_phone_number'] == null){
   
            $response = array('code'=>'205','message'=>trans('auth.twilio_account'),'token'=>'');
            return $response;    
        }

        // Required for all Twilio access tokens
        $twilioAccountSid = $app_settings['twilio_account_sid'];
        $twilioApiKey = 'SK1f25ac1031918e75cdf101c411b5fab7';
        $twilioApiSecret = 'p1vgCaxiieJvwZyNO4ZBrxPCAifZ3cTy';

        // Required for Chat grant
        $serviceSid = 'IS79c0c8a585f34858a5e9b0135b4293e3';
        // choose a random username for the connecting user
        $identity = $name;


        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            28800,
            $identity
        );

        // Create Chat grant
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid($serviceSid);

        // Add grant to token
        $token->addGrant($chatGrant);

        // render token to string
        $response = array('code'=>'200','message'=>'Access Token','token'=>$token->toJWT());
            return $response;
        return $response;
    }

    public static function createCallToken($name)
    {
        $app_settings = Setting::pluck('value', 'name')->all();

        if($app_settings['twilio_account_sid'] == null || $app_settings['twilio_auth_token'] == null || $app_settings['twilio_phone_number'] == null){
   
            $response = array('code'=>'205','message'=>trans('auth.twilio_account'),'token'=>'');
            return $response;    
        }

        // Required for all Twilio access tokens
        $twilioAccountSid = $app_settings['twilio_account_sid'];
        $twilioApiKey = 'SK1f25ac1031918e75cdf101c411b5fab7';
        $twilioApiSecret = 'p1vgCaxiieJvwZyNO4ZBrxPCAifZ3cTy';

        // Required for Voice grant
        $outgoingApplicationSid = 'AP469ad8e03f9864bc5433be2bb0bd054e';

        // choose a random username for the connecting user
        $identity = $name;

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            28800,
            $identity
        );

        // Create Voice grant
        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid($outgoingApplicationSid);
        $voiceGrant->setPushCredentialSid($push_sid);
        $voiceGrant->setIncomingAllow(true);

        // Add grant to token
        $token->addGrant($voiceGrant);

        // render token to string
        $response = array('code'=>'200','message'=>'Access Token','token'=>$token->toJWT());
            return $response;
        return $response;
    }

}
