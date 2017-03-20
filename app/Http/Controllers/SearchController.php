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

		if(isset($request['city'])) {
			$query->where('city', $request['city']);
		}

		if(isset($request['tags'])) {
			$query->where('tags', 'like', '%' . $request['tags'] . '%');
		}

		if(isset($request['peoples_count'])) {
			$query->where('peoples_count', '>' , $request['peoples_count']);
		}



		$query->where('status', 1);
		$query->orderBy('start', 'ASC');
		$events = $query->get();
		return view('search/ajax/search', ['events' => $events]);
	}

	public function ajax_ads(Request $request) {
		$query = DB::table('ads');

		$ads = $query->get();
		return view('search/ajax/ads', ['ads' => $ads]);
	}
}
