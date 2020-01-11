<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StoreComment;
use Illuminate\Http\Request;

class BlogPostCommentController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->only(['store']);	
	}

    public function store(BlogPost $post, StoreComment $request)
	{
		$post->comments()->create([
			'content' => $request->input('comment'),
			'user_id' => $request->user()->id
		]);

		$request->session()->flash('request_status','Коммент добавлен');

		// return redirect()->route('posts.show',['post' => $post->id]);
		return redirect()->back();
	}
}
