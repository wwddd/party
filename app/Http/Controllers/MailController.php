<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Crypt, Exception;


class MailController extends Controller
{
	public function send_verify_account($email) {
	    $token = Crypt::encrypt($email);
        $link = route('confirm_account', ['token' => $token]);

	    Mail::send("templates.emails.verify_account", array(
	            'link' => $link
	        ), 
	        function($message) use ($email) {
	            $message
		            ->to($email)
		            ->subject('You have a message from partyscope.com!');
	        }
	    );

        // if (
        // 	Mail::send("templates.emails.verify_account", array(
	       //      'link' => $link
	       //  ), function($message) use ($email) {
	       //      $message
	       //      ->to($email)
	       //      ->subject('You have a message from portfolio-kaduk!');
	       //  })
        // ) {
        // 	return true;
        // } else {
        //     throw new Exception('Error email');
        // }
	}

	public function re_send_verify_account() {
        $email = Auth::user()->email;
        $token = Crypt::encrypt($email);
        $link = route('confirm_account', ['token' => $token]);
        
	    Mail::send("templates.emails.verify_account", array(
	            'link' => $link
	        ), 
	        function($message) use ($email) {
	            $message
		            ->to($email)
		            ->subject('You have a message from partyscope.com!');
	        }
	    );

        // if (
        // 	Mail::send("templates.emails.verify_account", array(
	       //      'link' => $link
	       //  ), function($message) use ($email) {
	       //      $message
	       //      ->to($email)
	       //      ->subject('You have a message from portfolio-kaduk!');
	       //  })
        // ) {
        // 	return true;
        // } else {
        //     throw new Exception('Error email');
        // }
	}

	public function send_new_password_confirm($email) {
        $token = Crypt::encrypt($email);
        $link = route('reset-password-confirm', ['string_compare' => $token]);

        Mail::send("templates.emails.reset_password", array(
        		'link' => $link
	        ), function($message) use ($email) {
        		$message
        			->to($email)
        			->subject('You have a message from partyscope.com!');
	        }
	    );
	}

	public function send_feedback($user_email, $text) {
     //    Mail::send("templates.emails.send_feedback", array(
     //    		'text' => $text
	    //     ), function($message) use ($email) {
     //    		$message
     //    			->to($email)
     //    			->subject('You have a message from partyscope.com!');
	    //     }
	    // );

		Mail::send('templates.emails.send_feedback', array(
				'user_email' => $user_email,
				'text' => $text
			), function($message) {
		    	$message
		    		->to('partyscopeinfo@gmail.com')
		    		->subject('Пришёл отзыв');
			}
		);
	}
}
