<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class EventController extends Controller {
	public function index(Request $request, $id) {
		$query = DB::table('events');
		$query->leftJoin('event_followers', 'event_followers.event_id', '=', 'events.id');
		$query->leftJoin('users', 'users.id', '=', 'events.user_id');
		$query->where('events.id', $id);
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
		$event = $query->get();

		$follower_info = $this->follower_info($id);
		$in_favourites = $this->in_favourites($id);

		$action1 = '';
		$action2 = '';
		$button1 = '';
		$button2 = '';

		if(Auth::user()) {
			if($event[0]->user_id == Auth::user()->id) {
				$action2 = route('event_close');
				$button2 = 'Отменить';
				if($event[0]->start < time()) {
					$action1 = route('event_complete');
					$button1 = 'Завершить';
				}
			} else {
				if($follower_info && $follower_info->count()) {
					$action1 = route('event_unsubscribe');
					$button1 = 'Отписаться';
				} else {
					$action1 = route('event_subscribe');
					$button1 = 'Вписаться';
				}

				if($in_favourites) {
					$action2 = route('event_unfavorites');
					$button2 = 'Убрать из закладок';
				} else {
					$action2 = route('event_to_favorites');
					$button2 = 'В закладки';
				}
			}

		}

		return view('event.event', [
			'event' => $event[0],
			'follower_info' => $follower_info,
			'in_favourites' => $in_favourites,
			'actions_arr' => [
				'action1' => $action1,
				'action2' => $action2,
				'button1' => $button1,
				'button2' => $button2
			]
		]);
	}

	public function follower_info($event_id) {
		if(Auth::user()) {
			$event_follower = DB::table('event_followers')
								->where('event_id', $event_id)
								->where('follower_id', Auth::user()->id)
								->get();
			return $event_follower;
		}
		return false;
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
		$record['posted_time'] = time();

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

	public function subscribe(Request $request) {
		$event_id = $request['event_id'];
		$follower_id = $request['follower_id'];
		$owner_id = $request['owner_id'];
		DB::table('event_followers')->insert(array(
			'event_id' => $event_id,
			'follower_id' => $follower_id
		));

		DB::table('user_followers')->insert(array(
			'user_id' => $owner_id,
			'follower_id' => $follower_id
		));

		$response['status'] = 'success';
		$response['message'] = 'Поздравляем, вы успешно вписались!';
		$response['event_action'] = route('event_unsubscribe');
		$response['event_button'] = 'Отписаться';
		return json_encode($response);
	}

	public function unsubscribe(Request $request) {
		$event_id = $request['event_id'];
		$follower_id = $request['follower_id'];
		$owner_id = $request['owner_id'];
		DB::table('event_followers')
			->where('event_id', $event_id)
			->where('follower_id', $follower_id)
			->delete();

		DB::table('user_followers')
			->where('user_id', $owner_id)
			->where('follower_id', $follower_id)
			->delete();

		$response['status'] = 'success';
		$response['message'] = 'Отписка оформлена!';
		$response['event_action'] = route('event_subscribe');
		$response['event_button'] = 'Вписаться';
		return json_encode($response);
	}

	public function to_favorites(Request $request) {
		$event_id = $request['event_id'];
		$follower_id = $request['follower_id'];
		$owner_id = $request['owner_id'];
		DB::table('favorites')->insert(array(
			'event_id' => $event_id,
			'user_id' => $follower_id
		));

		$response['status'] = 'success';
		$response['message'] = 'Добавлено!';
		$response['event_action'] = route('event_unfavorites');
		$response['event_button'] = 'Убрать из закладок';
		return json_encode($response);
	}

	public function unfavorites(Request $request) {
		$event_id = $request['event_id'];
		$follower_id = $request['follower_id'];
		$owner_id = $request['owner_id'];
		DB::table('favorites')
			->where('event_id', $event_id)
			->where('user_id', $follower_id)
			->delete();

		$response['status'] = 'success';
		$response['message'] = 'Удалено!';
		$response['event_action'] = route('event_to_favorites');
		$response['event_button'] = 'В закладки';
		return json_encode($response);
	}

	public function complete(Request $request, NoticeController $notice) {
		$event_id = $request['event_id'];
		DB::table('events')->where('id', $event_id)->update(array(
			'status' => '0'
		));

		$followers = DB::table('event_followers')
						->select('follower_id')
						->where('event_id', $event_id)
						->get();

		$insert = [];
		foreach ($followers as $key => $follower) {
			$insert[$key] = [
					'user_id' => $follower->follower_id,
					'title' => 'Событие #' . $event_id . ' завершено! Теперь вы можете оценить его!',
					'link' => '/event/' . $event_id
				];
		}
		try {
			$notice->store($insert);
		} catch (Exception $e) {}


		$response['status'] = 'success';
		$response['message'] = 'Ваша вписка завершенна!';
		return json_encode($response);
	}

	public function close(Request $request, NoticeController $notice) {
		$this->validate($request, [
			'reason' => 'required'
		]);

		$event_id = $request['event_id'];
		$reason = $request['reason'];

		DB::table('events')->where('id', $event_id)->update(array(
			'status' => '2',
			'reason' => $reason
		));

		$followers = DB::table('event_followers')
						->select('follower_id')
						->where('event_id', $event_id)
						->get();

		$insert = [];
		foreach ($followers as $key => $follower) {
			$insert[$key] = [
					'user_id' => $follower->follower_id,
					'title' => 'Событие #' . $event_id . ' отменено!',
					'link' => '/event/' . $event_id
				];
		}
		try {
			$notice->store($insert);
		} catch (Exception $e) {}

		$response['status'] = 'success';
		$response['message'] = 'Ваша вписка отменена!';
		return json_encode($response);
	}

	public function ajax_store_rating(Request $request) {
		$this->validate($request, [
			'star' => 'required'
		]); 
		$star = $request['star'];
		$event_id = $request['event_id'];
		$owner_id = $request['owner_id'];

		// followers update and get avg
		DB::table('event_followers')
			->where('follower_id', Auth::user()->id)
			->where('event_id', $event_id)
			->update(array(
				'follower_eval' => $star
			));

		$avg_event = DB::table('event_followers')
			->where('event_id', $event_id)
			->avg('follower_eval');


		// events update and get avg
		DB::table('events')
			->where('id', $event_id)
			->update(array(
				'event_rating' => $avg_event
			));

		$avg_events = DB::table('events')
			->where('user_id', $owner_id)
			->where('event_rating', '!=', 0.0)
			->avg('event_rating');
			// ->get();

		// user update rating
		DB::table('users')
			->where('id', $owner_id)
			->update(array(
				'user_rating' => $avg_events
			));


		$response['status'] = 'success';
		$response['message'] = 'Оценка принята!';
		$response['avg_event'] = view('templates.rating', ['rating' => $avg_event, 'sense' => 'События'])->render();
		return json_encode($response);
	}

	public function event_upload_image(Request $request) {
		$this->validate($request, [
			'image' => 'mimes:jpg,jpeg,png,gif|required',
		]);
		$image = $request->file('image');
		$event_id = $request['event_id'];

		if($image != null) {
			$count = 0;
			$img = Image::make($image);
			$natural_width = $img->width();
			$natural_height = $img->height();
			$file_name = Auth::user()->id . '-' . 
						 time() . '.' .
						 $image->getClientOriginalExtension();

			$img->resize(800, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			$img->insert(base_path() . '/public/images/alco.png', 'bottom-right', 10, 10);
			$img->save(base_path() . '/public/images/events/' . $file_name, 100);


			$image_path = '/images/events/' . $file_name;
		}

		DB::table('events')->where('id', $event_id)->update(array(
			'image' => $image_path
		));

		$response = [];
		$response['status'] = 'success';
		$response['message'] = 'Фото загружено!';
		$response['event_image'] = $image_path;
		return json_encode($response);

		// return view('layouts.miniTpl.image', ['files' => $paths]);
	}
}
