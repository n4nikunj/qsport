<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Models\User;;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use App\Helpers\CommonHelpers;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user)
            return response()->json([
				"success"=> "0",
				"status"=> "404",
                'message' => __('passwords.user')
            ], 404);

        $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email], [
            'email' => $user->email,
            'token' => Str::random(60),
			'created_at' => \Carbon\Carbon::now()
        ]);

        if ($user && $passwordReset)
            $user->notify(new PasswordResetRequest($passwordReset->token));

        return response()->json([
			"success"=> "1",
			"status"=> "200",
            'message' => __('passwords.sent')
        ],200);
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset)
            return response()->json([
				"success"=> "0",
			"status"=> "404",	
                'message' => __('passwords.token')
            ], 404);

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
				"success"=> "0",
			"status"=> "404",
                'message' => __('passwords.token')
            ], 404);
        }

        return response()->json([
		"success"=> "1",
			"status"=> "200",
		"data" => $passwordReset],200);
    }

    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset)
            return response()->json([
				"success"=> "0",
			"status"=> "404",
                'message' => __('passwords.token')
            ], 404);

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user)
            return response()->json([
				"success"=> "0",
				"status"=> "404",
                'message' => __('passwords.user')
            ], 404);

        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();
		$imgurl = $thumburl = "";
		if(count($user->getMedia('user')) >0){
				$imgurl = $user->getMedia('user')->last()->getUrl();
				$thumburl =$user->getMedia('user')->last()->getUrl('thumb');
			}
        $user->notify(new PasswordResetSuccess($passwordReset));

        return response()->json([
		"success"=> "1",
			"status"=> "200",
		"data" =>['id'=>($user->id == null)? "" : (string)$user->id,
				'name'=>($user->name == null)? "" : $user->name ,
				'email'=>($user->email == null)? "" : $user->email,
				'country_code'=>($user->country_code == null)? "" : $user->country_code,
				'phone_number'=>($user->phone_number == null)? "" : $user->phone_number,
				'user_type'=>($user->user_type == null)? "" : $user->user_type,
				'user_bio'=>($user->user_bio == null)? "" :$user->user_bio ,
				'status'=>($user->status == null)? "" : $user->status,
				'profile_image' => CommonHelpers::getUrl($imgurl),
				]],200);
    }
}