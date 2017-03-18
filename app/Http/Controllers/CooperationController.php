<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input; 
use App\Http\Controllers\Controller;

class CooperationController extends Controller
{
    public function index() {
    	return view('cooperation.cooperation');
    }

    public function ads_store(Request $request) {
    	$this->validate($request, [
    		'title' => 'required',
    		'image' => 'required',
    		'link' => 'required',
    		'end' => 'required'
    	]);

    	// record picture in file system
    	$path_to_pictures = base_path().'public/images';
    	$file_name = time() . "_" . Input::file('image')->getClientOriginalName();
    	Input::file('image')->move($path_to_pictures, $file_name);

    	
    	
    	return 'store';
    }

    public function ajax_ads() {
    	return view('cooperation.ajax.ads');
    }

    public function ajax_membership() {
    	return view('cooperation.ajax.membership');
    }
}
