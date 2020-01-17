<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\User;

class UserCommentController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->only(['store']);	
	}

    public function store(User $user, StoreComment $request)
	{
		$user->commentsOn()->create([
			'content' => $request->input('comment'),
			'user_id' => $request->user()->id
		]);

		// $request->session()->flash('request_status','Коммент добавлен');

		// return redirect()->route('posts.show',['post' => $post->id]);
		return redirect()->back()
			->withRequestStatus('Комментарий добавлен');
	}
}
