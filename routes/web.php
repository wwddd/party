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

Route::group(['prefix' => 'register'], function() {
	Route::get('/', [
		'as' => 'index_register',
		'uses' => 'AuthController@index_register'
	]);
	Route::post('user/form', [
		'as' => 'user_form',
		'uses' => 'AuthController@ajax_user_form'
	]);
	Route::post('company/form', [
		'as' => 'company_form',
		'uses' => 'AuthController@ajax_company_form'
	]);
	Route::post('user/store', [
		'as' => 'user_store',
		'uses' => 'AuthController@user_store'
	]);
});

Route::group(['prefix' => 'login'], function() {
	Route::get('/', [
		'as' => 'index_login',
		'uses' => 'AuthController@index_login'
	]);
	Route::post('/', [
		'as' => 'login',
		'uses' => 'AuthController@login'
	]);
});

Route::get('logout', [
	'as' => 'logout',
	'uses' => 'AuthController@logout'
]);

Route::get('confirms-account/{string_compare}', [
	'as' => 'confirms_account',
	'uses' => 'AuthController@confirms_account'
]);

Route::group(['prefix' => 'account'], function () {
	Route::get('/', [
		'uses' => 'UserController@index',
		'as' => 'account'
	]);
});

Route::post('event-store', [
	'uses' => 'EventController@store',
	'as' => 'event-store'
]);


// AJAX
	Route::post('ajax-opened', [
		'uses' => 'UserController@ajax_opened_events',
		'as' => 'ajax-opened'
	]);
	Route::post('ajax-closed', [
		'uses' => 'UserController@ajax_closed_events',
		'as' => 'ajax-closed'
	]);
	Route::post('ajax-favourite', [
		'uses' => 'UserController@ajax_favourite_events',
		'as' => 'ajax-favourite'
	]);
	Route::post('ajax-create', [
		'uses' => 'UserController@ajax_create_event',
		'as' => 'ajax-create'
	]);
	Route::post('ajax-achievements', [
		'uses' => 'UserController@ajax_achievements',
		'as' => 'ajax-achievements'
	]);
	Route::post('ajax-personal', [
		'uses' => 'UserController@ajax_personal',
		'as' => 'ajax-personal'
	]);
// /AJAX