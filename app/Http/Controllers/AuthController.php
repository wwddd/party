<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\User;
use DB, Crypt, Exception;

use App\Http\Controllers\MailController;

class AuthController extends Controller
{
    public function index_register() {
        return view('auth.register');
    }

    public function ajax_user_form() {
        return view('auth.ajax.user_form');
    }

    public function ajax_company_form() {
        return view('auth.ajax.company_form');
    }

    public function user_store(Request $request, MailController $mail) {
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

        $check = DB::table('users')
                            ->where('email', $email)
                            ->get();

        if (count($check) == 1) {
            $response = [];
            $response['status'] = 'fail';
            $response['message'] = 'Пользотватель с данным email уже существует! Выберите другой адрес электронной почты';
            return json_encode($response);
        } else {
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

            try {
                $mail->send_verify_account($email);
            } catch (Exception $e) {}

            $response = [];
            $response['status'] = 'success';
            $response['message'] = 'Регистрация прошла успешно!';
            $response['redirect'] = route('account');
            return json_encode($response);
        }
    }

    public function again_verify_account(MailController $mail) {
        try {
            $mail->re_send_verify_account();
            $response = [];
            $response['status'] = 'success';
            $response['message'] = 'Проверьте почту';
            // $response['redirect'] = route('account');
            return json_encode($response);
        } catch (Exception $e) {
            // dd($e->getMessage());
            $response = [];
            $response['status'] = 'fail';
            $response['message'] = 'Что-то пошло не так';
            // $response['redirect'] = route('account');
            return json_encode($response);
        } 
    }

    public function confirm_account($token) {
        $decrypted = Crypt::decrypt($token);
        $result = DB::table('users')
                        ->where('email', $decrypted)
                        ->get();

        if (count($result) == 1) {
            DB::table('users')
                        ->where('email', $decrypted)
                        ->update(array(
                            'verified' => 1
                        ));
            if (!Auth::check()) {
                return redirect(route('login'))
                                    ->with('message', 'Подтверждение прошло успешно');                
            } else {
                return redirect(route('account'))
                                    ->with('message', 'Подтверждение прошло успешно');
            }
        } else {        
            return redirect(route('account'))
                                ->with('message', 'Что то пошло не так...Попробуйте ещё раз!');
        }
    }

    public function forgot_password() {
        return view('auth.forgot_password');
    }

    public function reset_password_init(Request $request, MailController $mail) {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $email = $request->input('email');

        $check = DB::table('users')
                            ->where('email', $email)
                            ->get();

        if (count($check) == 1) {
            try {
                $mail->send_new_password_confirm($email);
            } catch (Exception $e) {
                $response = [];
                $response['status'] = 'fail';
                $response['message'] = 'Что-то пошло не так';
                return json_encode($response);
            }
        } else {
            $response = [];
            $response['status'] = 'fail';
            $response['message'] = 'Пользователя с данной почтой не существует';
            return json_encode($response);
        }

        $response = [];
        $response['status'] = 'success';
        $response['message'] = 'Зайдите на вашу почту и подтвердите сброс пароля';
        return json_encode($response); 
    }

    public function reset_password_confirm($string_compare) {
        $decrypted = Crypt::decrypt($string_compare);

        $result = DB::table('users')
                        ->where('email', $decrypted)
                        ->get();

        if (count($result) == 1) {
            return view('auth.reset_password', ['user_id' => $result[0]->id]);
        } else {
            return view('templates.page_not_found');
        }
    }

    public function reset_password(Request $request, $user_id) {
        $password = bcrypt($request->input('password'));

        DB::table('users')
                    ->where('id', $user_id)
                    ->update(array(
                        'password' => $password
                    ));

        $response = [];
        $response['status'] = 'success';
        $response['message'] = 'Пароль успешно изменён!';
        $response['redirect'] = route('login');
        return json_encode($response);
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
            $response = [];
            $response['status'] = 'success';
            $response['message'] = 'Успешно';
            $response['redirect'] = route('account');
            return json_encode($response);
        } else {
            $response = [];
            $response['status'] = 'fail';
            $response['message'] = 'Неправильный email или пароль';
            return json_encode($response);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect(route('index_login'));
    }
}