<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;


use DB;
use App\User;

class AuthController extends Controller
{
    // Country, city future
    /*
        public function __construct() {
            // создание нового cURL ресурса
            $ch = curl_init();

            // устрановка параметров
            curl_setopt($ch, CURLOPT_URL, "https://api.vk.com/method/database.getCountries?need_all&access_token=83e2d3fb83e2d3fb83509f1f8183b8bc76883e283e2d3fbdb2b9eaaab67dfda22037aeb&v=5.62");

            // загрузка страницы и выдача её браузеру
            $countries = curl_exec($ch);

            // завершение сеанса и освобождение ресурсов
            curl_close($ch);

        }
    */

    public function index_register() {
        return view('auth.register');
    }

    public function ajax_user_form() {
        return view('auth.ajax.user_form');
    }

    public function ajax_company_form() {
        return view('auth.ajax.company_form');
    }

    public function user_store(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:2',
            'gender' => 'required',
            'age' => 'required|integer',
            'country' => 'required',
            'city' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'condition' => 'required'
        ]);

        $name = $request->input('name');
        $gender = $request->input('gender');
        $age = $request->input('age');
        $country = $request->input('country');
        $city = $request->input('city');
        $contact = $request->input('contact');
        $email = $request->input('email');
        $password = bcrypt($request->input('password'));
        $noticed = 1;
        $verified = 0;
        $blocked = 0;
        $type = 0;
        $ip = $request->ip();

        $user = new User();
        $user->name = $name;
        $user->gender = $gender;
        $user->age = $age;
        $user->password = $password;
        $user->country = $country;
        $user->city = $city;
        $user->contact = $contact;
        $user->email = $email;
        $user->password = $password;
        $user->noticed = $noticed;
        $user->verified = $verified;
        $user->blocked = $blocked;
        $user->type = $type;
        $user->ip = $ip;
        $user->save();

        Auth::login($user);

        // Send mail future
        /*        
            $message = "для завершения регистрации на сайте 'party-scope.com', необходимо подтвердить свою учётную запись, перейдя по ссылке ниже.";
            $string_compare = bcrypt($email);
            $link = route('confirms_account', ['string_compare' => $string_compare]);
            Mail::send('layouts.miniTpl.email', [
                    'name' => $name,
                    'link' => $link,
                    'message' => $message,
                    'string_compare' => $string_compare
                ], 
                function($message) use ($email) {
                    $message
                    ->to($email)
                    ->subject('You have a message from portfolio-reym!');
                }
            );
        */

        $response = [];
    	$response['status'] = 'success';
        $response['message'] = 'Поздравляем ' . Auth::user()->name . '! Вы создали аккаунт!';
        $response['redirect'] = route('account');
        echo json_encode($response);
    }


    public function confirms_account($string_compare) {
        return 'confirms mail';
    }

    public function index_login() {
    	return view('auth.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect(route('account'));
        } else {        
            $message = 'Email or Password not valid';
            return redirect()->back()->withInput()->with('message', $message);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect(route('index_login'));
    }
}