<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class AuthController extends Controller
{
    // public function __construct() {
    //     // создание нового cURL ресурса
    //     $ch = curl_init();

    //     // устрановка параметров
    //     curl_setopt($ch, CURLOPT_URL, "https://api.vk.com/method/database.getCountries?need_all&access_token=83e2d3fb83e2d3fb83509f1f8183b8bc76883e283e2d3fbdb2b9eaaab67dfda22037aeb&v=5.62");

    //     // загрузка страницы и выдача её браузеру
    //     $countries = curl_exec($ch);

    //     // завершение сеанса и освобождение ресурсов
    //     curl_close($ch);

    // }

    public function user_register() {
    	return view('auth.user.register');
    }

    public function user_store() {
    	return 'user_store';
    }

    public function user_login() {
    	return view('auth.user.login');
    }

    public function company_register() {
    	return 'company register';
    }

    public function company_login() {
    	return 'company login';
    }

}
