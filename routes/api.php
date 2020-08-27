<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
	// echo "hear";exit;
    // return $request->user();
// });
Route::post('login', 'Api\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('list', 'Api\UserController@listdata');

Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\UserController@details');
});