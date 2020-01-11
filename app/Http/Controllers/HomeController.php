<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
		public function home()
		{
			// dd(Auth::id());
			// dd(Auth::user());
			// dd(Auth::user()->name);
			// dd(Auth::user()->type);
			// dd(Auth::check());
			return view('welcome');
		}

		public function contacts()
		{
			return view('contacts');
		}

		public function secret()
		{
			return view('secret');
		}

		// public function blogPost($id,$hello)
		// {
		// 	$params = [
		// 		1 => [
		// 			'title'=>'Welcome '
		// 		],
		// 		2 => [
		// 			'title'=>'Hello '
		// 			]
		// 	];
			
		// 	$welcoms = [
		// 		1 => 'friend',
		// 		2 => 'pal'
		// 	];
	
		// 	return view('blog-post',[
		// 		'data' => $params[$id],
		// 		'hi' => $welcoms[$hello]
		// 	]);
		// }
}
