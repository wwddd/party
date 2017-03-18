<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;

class EventController extends Controller {
	public function __construct() {
		// $this->middleware('guest', ['except' => 'logout']);
	}

	// public function index() {
	// 	return view('event/event');
	// }

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
			$response['redirect'] = route('login');
			echo json_encode($response);
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что-то пошло не так...';
			echo json_encode($response);
		}
	}
}
