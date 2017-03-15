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
	Route::post('ajax-opened', [
		'uses' => 'UserController@ajax_opened',
		'as' => 'ajax-opened'
	]);
	Route::post('ajax-closed', [
		'uses' => 'UserController@ajax_closed',
		'as' => 'ajax-closed'
	]);
	Route::post('ajax-favourite', [
		'uses' => 'UserController@ajax_favourite',
		'as' => 'ajax-favourite'
	]);
	Route::post('ajax-create', [
		'uses' => 'UserController@ajax_create',
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
});