<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group( function() {
	Auth::routes();
});
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware(['guest'])->name('password.reset');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin','namespace' => 'Admin' ], function() {
    Route::get('permission/unauthorized','PermissionController@unauthorized')->name('permission_error');
});

Route::group(['prefix' => 'admin','namespace' => 'Admin'], function () {
	Route::get('lang/{locale}', 'HomeController@lang')->name('locale');

	Route::middleware('auth:web')->group( function() {
		Route::get('/home', 'HomeController@index')->name('home');
		
		Route::resource('roles','RoleController');
		Route::resource('permissions','PermissionController')->except(['show','edit','update']);
    	Route::resource('users','UserController');
		//setting
		Route::get('settings', 'SettingController@index')->name('settings.index');
		Route::post('settings/update', 'SettingController@update')->name('settings.update');
		
		//Rate Management
			Route::get('rate_management', 'RateManagementController@index')->name('rate_management.index');
		Route::post('rate_management/update', 'RateManagementController@update')->name('rate_management.update');
		
		
		//products

		Route::resource('products','ProductController');

		//countries
		Route::resource('country','CountryController');
		Route::post('/country/ajax', 'CountryController@index_ajax')->name('dt_country');
		Route::post('/country/status', 'CountryController@status')->name('country_status');

		//cms
		Route::resource('cms', 'CmsController');
		Route::post('/cms/ajax', 'CmsController@index_ajax')->name('dt_cms');
		Route::post('/cms/status', 'CmsController@status')->name('cms_status');
		Route::get('/cms/page/{pageName}', 'CmsController@pageName');
		
		//enquiry
		Route::resource('/enquiry', 'EnquiryController');
		Route::post('/enquiry/ajax', 'EnquiryController@index_ajax')->name('ajax_enquiry');
		Route::post('/enquiry/status', 'EnquiryController@status')->name('enquiry_status');
		
		//general configuration
		Route::get('settings/general', 'GeneralConfigurationController@index')->name('general_config.index');
		Route::post('general/update', 'GeneralConfigurationController@update')->name('general_configuration.update');
		
		//categories
		Route::resource('categories','CategoryController');
	//Notification
		Route::resource('notification','NotificationController');
		Route::post('/notification/ajax', 'NotificationController@index_ajax')->name('ajax_notification');
		Route::post('/notification/status', 'NotificationController@status')->name('notification_status');
		//training sheets
		Route::resource('training_sheets','TrainingSheetController');
		
		//Pool Hall
		Route::resource('pool_hall','PoolHallController');
		Route::post('/pool_hall/ajax', 'PoolHallController@index_ajax')->name('ajax_pool_hall');
		Route::post('/pool_hall/status', 'PoolHallController@status')->name('pool_hall_status');
		
		//Watch Live
		Route::resource('watch_live','WatchLiveController');
		Route::post('/watch_live/ajax', 'WatchLiveController@index_ajax')->name('ajax_watch_live');
		Route::post('/watch_live/status', 'WatchLiveController@status')->name('watch_live_status');
		
		//Tournament
		Route::resource('tournaments','TournamentsController');
		Route::post('/tournaments/ajax', 'TournamentsController@index_ajax')->name('ajax_tournament');
		Route::post('/tournaments/status', 'TournamentsController@status')->name('tournaments_status');
		
		//Sponsors
		Route::resource('sponsors','SponsorsController');
		Route::post('/sponsors/ajax', 'SponsorsController@index_ajax')->name('ajax_sponsor');
		Route::post('/sponsors/status', 'SponsorsController@status')->name('sponsors_status');
		
		//Diamonds Package
		Route::resource('diamonds_package','DiamondsPackageController');
		Route::post('/diamonds_package/ajax', 'DiamondsPackageController@index_ajax')->name('ajax_diamonds_package');
		
		//Gems
		Route::resource('gems','GemsController');
		Route::post('/gems/ajax', 'GemsController@index_ajax')->name('ajax_gems');
		
		//tutor
		Route::resource('tutors','TutorsController');
		Route::post('/tutors/ajax', 'TutorsController@index_ajax')->name('ajax_tutor');
		Route::post('/tutors/status', 'TutorsController@status')->name('tutor_status');
		Route::post('/tutors/prostatus', 'TutorsController@prostatus')->name('tutor_profile_status');
		
		//training online
		Route::resource('training_online','TrainingOnlineController');
		//games
		Route::resource('games','GameController');
		Route::post('/games/ajax', 'GameController@index_ajax')->name('ajax_game');
		Route::post('/games/status', 'GameController@status')->name('game_status');

		//levels
		Route::resource('levels','LevelController');

		//customer
		Route::resource('customers','CustomersController');
		Route::post('/customers/ajax', 'CustomersController@index_ajax')->name('ajax_customers');
		Route::post('/customers/status', 'CustomersController@status')->name('status');
		
		//quiz
		Route::resource('quiz','QuizController');

		//general configuration
		Route::get('settings/gems', 'GemsConfigController@index')->name('gems_config.index');
		
		Route::post('gems/update', 'GemsConfigController@update')->name('gems_config.update');
		Route::delete('settings/gems/delete/{id}', 'GemsConfigController@destroy')->name('gems_config.destroy');
		
		
		
		
    });
});
	
