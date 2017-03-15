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
Route::get('user/register', [
	'as' => 'user_register',
	'uses' => 'AuthController@user_register'
]);
Route::post('user/store', [
	'as' => 'user_store',
	'uses' => 'AuthController@user_store'
]);
Route::get('user/login', [
	'as' => 'user_login',
	'uses' => 'AuthController@user_login'
]);


// Company Auth
Route::get('company/register', [
	'as' => 'company_register',
	'uses' => 'AuthController@company_register'
]);
Route::get('company/login', [
	'as' => 'company_login',
	'uses' => 'AuthController@company_login'
]);
