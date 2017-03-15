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
	return view('index');
});

// User Auth
Route::get('register/user', [
	'as' => 'user_register',
	'uses' => 'AuthController@user_register'
]);
Route::post('store/user', [
	'as' => 'user_store',
	'uses' => 'AuthController@user_store'
]);
Route::get('user/login', [
	'as' => 'user_login',
	'uses' => 'AuthController@user_login'
]);


// Company Auth
Route::get('register/company', [
	'as' => 'company_register',
	'uses' => 'AuthController@company_register'
]);
Route::get('company/login', [
	'as' => 'company_login',
	'uses' => 'AuthController@company_login'
]);

Route::group(['prefix' => 'account'], function () {
	Route::get('/', [
		'uses' => 'UserController@index',
		'as' => 'account'
	]);
	Route::get('opened_events', [
		'uses' => 'UserController@opened_events',
		'as' => 'opened_events'
	]);
	
});
