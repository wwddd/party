<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Input;

use DB, Hash;

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

        $name = $request->input('name');
        $gender = $request->input('gender');
        $age = $request->input('age');
        $country = $request->input('country');
        $city = $request->input('city');
        $contact = $request->input('contact');
        $email = $request->input('email');
        $password = $request->input('password');

        $this->validate($request, [
            'name' => 'required|min:2',
            'gender' => 'required',
            'age' => 'required|integer',
            'country' => 'required',
            'city' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        DB::table('users')->insert(array(
            'name' => $name,
            'gender' => $gender,
            'age' => $age,
            'country' => $country,
            'city' => $city,
            'contact' => $contact,
            'email' => $email,
            'password' => bcrypt($password)
        ));

    	return redirect()->back();
    }

    public function index_login() {
    	return view('auth.login');
    }

    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $hashed_password = DB::table('users')->where('email', $email)->first();

        // this big logic need because if hashed_password will be equal false, process crash
        if (!$hashed_password) {
            return redirect()
                ->back()
                ->with('message', 'email or password not valid')
                ->withInput();
        } else {
            $check_passwords = Hash::check($password, $hashed_password->password);

            if (!$check_passwords) {
                return redirect()
                    ->back()
                    ->with('message', 'email or password not valid')
                    ->withInput();
            } else {
                return redirect(route('account'))->with('message', 'Welcome your account падла');
            }
        }
    }
}
