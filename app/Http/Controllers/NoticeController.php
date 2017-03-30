<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;

class NoticeController extends Controller {

	public function store($insert) {
		DB::table('user_notices')->insert($insert);
	}

	public function delete(Request $request) {
		$notice_id = $request['id'];
		DB::table('user_notices')
		->where('id', $notice_id)
		->delete();

		// return 
	}

	public function ajax_get_notices() {
		$notices = DB::table('user_notices')
		->where('user_id', Auth::user()->id)
		->get();

		return view('templates/notices', ['notices' => $notices]);
	}

}
