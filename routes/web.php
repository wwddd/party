<?php

Route::get('/', function () {
	return view('index');
});

Route::get('rules', function () {
	return view('rules');
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
Route::get('confirm-account/{token}', [
	'as' => 'confirm_account',
	'uses' => 'AuthController@confirm_account'
]);

// Send new confirm to email
Route::post('again-verify-account', [
	'middleware' => 'auth',
	'as' => 'again_verify_account',
	'uses' => 'AuthController@again_verify_account'
]);

// Reset password
Route::get('forgot-password', [
	'as' => 'forgot-password',
	'uses' => 'AuthController@forgot_password'
]);
Route::post('reset-password-init', [
	'as' => 'reset-password-init',
	'uses' => 'AuthController@reset_password_init'
]);
Route::get('reset-password-confirm/{string_compare}', [
	'as' => 'reset-password-confirm',
	'uses' => 'AuthController@reset_password_confirm'
]);
Route::post('reset-password/{user_id}', [
	'as' => 'reset-password',
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
	Route::post('feedback', [
		'as' => 'feedback',
		'uses' => 'UserController@feedback'
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
	Route::post('ajax-feedback', [
		'as' => 'ajax-feedback',
		'uses' => 'UserController@ajax_feedback'
	]);
});

// Event
Route::group(['prefix' => 'event'], function() {
	Route::get('{id}', [
		'as' => 'index_event',
		'uses' => 'EventController@index'
	]);
	Route::post('store', [
		'as' => 'event-store',
		'uses' => 'EventController@store'
	]);
	Route::post('subscribe/{event_id}/{follower_id}', [
		'as' => 'event_subscribe',
		'uses' => 'EventController@subscribe'
	]);
	Route::post('unsubscribe/{event_id}/{follower_id}', [
		'as' => 'event_un_subscribe',
		'uses' => 'EventController@un_subscribe'
	]);
	Route::post('favorites/{event_id}/{user_id}', [
		'as' => 'event_to_favorites',
		'uses' => 'EventController@to_favorites'
	]);
	Route::post('unfavorites/{event_id}/{user_id}', [
		'as' => 'event_un_favorites',
		'uses' => 'EventController@un_favorites'
	]);
	Route::post('complete/{event_id}', [
		'as' => 'event_complete',
		'uses' => 'EventController@complete'
	]);
	Route::post('close/{event_id}', [
		'as' => 'event_close',
		'uses' => 'EventController@close'
	]);
	Route::post('ajax_store_rating', [
		'as' => 'ajax_store_rating',
		'uses' => 'EventController@ajax_store_rating'
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