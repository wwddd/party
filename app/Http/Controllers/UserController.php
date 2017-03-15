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

	public function opened_events() {
		return view('account/ajax/opened_events');
	}
}
