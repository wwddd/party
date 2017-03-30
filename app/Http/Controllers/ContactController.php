<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use Exception;

class ContactController extends Controller
{
	public function index() {
		return view('contact.contact');
	}

	public function store(Request $request, MailController $mail) {
		$this->validate($request, [
			'email' => 'required|email',
			'text' => 'required'
		]);

		$user_email = $request->input('email');
		$text = $request->input('text');

		try {
			$mail->send_feedback($user_email, $text);
		} catch (Exception $e){
			$response = [];
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так!';
			return json_encode($response);
		}
		
		$response = [];
		$response['status'] = 'success';
		$response['message'] = 'Спасибо за ваш отзыв';
		return json_encode($response);
	}
}
