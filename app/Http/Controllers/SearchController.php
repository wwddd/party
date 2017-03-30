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
		$query->leftJoin('event_followers', 'event_followers.event_id', '=', 'events.id');
		$query->leftJoin('users', 'users.id', '=', 'events.user_id');

		if(isset($request['city'])) {
			$query->where('events.city', 'like', '%' . $request['city'] . '%');
		}

		if(isset($request['country'])) {
			$query->where('events.country', 'like', '%' . $request['country'] . '%');
		}

		if(isset($request['tags'])) {
			$query->where('events.tags', 'like', '%' . $request['tags'] . '%');
		}

		if(isset($request['peoples_count'])) {
			$query->where('events.peoples_count', '>' , $request['peoples_count']);
		}


		$query->where('status', 1);
		$query->select(
					'events.*',
					'users.name',
					'users.gender',
					'users.age',
					'users.events_count',
					'users.followers_count',
					'users.user_rating',
					DB::raw("count(event_followers.event_id) as current_followers")
				);
		$query->groupBy('events.id');
		$query->orderBy('start', 'ASC');

		$count = $query->get()->count('events.id'); // TODO think, how change this query

		$current_page = 1;
		if(isset($request['page'])) {
			$current_page = $request['page'];
		}
		$paginate_limit = 5;
		$paginate_count = ceil($count/$paginate_limit);


		$query->limit($paginate_limit);
		$query->offset(($current_page - 1) * $paginate_limit);
		$events = $query->get();
		// dd($events);
		// dd($paginate);

		return view('search/ajax/search', [
											'events' => $events,
											'paginate_count' => $paginate_count,
											'current_page' => $current_page
										]);
	}

	public function ajax_ads(Request $request) {
		$query = DB::table('ads')->where('end', '>', time());

		$ads = $query->get();
		return view('search/ajax/ads', ['ads' => $ads]);
	}
}
