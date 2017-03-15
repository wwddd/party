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

Route::group(['prefix' => 'account'], function () {
	Route::get('/', [
		'uses' => 'UserController@index',
		'as' => 'account'
	]);
	Route::get('ajax-opened', [
		'uses' => 'UserController@ajax_opened',
		'as' => 'ajax-opened'
	]);
	Route::get('ajax-closed', [
		'uses' => 'UserController@ajax_closed',
		'as' => 'ajax-closed'
	]);
	Route::get('ajax-favourite', [
		'uses' => 'UserController@ajax_favourite',
		'as' => 'ajax-favourite'
	]);
	Route::get('ajax-create', [
		'uses' => 'UserController@ajax_create',
		'as' => 'ajax-create'
	]);
	Route::get('ajax-achievements', [
		'uses' => 'UserController@ajax_achievements',
		'as' => 'ajax-achievements'
	]);
	Route::get('ajax-personal', [
		'uses' => 'UserController@ajax_personal',
		'as' => 'ajax-personal'
	]);
});