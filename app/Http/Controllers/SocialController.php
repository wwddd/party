<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Mail;
use App\User;
// use DB, Crypt;

// use App\Http\Controllers\MailController;

class SocialController extends Controller {
	public $vk_id = 5947041;
	public $vk_protect_key = 'V2ArLQW8XQIOGlzutUDV';
	public $vk_service_key = 'ff61b0b5ff61b0b5ffd3fc5121ff3b0e14fff61ff61b0b5a7b7555d105a7be78cdc5d48';

	public function auth_vk(Request $request) {

		
	}

	public function share_vk(Request $request) {
		// $user_id = $request['user_id'] ? $request['user_id'] : '61512186';
		// $access_token = $request['access_token'] ? $request['access_token'] : '38e6eb5f012b1d092f6292e50fd8d00a628f020778751b91ae498d5af6703ebf08b007b64a661420972dc';

		// return redirect('https://api.vk.com/method/wall.post?owner_id=' . $user_id . '=&access_token=' . $access_token . '&message=tesitn&attachment=http://thug-life.ru&redirect_uri=http://localhost:8000');
	}
}