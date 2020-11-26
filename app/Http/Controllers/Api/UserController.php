<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\DeviceDetail;
use App\Notifications\SignupActivate;
use Illuminate\Support\Str;
use Validator;
use App\Helpers\CommonHelpers;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller 
{
	/**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] c_password
     * @return [string] phone_number
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);
		
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
			'activation_token' => Str::random(60)
        ]);
		
        $user->save();
		$user->notify(new SignupActivate($user));
		$user = User::where('email', $request->email)->get();
		$device['user_id']=$user[0]->id;
		$device['token']="";
		$device['device_token']="";
		$device['device_type']="android";
		$device['uuid']="";
		$device['ip']="";
		$device['os_version']="";
		$device['model_name']="";
		$device['push_config']="Yes";
		$device['country_name']="Kuwait";
		$device['country_id']="132";
		$device['currency']="Kwd";
		$divdetail = DeviceDetail::create($device);
		$divdetail->save();
        return response()->json([
			"success"=> "1",
			"status"=> "200",
            'message' => trans('user.added'),
			'data'=> [
							'id'=>($user[0]->id == null)? "" : (string)$user[0]->id,
							'name'=>($user[0]->name == null)? "" : $user[0]->name ,
							'email'=>($user[0]->email == null)? "" : $user[0]->email,
							'country_code'=>($user[0]->country_code == null)? "" : $user[0]->country_code,
							'phone_number'=>($user[0]->phone_number == null)? "" : $user[0]->phone_number,
							'user_type'=>($user[0]->user_type == null)? "" : $user[0]->user_type,
							'user_bio'=>($user[0]->user_bio == null)? "" :$user[0]->user_bio ,
							'status'=>($user[0]->status == null)? "" : $user[0]->status,
					]
        ], 200);
    }
	public function signupActivate($token)
	{
		
		$user = User::where('activation_token', $token)->first();
		if (!$user) {
			return response()->json([
				"success"=> "0",
				"status"=> "201",
				'message' => 'This activation token is invalid.'
			], 201);
		}
		$user->active = true;
		$user->activation_token = '';
		$user->save();
		
		return $user;
	}	
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
		$request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
		
        $credentials = request(['email', 'password']);
		$credentials['active'] = 1;
		$credentials['deleted_at'] = null;
		
		$remember = $request->remember_me;
		$useractivation = User::where(['email'=>$request->email,"active"=>1])->count();
		if(!$useractivation)
            return response()->json([
				"success"=> "0",
				"status"=> "202",
                'message' => trans('user.invalid')
            ], 202);
		
		
		if(!Auth::attempt($credentials,$remember))
            return response()->json([
				"success"=> "0",
				"status"=> "201",
                'message' => trans('user.loginFail')
            ], 201);
			
		if(!$remember){
			$updateData = array("remember_token"=>null);
			User::where('id', $request->user()->id)->update($updateData);
		}	
        $user = $request->user();
		
		$tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
		 $remember_me = ($remember == null)? "0" : "1" ;
		 $imgurl = $thumburl = "";
		 if(count($user->getMedia('user')) >0){
				$imgurl = $user->getMedia('user')->last()->getUrl();
				$thumburl =$user->getMedia('user')->last()->getUrl('thumb');
			}
			
			
	
		$device['token']=$tokenResult->accessToken;
		$device['device_token']=$request->device_token;
		$device['device_type']=$request->device_type;
		$device['uuid']=$request->uuid;
		$device['os_version']=$request->os_version;
		$device['model_name']=$request->model_name;	
		$whr = array("user_id"=>$user->id);
		  DeviceDetail::where($whr)->update($device);
        return response()->json([
			
			"success"=> "1",
			"status"=> "200",
			"message"=> trans('user.loginDetail'),
			"data"=> [		'access_token' => $tokenResult->accessToken,
							'token_type' => 'Bearer',
							'expires_at' => Carbon::parse(
								$tokenResult->token->expires_at
								)->toDateTimeString(),
							'id'=>($user->id == null)? "" : (string)$user->id,
							'name'=>($user->name == null)? "" : $user->name ,
							'country_code'=>($user->country_code == null)? "" : $user->country_code,
							'phone_number'=>($user->phone_number == null)? "" : $user->phone_number,
							'email'=>($user->email == null)? "" : $user->email,
							'user_type'=>($user->user_type == null)? "" : $user->user_type,
							'user_bio'=>($user->user_bio == null)? "" :$user->user_bio ,
							'status'=>($user->status == null)? "" : $user->status,	
							'profile_image' => CommonHelpers::getUrl($imgurl),
							//'thumb-profile_image' => str_replace('http://localhost',url("/"),$thumburl),				
							'remember_me'=>$remember_me
							]

        ],200); 
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
			"success"=> "1",
			"status"=> "200",
            'message' => trans('user.logout')
        ],200);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
		$user = $request->user();
		
		$imgurl = $thumburl = "";
		if(count($user->getMedia('user')) >0){
				$imgurl = $user->getMedia('user')->last()->getUrl();
				$thumburl =$user->getMedia('user')->last()->getUrl('thumb');
			}
		 $remember_me = ($user->remember_token == null)? "0" : "1" ;
        return response()->json(["success"=> "1",
						"status"=> "200",
						"message" =>trans('user.getDetail'),
						"data"=> [	
							'id'=>($user->id == null)? "" : (string)$user->id,
							'name'=>($user->name == null)? "" : $user->name ,
							'email'=>($user->email == null)? "" : $user->email,
							'country_code'=>($user->country_code == null)? "" : $user->country_code,
							'phone_number'=>($user->phone_number == null)? "" : $user->phone_number,
							'user_type'=>($user->user_type == null)? "" : $user->user_type,
							'user_bio'=>($user->user_bio == null)? "" :$user->user_bio ,
							'status'=>($user->status == null)? "" : $user->status,
							'profile_image' => CommonHelpers::getUrl($imgurl),
							//'thumb-profile_image' => str_replace('http://localhost',url("/"),$thumburl),							
							'remember_me'=>$remember_me
							]],200);
    }
	
	
	/**
     * update user
     *
     * @param  [string] name |required
     * @param  [string] lastname
     * @param  [string] email |required
     * @param  [string] country_code | required
     * @return [string] phone_number | required
     * @return [string] user_bio 
     * @return [string] current_password 
     * @return [string] new_password | if current_password ~ required
     * @return [string] new_confirm_password | if current_password ~ required
     */
	
	 public function update_User(Request $request)
    {
      $data = $request->all();
	
	 // base64_decode($data['profile_image']);
			
		if(isset($data->current_password))	
		{
			$rules= [
			'name' => 'required|regex:/^[\pL\s\-]+$/u|max:530',
			'email' => 'required',
			'current_password' => 'required',
			'new_password' => 'required',
			];
		}	
		else{
			$rules= [
			'name' => 'required|regex:/^[\pL\s\-]+$/u|max:530',
			'email' => 'required',
			];
		}
		 $validator = Validator::make($request->all(),$rules);  
		
	
		  if ($validator->fails()) {
				 return response()->json([
				 "success"=> "0",
				"status"=> "201",
				'message' => $validator->errors()
				], 201);
			
			}else{
				
				$user = User::where('email', $data->email)->get();
				 if(isset($data->profile_image)) {
						
					$user->addMediaFromRequest('profile_image')->toMediaCollection('user');
					
				}  
				$id =  $user[0]['id'];
				if($user){
					
					if(isset($data->current_password) && $data->current_password !="")
					{
						$updateData = array("name"=>$data->name,
											"country_code"=>$data->country_code,
											"phone_number"=>$data->phone_number,
											"user_bio"=>$data->user_bio,
											"password"=>Hash::make($data->new_password)
											);
											
										
						 if ((Hash::check(request('current_password'), $user[0]['password']) == false)) {
								 return response()->json([
									"success"=> "0",
									"status"=> "201",
									'message' => trans('user.errcurrentpass')
								], 201);
							
							} else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
								 return response()->json([
								 "success"=> "0",
								"status"=> "201",
									'message' => trans('user.errsimilarpass')
								], 201);
								
							} else {
								User::where('id', $id)->update($updateData);
								
								$userdata = User::where('id', $id)->get();
								$imgurl = $thumburl = "";
								if(count($userdata[0]->getMedia('user')) >0){
									$imgurl = $userdata[0]->getMedia('user')->last()->getUrl();
								}
								if($userdata[0]->remember_token){
										$remember_me = "1";
								}else{
									$remember_me = "0";
								}
								
								 return response()->json([
										"success"=> "1",
										"status"=> "200",
										'message' => trans('user.updated'),
										'data'=>['id'=>($userdata[0]->id == null)? "" : (string)$userdata[0]->id,
												'name'=>($userdata[0]->name == null)? "" : $userdata[0]->name ,
												'email'=>($userdata[0]->email == null)? "" : $userdata[0]->email,
												'country_code'=>($userdata[0]->country_code == null)? "" : $userdata[0]->country_code,
												'phone_number'=>($userdata[0]->phone_number == null)? "" : $userdata[0]->phone_number,
												'user_type'=>($userdata[0]->user_type == null)? "" : $userdata[0]->user_type,
												'user_bio'=>($userdata[0]->user_bio == null)? "" :$userdata[0]->user_bio ,
												'status'=>($userdata[0]->status == null)? "" : $userdata[0]->status,
												'profile_image' => CommonHelpers::getUrl($imgurl),
												//'thumb-profile_image' => str_replace('http://localhost',url("/"),$thumburl),
												'remember_me'=>$remember_me ]
									], 200);
							}
						
					}
					else{
						$updateData = array("name"=>$data['name'],
							"country_code"=>(isset($data->country_code)) ? $data->country_code : "",
							"phone_number"=>(isset($data->phone_number)) ? $data->phone_number : "",
							"user_bio"=>$data->user_bio
							);
											
						User::where('id', $id)->update($updateData);
						
						$userdata = User::where('id', $id)->get();
						
						
								if($userdata[0]->remember_token){
										$remember_me = "1";
								}else{
									$remember_me = "0";
								}
								$imgurl = $thumburl = "";
						if(count($userdata[0]->getMedia('user')) >0){
							$imgurl = $userdata[0]->getMedia('user')->last()->getUrl();
						}
						 return response()->json([
												"success"=> "1",
												"status"=> "200",	
												'message' => trans('user.updated'),
												'data'=>['id'=>($userdata[0]->id == null)? "" : (string)$userdata[0]->id,
												'name'=>($userdata[0]->name == null)? "" : $userdata[0]->name ,
												'email'=>($userdata[0]->email == null)? "" : $userdata[0]->email,
												'country_code'=>($userdata[0]->country_code == null)? "" : $userdata[0]->country_code,
												'phone_number'=>($userdata[0]->phone_number == null)? "" : $userdata[0]->phone_number,
												'user_type'=>($userdata[0]->user_type == null)? "" : $userdata[0]->user_type,
												'user_bio'=>($userdata[0]->user_bio == null)? "" :$userdata[0]->user_bio ,
												'status'=>($userdata[0]->status == null)? "" : $userdata[0]->status,
												'profile_image' => CommonHelpers::getUrl($imgurl),
												//'thumb-profile_image' => str_replace('http://localhost',url("/"),$thumburl),			
												'remember_me'=>$remember_me ]
									], 200);						
					}
					
				}
				else{
					 return response()->json([
					 "success"=> "0",
					"status"=> "201",
					'message' => "User not found with our record"
				], 201);
				}
				
			}
	}
	
	 public function updateUser(Request $request)
    {
      $data = $request->all();
	$imgupload = $request->user();
	 // base64_decode($data['profile_image']);
			
		if(isset($data['current_password']))	
		{
			$rules= [
			'name' => 'required|regex:/^[\pL\s\-]+$/u|max:530',
			'email' => 'required',
			'current_password' => 'required',
			'new_password' => 'required',
			];
		}	
		else{
			$rules= [
			'name' => 'required|regex:/^[\pL\s\-]+$/u|max:530',
			'email' => 'required',
			];
		}
		 $validator = Validator::make($request->all(),$rules);  
		
	
		  if ($validator->fails()) {
				 return response()->json([
				 "success"=> "0",
				"status"=> "201",
				'message' => $validator->errors()
				], 201);
			
			}else{
				
				$user = User::where('email', $data['email'])->get();
			
				 if(isset($data['profile_image'])) {
						
					$imgupload->addMediaFromRequest('profile_image')->toMediaCollection('user');
					
				}  
				$id =  $user[0]['id'];
				if($user){
					
					if(isset($data['current_password']) && $data['current_password'] !="")
					{
						$updateData = array("name"=>$data['name'],
											//"lastname"=>$data['lastname'],
											"country_code"=>$data['country_code'],
											"phone_number"=>$data['phone_number'],
											"user_bio"=>$data['user_bio'],
											"password"=>Hash::make($data['new_password'])
											);
											
										
						 if ((Hash::check(request('current_password'), $user[0]['password']) == false)) {
								 return response()->json([
									"success"=> "0",
									"status"=> "201",
									'message' => trans('user.errcurrentpass')
								], 201);
							
							} else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
								 return response()->json([
								 "success"=> "0",
								"status"=> "201",
									'message' => trans('user.errsimilarpass')
								], 201);
								
							} else {
								User::where('id', $id)->update($updateData);
								
								$userdata = User::where('id', $id)->get();
								$imgurl = $thumburl = "";
								if(count($userdata[0]->getMedia('user')) >0){
									$imgurl = $userdata[0]->getMedia('user')->last()->getUrl();
									$thumburl =$userdata[0]->getMedia('user')->last()->getUrl('thumb');
								}
								if($userdata[0]->remember_token){
										$remember_me = "1";
								}else{
									$remember_me = "0";
								}
								
								 return response()->json([
										"success"=> "1",
										"status"=> "200",
										'message' => trans('user.updated'),
										'data'=>['id'=>($userdata[0]->id == null)? "" : (string)$userdata[0]->id,
												'name'=>($userdata[0]->name == null)? "" : $userdata[0]->name ,
												'email'=>($userdata[0]->email == null)? "" : $userdata[0]->email,
												'country_code'=>($userdata[0]->country_code == null)? "" : $userdata[0]->country_code,
												'phone_number'=>($userdata[0]->phone_number == null)? "" : $userdata[0]->phone_number,
												'user_type'=>($userdata[0]->user_type == null)? "" : $userdata[0]->user_type,
												'user_bio'=>($userdata[0]->user_bio == null)? "" :$userdata[0]->user_bio ,
												'status'=>($userdata[0]->status == null)? "" : $userdata[0]->status,
												'profile_image' => CommonHelpers::getUrl($imgurl),
												//'thumb-profile_image' => str_replace('http://localhost',url("/"),$thumburl),
												'remember_me'=>$remember_me ]
									], 200);
							}
						
					}
					else{
						$updateData = array("name"=>$data['name'],
											"country_code"=>(isset($data['country_code'])) ? $data['country_code'] : "",
											"phone_number"=>(isset($data['phone_number'])) ? $data['phone_number'] : "",
											"user_bio"=>$data['user_bio']
											);
											
						User::where('id', $id)->update($updateData);
						
						$userdata = User::where('id', $id)->get();
						
						
								if($userdata[0]->remember_token){
										$remember_me = "1";
								}else{
									$remember_me = "0";
								}
								$imgurl = $thumburl = "";
						if(count($userdata[0]->getMedia('user')) >0){
							$imgurl = $userdata[0]->getMedia('user')->last()->getUrl();
							$thumburl =$userdata[0]->getMedia('user')->last()->getUrl('thumb');
						}
						
						 return response()->json([
												"success"=> "1",
												"status"=> "200",	
												'message' => trans('user.updated'),
												'data'=>['id'=>($userdata[0]->id == null)? "" : (string)$userdata[0]->id,
												'name'=>($userdata[0]->name == null)? "" : $userdata[0]->name ,
												'email'=>($userdata[0]->email == null)? "" : $userdata[0]->email,
												'country_code'=>($userdata[0]->country_code == null)? "" : $userdata[0]->country_code,
												'phone_number'=>($userdata[0]->phone_number == null)? "" : $userdata[0]->phone_number,
												'user_type'=>($userdata[0]->user_type == null)? "" : $userdata[0]->user_type,
												'user_bio'=>($userdata[0]->user_bio == null)? "" :$userdata[0]->user_bio ,
												'status'=>($userdata[0]->status == null)? "" : $userdata[0]->status,
												'profile_image' => CommonHelpers::getUrl($imgurl),
												//'thumb-profile_image' => str_replace('http://localhost',url("/"),$thumburl),			
												'remember_me'=>$remember_me ]
									], 200);						
					}
					
				}
				else{
					 return response()->json([
					 "success"=> "0",
					"status"=> "201",
					'message' => "User not found with our record"
				], 201);
				}
				
			}
	}
	public function uploadImage(Request $request)
	{
		$user = $request->user();
		//$user = $request->all();
		//print_r($user);exit;
		$user->addMediaFromRequest('profile_image')->toMediaCollection('user');
		//$image = Storage::disk('public')->put($request->file('	'));

		$updatedata=array(
			"model_type"=>"App\Models\User",
			"model_id"=>$user->id,
			"collection_name"=>"user",
			"name"=>"abc",
			"file_name"=>"abc.jpg",
			"mime_type"=>"image/jpeg",
			"disk"=>"public",
			"size"=>"",
			"order_column"=>"same insert id"
		);
		$file = base64_decode($user->profile_file);
	
		$mime= finfo_buffer(finfo_open(), $file, FILEINFO_MIME_TYPE);
		$ex = pathinfo($mime, PATHINFO_EXTENSION);
		
		$ext = ".png";
		
		$fn = uniqid() .'.'.$ext;
		$fd=uniqid() .'.'.$ext;	
			file_put_contents($fd,$file);
		// $user->addMediaFromRequest('file')->toMediaCollection('user');
		
	}
	
}