<?php

Route::get('/', function () {
	return view('index');
});

Route::get('rules', function () {
	return view('rules');
});

// Contact
Route::group(['prefix' => 'contact'], function() {
	Route::get('/', [
		'as' => 'contact',
		'uses' => 'ContactController@index'
	]);
	Route::post('/', [
		'as' => 'contact_store',
		'uses' => 'ContactController@store'
	]);
});

// Register
Route::group(['prefix' => 'register'], function() {
	Route::get('/', [
		'as' => 'index_register',
		'uses' => 'AuthController@index_register'
	]);
	Route::post('user_form', [
		'as' => 'user_form',
		'uses' => 'AuthController@ajax_user_form'
	]);
	Route::post('company_form', [
		'as' => 'company_form',
		'uses' => 'AuthController@ajax_company_form'
	]);
	Route::post('user_store', [
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
	Route::get('vk', [
		'as' => 'vk_login',
		'uses' => 'AuthController@vk_login'
	]);
});

// Logout
Route::get('logout', [
	'as' => 'logout',
	'uses' => 'AuthController@logout'
]);

// Confirm account
Route::get('confirm_account', [
	'as' => 'confirm_account',
	'uses' => 'AuthController@confirm_account'
]);

// Send new confirm to email
Route::post('again_verify_account', [ // TODO - change it for call at once from previous method
	'middleware' => 'auth',
	'as' => 'again_verify_account',
	'uses' => 'AuthController@again_verify_account'
]);

// Reset password
Route::get('forgot_password', [
	'as' => 'forgot_password',
	'uses' => 'AuthController@forgot_password'
]);
Route::post('reset_password_init', [
	'as' => 'reset_password_init',
	'uses' => 'AuthController@reset_password_init'
]);
Route::get('reset_password_confirm', [
	'as' => 'reset_password_confirm',
	'uses' => 'AuthController@reset_password_confirm'
]);
Route::post('reset_password', [
	'as' => 'reset_password',
	'uses' => 'AuthController@reset_password'
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
	Route::post('ads_store', [
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
	Route::post('event_store', [
		'as' => 'event_store',
		'uses' => 'EventController@store'
	]);
	Route::put('user_update', [
		'uses' => 'UserController@user_update',
		'as' => 'user_update'
	]);

	// Ajax
	Route::post('ajax_opened', [
		'as' => 'ajax_opened',
		'uses' => 'UserController@ajax_opened_events'
	]);
	Route::post('ajax_closed', [
		'as' => 'ajax_closed',
		'uses' => 'UserController@ajax_closed_events'
	]);
	Route::post('ajax_favourite', [
		'as' => 'ajax_favourite',
		'uses' => 'UserController@ajax_favourite_events'
	]);
	Route::post('ajax_create', [
		'as' => 'ajax_create',
		'uses' => 'UserController@ajax_create_event'
	]);
	Route::post('ajax_achievements', [
		'as' => 'ajax_achievements',
		'uses' => 'UserController@ajax_achievements'
	]);
	Route::post('ajax_personal', [
		'as' => 'ajax_personal',
		'uses' => 'UserController@ajax_personal'
	]);
});

// Event
Route::group(['prefix' => 'event'], function() {
	Route::get('{id}', [
		'as' => 'index_event',
		'uses' => 'EventController@index'
	]);
	Route::post('subscribe', [
		'as' => 'event_subscribe',
		'uses' => 'EventController@subscribe'
	]);
	Route::post('unsubscribe', [
		'as' => 'event_unsubscribe',
		'uses' => 'EventController@unsubscribe'
	]);
	Route::post('favorites', [
		'as' => 'event_to_favorites',
		'uses' => 'EventController@to_favorites'
	]);
	Route::post('unfavorites', [
		'as' => 'event_unfavorites',
		'uses' => 'EventController@unfavorites'
	]);
	Route::post('complete', [
		'as' => 'event_complete',
		'uses' => 'EventController@complete'
	]);
	Route::post('close', [
		'as' => 'event_close',
		'uses' => 'EventController@close'
	]);
	Route::post('ajax_store_rating', [
		'as' => 'ajax_store_rating',
		'uses' => 'EventController@ajax_store_rating'
	]);
	Route::post('event_upload_image', [
		'as' => 'event_upload_image',
		'uses' => 'EventController@event_upload_image'
	]);
	Route::post('report', [
		'as' => 'send_report',
		'uses' => 'ReportController@send'
	]);
});

// Search
Route::group(['prefix' => 'search'], function() {
	Route::get('/', [
		'as' => 'search',
		'uses' => 'SearchController@index'
	]);
	Route::post('ajax_search', [
		'as' => 'ajax_search',
		'uses' => 'SearchController@ajax_search'
	]);
	Route::post('ajax_ads', [
		'as' => 'ajax_ads',
		'uses' => 'SearchController@ajax_ads'
	]);
});


// Social
Route::group(['prefix' => 'social'], function() {
	Route::get('auth_vk', [
		'as' => 'auth_vk',
		'uses' => 'SocialController@auth_vk'
	]);
	Route::get('share_vk', [
		'as' => 'share_vk',
		'uses' => 'SocialController@share_vk'
	]);
});

// Notices
Route::group(['middleware' => 'auth', 'prefix' => 'notices'], function () {
	Route::post('ajax_get_notices', [
		'as' => 'ajax_get_notices',
		'uses' => 'NoticeController@ajax_get_notices'
	]);
	Route::post('delete_notice', [
		'as' => 'delete_notice',
		'uses' => 'NoticeController@delete'
	]);
});

// Social
Route::get('auth/{provider}', 'SocialController@redirectToProvider');
Route::get('auth/{provider}/callback', 'SocialController@handleProviderCallback');