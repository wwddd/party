<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;

class EventController extends Controller {
	public function index(Request $request, $id) {
		$event = DB::table('events')
					->where('id', $id)
					->get();

		$owner = DB::table('users')->where('id', $event[0]->user_id)->get();
		
		$current_user = $request->user();

		$event_follower = DB::table('event_followers')
								->where('event_id', $id)
								->where('follower_id', $current_user->id)
								->get();
		// dd($event_follower);
		// dd($event_follower[0]->follower_id);
		// dd(empty($event_follower[0]->id));

		$event_to_favorites = DB::table('favorites')
							->where('user_id', $current_user->id)
							->where('event_id', $id)
							->get();
		// dd($event_to_favorites);
		// dd($event_to_favorites[0]->id);
		// dd(empty($event_to_favorites[0]->id));

		return view('event.event', [
			'event' => $event,
			'owner' => $owner,
			'current_user' => $current_user,
			'event_follower' => $event_follower,
			'event_to_favorites' => $event_to_favorites
		]);			
	}

	public function store(Request $request) {
		$validation = $this->validate($request, [
			'title' => 'required',
			'description' => 'required',
			'country' => 'required',
			'city' => 'required',
			'address' => 'required',
			'time' => 'required',
			'contact' => 'required'
		]);

		$record = array();
		$record['user_id'] = Auth::user()->id;
		$record['title'] = $request['title'];
		$record['description'] = $request['description'];
		$record['country'] = $request['country'];
		$record['city'] = $request['city'];
		$record['place'] = $request['address'];
		$record['start'] = strtotime($request['time']);
		$record['contact'] = $request['contact'];

		$record['status'] = 1;
		$record['verify'] = 0;

		if(isset($request['conditions'])){
			$tags = '';
			foreach ($request['conditions'] as $key => $value) {
				if($value !== NULL) {
					if(substr($value, -1) == 'x') {
						$value = substr($value, 0, -2);
					}
					$tags .= $value . ',';
				}
			}
			$record['tags'] = $tags;
		}
		if(isset($request['peoples_count'])){
			$record['peoples_count'] = $request['peoples_count'];
		}
		if(isset($request['offer'])){
			$record['offer'] = $request['offer'];
		}

		$response = [];
		if(DB::table('events')->insert($record)) {
			$response['status'] = 'success';
			$response['message'] = 'Успешно! Вы создали вписку!';
			// $response['redirect'] = route('login');
			return json_encode($response);
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что-то пошло не так...';
			return json_encode($response);
		}
	}

	public function subscribe($event_id, $follower_id) {
		DB::table('event_followers')->insert(array(
			'event_id' => $event_id,
			'follower_id' => $follower_id
		));

		$response['status'] = 'success';
		$response['message'] = 'Поздравляем, вы успешно вписались!';
		return json_encode($response);
	}

	public function un_subscribe($event_id, $follower_id) {

	}

	public function to_favorites($user_id, $event_id) {
		DB::table('favorites')->insert(array(
			'user_id' => $user_id,
			'event_id' => $event_id
		));

		$response['status'] = 'success';
		$response['message'] = 'Добавлено!';
		return json_encode($response);
	}

	public function un_favorites($user_id, $event_id) {

	}

	public function complete($event_id) {
		DB::table('events')->where('id', $event_id)->update(array(
			'status' => '0'
		));

		$response['status'] = 'success';
		$response['message'] = 'Ваша вписка завершенна!';
		return json_encode($response);
	}

	public function close(Request $request, $event_id) {
		$this->validate($request, [
			'reason' => 'required'
		]); 

		$reason = $request->input('reason');

		DB::table('events')->where('id', $event_id)->update(array(
			'status' => '2',
			'reason' => $reason
		));

		$response['status'] = 'success';
		$response['message'] = 'Ваша вписка закрыта!';
		return json_encode($response);
	}
}
