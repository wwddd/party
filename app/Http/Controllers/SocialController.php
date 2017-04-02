<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\User;
// use Auth;
use Socialite;
use \SocialiteProviders\Manager\ServiceProvider;
use Illuminate\Cookie\CookieJar;
use Cookie;
// use Illuminate\Support\Facades\Mail;
// use DB, Crypt;

// use App\Http\Controllers\MailController;

class SocialController extends Controller {
	// public $vk_id = 5947041;
	// public $vk_protect_key = 'V2ArLQW8XQIOGlzutUDV';
	// public $vk_service_key = 'ff61b0b5ff61b0b5ffd3fc5121ff3b0e14fff61ff61b0b5a7b7555d105a7be78cdc5d48';

	public function redirectToProvider($provider) {
		return Socialite::driver($provider)->redirect();
	}

	public function handleProviderCallback($provider) {
		$user = Socialite::driver($provider)->user();

		$authUser = $this->findOrCreateUser($user, $provider);
		Auth::login($authUser, true);
		return redirect(route('account'));
	}

	public function findOrCreateUser($user, $provider) {
		$authUser = User::where('email', $user->email)->first();
		if ($authUser) {
			return $authUser;
		}
		return User::create([
			'name'     => $user->name,
			'email'    => $user->email,
			// 'provider' => $provider,
			// 'provider_id' => $user->id
		]);
	}

}