<?php

Route::get('/', function () {
	return view('index');
});

// Register
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

// Login
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

// Logout
Route::get('logout', [
	'as' => 'logout',
	'uses' => 'AuthController@logout'
]);

Route::get('confirms-account/{string_compare}', [
	'as' => 'confirms_account',
	'uses' => 'AuthController@confirms_account'
]);

// Cooperation
Route::group(['prefix' => 'cooperation'], function() {
	Route::get('/', [
		'as' => 'cooperation',
		'uses' => 'CooperationController@index'
	]);
	// ajax
	Route::post('ads', [
		'as' => 'ads',
		'uses' => 'CooperationController@ajax_ads'
	]);
	// ajax
	Route::post('membership', [
		'as' => 'membership',
		'uses' => 'CooperationController@ajax_membership'
	]);
	Route::post('ads/store', [
		'as' => 'ads_store',
		'uses' => 'CooperationController@ads_store'
	]);
});

// Account
Route::group(['middleware' => 'auth', 'prefix' => 'account'], function () {
	Route::get('/', [
		'as' => 'account',
		'uses' => 'UserController@index'
	]);
	Route::post('event-store', [
		'as' => 'event-store',
		'uses' => 'EventController@store'
	]);
	Route::put('user_update', [
	'uses' => 'UserController@user_update',
	'as' => 'user_update'
	]);

	// Ajax
	Route::post('ajax-opened', [
		'as' => 'ajax-opened',
		'uses' => 'UserController@ajax_opened_events'
	]);
	Route::post('ajax-closed', [
		'as' => 'ajax-closed',
		'uses' => 'UserController@ajax_closed_events'
	]);
	Route::post('ajax-favourite', [
		'as' => 'ajax-favourite',
		'uses' => 'UserController@ajax_favourite_events'
	]);
	Route::post('ajax-create', [
		'as' => 'ajax-create',
		'uses' => 'UserController@ajax_create_event'
	]);
	Route::post('ajax-achievements', [
		'as' => 'ajax-achievements',
		'uses' => 'UserController@ajax_achievements'
	]);
	Route::post('ajax-personal', [
		'as' => 'ajax-personal',
		'uses' => 'UserController@ajax_personal'
	]);
});

Route::group(['prefix' => 'event'], function() {
	Route::get('{id}', [
		'as' => 'show_event',
		'uses' => 'EventController@show'
	]);
	Route::post('store', [
		'as' => 'event-store',
		'uses' => 'EventController@store'
	]);
});

// Search
Route::group(['prefix' => 'search'], function() {
	Route::get('/', [
		'as' => 'search',
		'uses' => 'SearchController@index'
	]);
	Route::post('ajax-search', [
		'as' => 'ajax-search',
		'uses' => 'SearchController@ajax_search'
	]);
	Route::post('ajax-ads', [
		'as' => 'ajax-ads',
		'uses' => 'SearchController@ajax_ads'
	]);
});