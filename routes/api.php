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
//################# Login API ############################
Route::group([
    'prefix' => 'auth','namespace' => 'Api'
], function () {
    Route::post('login', 'UserController@login');
    Route::post('signup', 'UserController@signup');
   Route::get('signup/activate/{token}', 'UserController@signupActivate');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'UserController@logout');
        Route::get('user', 'UserController@user');
		Route::put('updateUser','UserController@updateUser');
    });
});
//################# Password Reset API #########################
Route::group([    
    'namespace' => 'Api',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

//################# Sports API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'sports','namespace' => 'Api'
    ], function() {
        Route::get('list', 'SportsController@list');
        Route::get('user', 'UserController@user');
    });

//################# Tournament API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'tournament','namespace' => 'Api'
    ], function() {
        Route::post('create', 'TournamentController@create');
        Route::get('list', 'TournamentController@list');
        Route::post('detail', 'TournamentController@detail');
    });
//################# Tutor API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'tutor','namespace' => 'Api'
    ], function() {
        Route::post('create', 'TutroController@create');
        Route::get('list', 'TutroController@list');
        Route::post('detail', 'TutroController@detail');
    });	

//################# PoolHall API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'poolhall','namespace' => 'Api'
    ], function() {
        Route::get('list', 'PoolHallController@list');
        Route::put('updatePool/{id}', 'PoolHallController@updatePool');
		Route::post('createPool', 'PoolHallController@createPool');
    });

//################# Enquiry API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'contact','namespace' => 'Api'
    ], function() {
		Route::post('enquiry', 'EnquiryController@createEnquiry');
    });
//################# TrainingOnline API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'training','namespace' => 'Api'
    ], function() {
        Route::get('onlinelist', 'TrainingOnlineController@onlinelist');
        Route::get('sheets', 'TrainingSheetController@sheets');
    });