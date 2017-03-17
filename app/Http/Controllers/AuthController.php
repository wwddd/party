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













// namespace App\Http\Controllers;

// use App\User;
// use DB;
// use Illuminate\Http\Request;
// use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Database\Eloquent\Model;


// class UserController extends Controller
// {

//     public function signup(Request $request)
//     {
//         $validation = $this->validate($request, [
//             'email' => 'required|email|unique:users',
//             'first_name' => 'required|max:120',
//             'touted' => 'required|max:120',
//             'password' => 'required|min:4',
//             'account_type' => 'required',
//             'phone' => 'required|numeric',
//             'announcement' => 'required',
//             'sex' => 'required',
//             'service' => 'required',
//             'region' => 'required',
//             'for' => 'required'
//         ]);

//         $email = $request['email'];
//         $touted = $request['touted'];
//         $name = $request['first_name'];
//         $password = bcrypt($request['password']);
//         $is_agency = $request['account_type'];
//         $phone = $request['phone'];
//         $membership = time() + 3600;

//         $user = new User();
//         $user->email = $email;
//         $user->touted = $touted;
//         $user->name = $name;
//         $user->password = $password;
//         $user->is_agency = $is_agency;
//         $user->phone = $phone;
//         $user->membership = $membership;

//         $user->save();

//         $regions_array = array();
//         for($i = 0; $i < count($request['region']); $i++) {
//             $regions_array[$request['region'][$i]] = '1';
//         }
//         $regions_array['user_id'] = $user->id;
//         DB::table('regions')->insert($regions_array);

//         $services_array = array();
//         for($i = 0; $i < count($request['service']); $i++) {
//             $services_array[$request['service'][$i]] = '1';
//         }
//         $services_array['user_id'] = $user->id;
//         DB::table('services')->insert($services_array);

//         $user_data_array = array();
//         for($i = 0; $i < count($request['for']); $i++) {
//             $user_data_array[$request['for'][$i]] = '1';
//         }
//         $user_data_array['user_id'] = $user->id;
//         if(isset($request['age'])){
//             $user_data_array['age'] = $request['age'];
//         }
//         if(isset($request['height'])){
//             $user_data_array['height'] = $request['height'];
//         }
//         if(isset($request['eye'])){
//             $user_data_array['eye'] = $request['eye'];
//         }
//         if(isset($request['hair'])){
//             $user_data_array['hair'] = $request['hair'];
//         }
//         if(isset($request['bust'])){
//             $user_data_array['bust'] = $request['bust'];
//         }
//         if(isset($request['body'])){
//             $user_data_array['body'] = $request['body'];
//         }
//         if(isset($request['announcement'])){
//             $user_data_array['text'] = $request['announcement'];
//         }
//         if(isset($request['sex'])){
//             $user_data_array['sex'] = $request['sex'];
//         }
//         DB::table('users_data')->insert($user_data_array);


//         Auth::login($user);

//         $message = 'Congrats ' . Auth::user()->name . '! You did account!';

//         // return redirect()->route('cabinet')->with('message', $message);

//         return $message;
//     }

//     public function signin(Request $request)
//     {
//         $this->validate($request, [
//             'email_in' => 'required',
//             'password_in' => 'required'
//         ]);

//         if (Auth::attempt(['email' => $request['email_in'], 'password' => $request['password_in']])) {
//             $message = 'Welcome, ' . Auth::user()->name . '!';
//             return $message;
//             // return redirect()->route('cabinet')->with('message', $message);
//         }
//         return 'error';
//         // return redirect()->back();
//     }

//     public function logout()
//     {
//         Auth::logout();
//         return redirect()->back();
//     }

//     public function text(Request $request)
//     {

//         $this->validate($request, [
//             'main_text' => 'required'
//         ]);

//         $id = Auth::user()->id;

//         DB::table('users_data')
//             ->where('user_id', '=', $id)
//             ->update(['main_text' => $request['main_text']]);

//         return 'Main text was changed!';

//         // return redirect()->back();
//     }

//     public function price(Request $request)
//     {

//         if(!$request['serv'] || !$request['price']) {
//             return 'Please add your prices';
//         }

//         $serv = $request['serv'];
//         $price = $request['price'];

//         for($i = 0; $i < count($serv); $i++) {
//             $result[] = [$serv[$i] => $price[$i]];
//         }

//         $json_result = json_encode($result);

//         $id = Auth::user()->id;

//         DB::table('services')
//             ->where('user_id', '=', $id)
//             ->update(['prices' => $json_result]);

//         return 'Your prices was changed!';
//         // return redirect()->back();
//     }

// }
