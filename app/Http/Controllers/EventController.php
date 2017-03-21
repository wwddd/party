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
		// dd($owner);
		$is_follower = $this->is_follower($id);
		$in_favourites = $this->in_favourites($id);

		$action1 = '';
		$action2 = '';
		$button1 = '';
		$button2 = '';

		if(Auth::user()) {
			if($owner[0]->id == Auth::user()->id) {
				$action1 = route('event_complete', ['event_id' => $event[0]->id]);
				$action2 = route('event_close', ['event_id' => $event[0]->id]);
				$button1 = 'Завершить';
				$button2 = 'Закрыть';
			} else {
				if($is_follower) {
					$action1 = route('event_un_subscribe', ['event_id' => $event[0]->id, 'follower_id' => Auth::user()->id]);
					$button1 = 'Отписаться';
				} else {
					$action1 = route('event_subscribe', ['event_id' => $event[0]->id, 'follower_id' => Auth::user()->id]);
					$button1 = 'Вписаться';
				}

				if($in_favourites) {
					$action2 = route('event_un_favorites', ['event_id' => $event[0]->id, 'user_id' => Auth::user()->id]);
					$button2 = 'Убрать из закладок';
				} else {
					$action2 = route('event_to_favorites', ['event_id' => $event[0]->id, 'user_id' => Auth::user()->id]);
					$button2 = 'В закладки';
				}
			}

		}


		return view('event.event', [
			'event' => $event[0],
			'owner' => $owner[0],
			'is_follower' => $is_follower,
			'in_favourites' => $in_favourites,
			'actions_arr' => [
				'action1' => $action1,
				'action2' => $action2,
				'button1' => $button1,
				'button2' => $button2
			]
		]);
	}

	public function is_follower($event_id) {
		if(Auth::user()) {
			$event_follower = DB::table('event_followers')
								->where('event_id', $event_id)
								->where('follower_id', Auth::user()->id)
								->get();

			if($event_follower->count()) {
				return true;
				// return $event_follower[0]->follower_id;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function in_favourites($event_id) {
		if(Auth::user()) {
			$event_to_favorites = DB::table('favorites')
									->where('user_id', Auth::user()->id)
									->where('event_id', $event_id)
									->get();

			if($event_to_favorites->count()) {
				return true;
				// return $event_to_favorites[0]->event_id;
			} else {
				return false;
			}
		} else {
			return false;
		}
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
		$response['event_action'] = route('event_un_subscribe', ['event_id' => $event_id, 'follower_id' => Auth::user()->id]);
		$response['event_button'] = 'Отписаться';
		return json_encode($response);
	}

	public function un_subscribe($event_id, $follower_id) {
		DB::table('event_followers')
			->where('event_id', $event_id)
			->where('follower_id', $follower_id)
			->delete();

		$response['status'] = 'success';
		$response['message'] = 'Отписка оформлена!';
		$response['event_action'] = route('event_subscribe', ['event_id' => $event_id, 'follower_id' => Auth::user()->id]);
		$response['event_button'] = 'Вписаться';
		return json_encode($response);
	}

	public function to_favorites($event_id, $user_id) {
		DB::table('favorites')->insert(array(
			'event_id' => $event_id,
			'user_id' => $user_id
		));

		$response['status'] = 'success';
		$response['message'] = 'Добавлено!';
		$response['event_action'] = route('event_un_favorites', ['event_id' => $event_id, 'user_id' => Auth::user()->id]);
		$response['event_button'] = 'Убрать из закладок';
		return json_encode($response);
	}

	public function un_favorites($event_id, $user_id) {
		DB::table('favorites')
			->where('event_id', $event_id)
			->where('user_id', $user_id)
			->delete();

		$response['status'] = 'success';
		$response['message'] = 'Удалено!';
		$response['event_action'] = route('event_to_favorites', ['event_id' => $user_id, 'user_id' => Auth::user()->id]);
		$response['event_button'] = 'В закладки';
		return json_encode($response);
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
