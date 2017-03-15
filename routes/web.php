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
	Route::get('opened_events', [
		'uses' => 'UserController@opened_events',
		'as' => 'opened_events'
	]);
	
});