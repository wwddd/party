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
	public function redirectToProvider($provider) {
		return Socialite::driver($provider)->redirect();
	}

	public function handleProviderCallback($provider, Request $request) {
		if(isset($request['error']) || isset($request['denied'])) {
			return redirect(route('login'));
		}
		$user = Socialite::driver($provider)->user();
		$authUser = $this->findOrCreateUser($user, $provider);
		Auth::login($authUser, true);
		return redirect(route('account'))->with(['social_name' => $authUser->name]);
	}

	public function findOrCreateUser($user, $provider) {
		$email = $provider . '@' . $user->id;
		$authUser = User::where('email', $email)->first();
		if ($authUser) {
			return $authUser;
		}
		return User::create([
			'name'     => $user->name,
			'email'    => $email,
			'verifed'  => '1'
		]);
	}

}