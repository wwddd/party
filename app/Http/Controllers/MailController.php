<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use DB, Crypt, Exception;


class MailController extends Controller
{
	public function send_verify_account($email) {
		$token = Crypt::encrypt($email);
		$link = route('confirm_account') . '?token=' . $token;

		Mail::send("templates.emails.verify_account", array(
				'link' => $link
			),
			function($message) use ($email) {
				$message
					->to($email)
					->subject('You have a message from partyscope.com!');
			}
		);
	}

	// public function re_send_verify_account() {
	// 	$email = Auth::user()->email;
	// 	$token = Crypt::encrypt($email);
	// 	$link = route('confirm_account', ['token' => $token]);
		
	// 	Mail::send("templates.emails.verify_account", array(
	// 			'link' => $link
	// 		), 
	// 		function($message) use ($email) {
	// 			$message
	// 				->to($email)
	// 				->subject('You have a message from partyscope.com!');
	// 		}
	// 	);
	// }

	public function forgot_password($email, $token) {
		Mail::send("templates.emails.reset_password", array(
				'token' => $token,
				'email' => $email
			), function($message) use ($email) {
				$message
					->to($email)
					->subject('You have a message from partyscope.com!');
			}
		);
	}

	public function send_feedback($user_email, $text) {
		Mail::send('templates.emails.send_feedback', array(
				'user_email' => $user_email,
				'text' => $text
			), function($message) {
				$message
					->to('reymoleg@gmail.com')
					->subject('Пришёл отзыв');
			}
		);
	}

	public function send_report($email, $event_id, $guilty_id, $text, $reason) {
		Mail::send('templates.emails.send_report', array(
				'email' => $email,
				'event_id' => $event_id,
				'guilty_id' => $guilty_id,
				'text' => $text,
				'reason' => $reason

			), function($message) {
				$message
					->to('reymoleg@gmail.com')
					->subject('Пришла жалоба');
			}
		);
	}
}
