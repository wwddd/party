<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class CooperationController extends Controller
{
    public function index() {
    	return view('cooperation.cooperation');
    }

    public function ads_store(Request $request) {
    	// $this->validate($request, [
    	// 	'title' => 'required',
    	// 	'image' => 'mimes:jpeg,png,gif|required',
    	// 	'link' => 'required',
    	// 	'end' => 'required',
     //        'condition' => 'required',
    	// ]);

        // Обработка фоток (не больше 200 кб)

    	//record picture in file system
    	// $path_to_pictures = base_path().'/public/images/ads/';
    	// $file_name = time() . "_" . Input::file('image')->getClientOriginalName();
    	// Input::file('image')->move($path_to_pictures, $file_name);

        $image = $request->file('image');

        if($image != null) {
                $count = 0;
                $img = Image::make($image);
                $natural_width = $img->width();
                $natural_height = $img->height();
                $file_name = Auth::user()->id . '-' . 
                             Auth::user()->name . '-' . 
                             $count . '' . 
                             time() . '.' .
                             $image->getClientOriginalExtension();

                $img->resize(220, 160, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(base_path() . '/public/images/ads/' . $file_name, 100);

                $image_path = base_path().'/images/ads/' . $file_name;
        }

    	$title = $request->input('title');
    	// $image_path = $path_to_pictures . $file_name;
    	$link = $request->input('link');
    	// date when payment expires

        $time = time();
        $days = (3600 * 24) * intval($request->input('end'));
        $end = $time + $days;

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

    	return redirect()->back()->with('message', 'Спасибо за покупку, теперь ваша реклама активна!');
    }

    public function ajax_ads() {
    	return view('cooperation.ajax.ads');
    }

    public function ajax_membership() {
    	return view('cooperation.ajax.membership');
    }
}
