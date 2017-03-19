<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input; 
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DB;

class CooperationController extends Controller
{
    public function index() {
    	return view('cooperation.cooperation');
    }

    public function ads_store(Request $request) {
    	// $this->validate($request, [
    	// 	'title' => 'required',
    	// 	'image' => 'required',
    	// 	'link' => 'required',
    	// 	'condition' => 'required',
    	// 	'end' => 'required'
    	// ]);

    	//record picture in file system
    	$path_to_pictures = base_path().'public/images';
    	$file_name = time() . "_" . Input::file('image')->getClientOriginalName();
    	Input::file('image')->move($path_to_pictures, $file_name);

    	$title = $request->input('title');
    	$image_path = $path_to_pictures . $file_name;
    	$link = $request->input('link');
    	// date when payment expires
    	$end = Carbon::now()->addDays(30);
        dd($end);

    	$ads_id = DB::table('ads')->insertGetId(array(
    		'title' => $title,
    		'image' => $image_path,
    		'link' => $link,
    		'end' => $end
    	));

    	$user_id = $request->user()->id;

    	DB::table('user_ads')->insert(array(
    		'user_id' => $user_id,
    		'ads_id' => $ads_id
    	));

    	return 'store';
    }

    public function ajax_ads() {
    	return view('cooperation.ajax.ads');
    }

    public function ajax_membership() {
    	return view('cooperation.ajax.membership');
    }
}
