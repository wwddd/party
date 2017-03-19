<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;

class SearchController extends Controller {

	public function index() {
		return view('search/search');
	}

	public function ajax_search(Request $request) {
		$query = DB::table('events');
		$query->where('status', 1);
		$query->orderBy('start', 'ASC');

		$events = $query->get();
		// dd($events);
		return view('search/ajax/search', ['events' => $events]);
	}

	public function ajax_ads(Request $request) {
		return view('search/ajax/ads');
	}
}
