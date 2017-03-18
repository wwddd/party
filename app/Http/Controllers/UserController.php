<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;

class UserController extends Controller {
	public function __construct() {
		// $this->middleware('guest', ['except' => 'logout']);
	}

	public function index() {
		return view('account/account');
	}

	public function user_update(Request $request) {
		$this->validate($request, [
			'name' => 'required|min:2',
			'age' => 'required|integer',
			'contact' => 'required',
			'country' => 'required',
			'city' => 'required'
		]);

		$user = Auth::user();
		$user->name = $request['name'];
		$user->age = $request['age'];
		$user->contact = $request['contact'];
		$user->country = $request['country'];
		$user->city = $request['city'];

		if ($request['password'] !== '') {
			$user->password = bcrypt($request['password']);
		}
		$user->save();

		$response = [];
		$response['status'] = 'success';
		$response['message'] = 'Сохранено!';
		return json_encode($response);
	}


// AJAX
	public function ajax_opened_events() {
		return view('account/ajax/opened');
	}

	public function ajax_closed_events() {
		return view('account/ajax/closed');
	}

	public function ajax_favourite_events() {
		return view('account/ajax/favourite');
	}

	public function ajax_create_event() {
		return view('account/ajax/create');
	}

	public function ajax_achievements() {
		return view('account/ajax/achievements');
	}

	public function ajax_personal() {
		$user = Auth::user();
		return view('account/ajax/personal', ['user' => $user]);
	}
// /AJAX
}
