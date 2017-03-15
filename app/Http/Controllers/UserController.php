<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller {
	public function __construct() {
		// $this->middleware('guest', ['except' => 'logout']);
	}

	public function index() {
		return view('account/account');
	}


// AJAX
	public function ajax_opened() {
		return view('account/ajax/opened');
	}

	public function ajax_closed() {
		return view('account/ajax/closed');
	}

	public function ajax_favourite() {
		return view('account/ajax/favourite');
	}

	public function ajax_create() {
		return view('account/ajax/create');
	}

	public function ajax_achievements() {
		return view('account/ajax/achievements');
	}

	public function ajax_personal() {
		return view('account/ajax/personal');
	}
// /AJAX
}
