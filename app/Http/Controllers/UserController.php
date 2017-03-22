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

		if ($request['password'] != '') {
			$user->password = bcrypt($request['password']);
		}
		$user->save();

		$response = [];
		$response['status'] = 'success';
		$response['message'] = 'Сохранено!';
		return json_encode($response);
	}

	public function get_events_of_user($user_id, $condition, $status) {
		$query = DB::table('events');
		$query->leftJoin('event_followers', 'event_followers.event_id', '=', 'events.id');
		$query->leftJoin('users', 'users.id', '=', 'events.user_id');
		$query->where('status', $status);
		$query->select(
					'events.*',
					'users.name',
					'users.gender',
					'users.age',
					'users.events_count',
					'users.followers_count',
					'users.rating',
					DB::raw("count(event_followers.event_id) as current_followers")
				);
		$query->groupBy('events.id');
		$query->orderBy('start', 'ASC');
		$query->where($condition, $user_id);
		return $query;
	}


// AJAX
	public function ajax_opened_events() {

		$events_as_guest = $this->get_events_of_user(Auth::user()->id, 'event_followers.follower_id', 1)->get();
		$events_as_owner = $this->get_events_of_user(Auth::user()->id, 'events.user_id', 1)->get();
		return view('account/ajax/opened', ['events_as_guest' => $events_as_guest, 'events_as_owner' => $events_as_owner]);
	}

	public function ajax_closed_events() {
		$events_as_guest = $this->get_events_of_user(Auth::user()->id, 'event_followers.follower_id', 0)->get();
		$events_as_owner = $this->get_events_of_user(Auth::user()->id, 'events.user_id', 0)->get();
		return view('account/ajax/closed', ['events_as_guest' => $events_as_guest, 'events_as_owner' => $events_as_owner]);
	}

	public function ajax_favourite_events() {
		$query = $this->get_events_of_user(Auth::user()->id, 'favorites.user_id', 1);
		$query->leftJoin('favorites', 'favorites.event_id', '=', 'events.id');
		$events = $query->get();
		return view('account/ajax/favourite', ['events' => $events]);
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
