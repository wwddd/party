<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Crypt;


class MailController extends Controller
{
	public function send($link, $email, $content, $template) {
	    Mail::send("templates.emails.$template", array(
	            'content' => $content,
	            'link' => $link
	        ), 
	        function($message) use ($email) {
	            $message
	            ->to($email)
	            ->subject('You have a message from portfolio-kaduk!');
	        }
	    );
	}
}
