<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\SignupActivate;
use Illuminate\Support\Str;
use Validator;
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
            'password' => 'required|string|confirmed',
			'phone_number'=> 'required',
        ]);
		
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
			'phone_number'=>$request->phone_number,
			'activation_token' => Str::random(60)
        ]);
        $user->save();
		$user->notify(new SignupActivate($user));
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
	public function signupActivate($token)
	{
		
		$user = User::where('activation_token', $token)->first();
		if (!$user) {
			return response()->json([
				'message' => 'This activation token is invalid.'
			], 404);
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
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
		$tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
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
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
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
	
	
	 public function updateUser(Request $request)
    {
      $data = $request->all();
			
		if(isset($data['current_password']))	
		{
			$rules= [
			'name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
			'phone_number' => 'required',
			'email' => 'required',
			'current_password' => 'required',
			'new_password' => 'required',
			'new_confirm_password' => 'required|same:new_password',
			];
		}	
		else{
			$rules= [
			'name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
			'email' => 'required',
			'phone_number' => 'required'
			];
		}
		 $validator = Validator::make($request->all(),$rules);  
		
		  if ($validator->fails()) {
				 return response()->json([
					'message' => $validator->errors()
				], 400);
			
			}else{
				
				$user = User::where('email', $data['email'])->get();
				$id =  $user[0]['id'];
				if($user){
					
					if(isset($data['current_password']))
					{
						$updateData = array("name"=>$data['name'],
											"lastname"=>$data['lastname'],
											"country_code"=>$data['country_code'],
											"phone_number"=>$data['phone_number'],
											"user_bio"=>$data['user_bio'],
											"password"=>Hash::make($data['new_password'])
											);
											
										
						 if ((Hash::check(request('current_password'), $user[0]['password']) == false)) {
								 return response()->json([
									'message' => 'Check your old password!'
								], 400);
							
							} else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
								 return response()->json([
									'message' => 'Please enter a password which is not similar then current password!'
								], 400);
								
							} else {
								User::where('id', $id)->update($updateData);
								 return response()->json([
										'message' => 'User data successfully updated!'
									], 201);
							}
						
					}
					else{
						$updateData = array("name"=>$data['name'],
											"lastname"=>$data['lastname'],
											"country_code"=>$data['country_code'],
											"phone_number"=>$data['phone_number'],
											"user_bio"=>$data['user_bio']
											);
											
						User::where('id', $id)->update($updateData);
						 return response()->json([
												'message' => 'User data successfully updated!'
											], 201);						
					}
					
				}
				else{
					 return response()->json([
					'message' => "User not found with our record"
				], 400);
				}
				
			}
	}
}