<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class AuthController extends Controller
{
    public function user_register() {
    	return view('auth.user.register');
    }

    public function user_store() {
    	return 'user_store';
    }

    public function user_login() {
    	return view('auth.user.login');
    }

    public function company_register() {
    	return 'company register';
    }

    public function company_login() {
    	return 'company login';
    }

}
