<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
// use DB;

class UserController extends Controller {
	public function __construct() {
		// $this->middleware('guest', ['except' => 'logout']);
	}

	public function index() {
		return view('account/account');
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
		return view('account/ajax/personal');
	}
// /AJAX
}
