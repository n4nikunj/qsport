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
		Route::post('updateUser','UserController@updateUser');
		Route::post('uploadImage','UserController@uploadImage');
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
	
//################# category API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'category','namespace' => 'Api'
    ], function() {
        Route::get('list', 'CategoryController@list');
    });	
	
//################# PoolHall API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'poolhall','namespace' => 'Api'
    ], function() {
        Route::post('create', 'PoolHallController@create');
		//Route::put('update/{id}', 'PoolHallController@update');
        Route::get('list', 'PoolHallController@list');
        Route::post('detail', 'PoolHallController@detail');
        Route::post('search', 'PoolHallController@search');
    });
//################# Sponsor API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'sponsors','namespace' => 'Api'
    ], function() {
        Route::post('create', 'SponsorsController@create');
        Route::get('list', 'SponsorsController@list');
        Route::post('detail', 'SponsorsController@detail');
    });
//################# Watch Live API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'watchlive','namespace' => 'Api'
    ], function() {
        Route::get('list', 'WatchLiveController@list');
        Route::get('detail/{id}', 'WatchLiveController@detail');
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
		
        Route::post('create', 'TutorController@create');
        Route::get('list', 'TutorController@list');
        Route::post('detail', 'TutorController@detail');
    });	

//################# PoolHall API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'poolhall','namespace' => 'Api'
    ], function() {
        Route::Post('list', 'PoolHallController@list');
        Route::put('updatePool/{id}', 'PoolHallController@updatePool');
		Route::post('createPool', 'PoolHallController@createPool');
    });
//################# product API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'market','namespace' => 'Api'
    ], function() {
        Route::get('list', 'ProductController@productList');
        Route::post('categoryProductList', 'ProductController@categoryProductList');
        Route::post('detail', 'ProductController@detail');
		Route::post('create', 'ProductController@create');
		Route::post('favouritesUnfavourites', 'ProductController@addfavourites');
		Route::get('favourites', 'ProductController@favouritesProduct');
		Route::post('unfavourite', 'ProductController@unfavourite');
    });
//################# product API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'quiz','namespace' => 'Api'
    ], function() {
        Route::get('levels', 'QuizController@level');
        Route::post('quizlist', 'QuizController@quiz');
		Route::post('quizReport', 'QuizController@quizReport');
		Route::post('quizScore', 'QuizController@quizScore');
		Route::post('submitAnswer', 'QuizController@submitAnswer');
		
    });
//################# Country API #########################
 Route::group([
	  'prefix' => 'country','namespace' => 'Api'
    ], function() {
        Route::get('list', 'CountryController@list');
    });
//################# Enquiry API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'contact','namespace' => 'Api'
    ], function() {
		Route::post('enquiry', 'EnquiryController@createEnquiry');
    });
//################# Setting API #########################
 Route::group([
	  'prefix' => 'setting','namespace' => 'Api'
    ], function() {
		Route::get('generalsetting', 'SettingController@SiteSetting');
		
    });

 Route::group([
	  'middleware' => 'auth:api',
	  'prefix' => 'setting','namespace' => 'Api'
    ], function() {
			Route::get('usersetting', 'SettingController@UserSetting');
		Route::post('update', 'SettingController@updateSetting');
    });
//################# TrainingOnline API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'training','namespace' => 'Api'
    ], function() {
        Route::get('onlinelist', 'TrainingOnlineController@onlinelist');
        Route::get('upcomingSession', 'TrainingOnlineController@upcoming');
        Route::get('LiveSession', 'TrainingOnlineController@liveSession');
        Route::post('detail', 'TrainingOnlineController@sessiondetail');
        Route::get('drills', 'TrainingSheetController@sheets');
        Route::post('instructions', 'TrainingSheetController@instructions');
        Route::post('drillDetail', 'TrainingSheetController@detail');
    });
//################# Enquiry API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'notification','namespace' => 'Api'
    ], function() {
		Route::get('list', 'NotificationController@getNotification');
		Route::get('clear', 'NotificationController@clearNotification');
    });	
//################# Chat API #########################
 Route::group([
      'middleware' => 'auth:api',
	  'prefix' => 'chat','namespace' => 'Api'
    ], function() {
		//Route::get('getToken', 'TwilioController@advisor_twilio_token');
		
		
		Route::get('myMessage', 'ChatController@myMessage');
		Route::post('createChannel', 'ChatController@createChannel');
		Route::post('updateLastMessage', 'ChatController@updateLastMessage');
    });		
//################# Twillio API #########################
 Route::group([
		'middleware' => 'auth:api',
	  'prefix' => 'chat','namespace' => 'Api\Advisor'
    ], function() {
		Route::get('getToken', 'TwilioController@advisor_twilio_token');
		Route::get('chatToken', 'TwilioController@twilio_token');
		
    });			
	
	