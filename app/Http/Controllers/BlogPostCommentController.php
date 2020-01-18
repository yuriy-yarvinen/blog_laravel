<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Jobs\PostWasCommented;
use App\Http\Requests\StoreComment;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Support\Facades\Mail;

class BlogPostCommentController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->only(['store']);	
	}

    public function store(BlogPost $post, StoreComment $request)
	{
		$comment = $post->comments()->create([
			'content' => $request->input('comment'),
			'user_id' => $request->user()->id
		]);

		// Mail::to($post->user)->send(
		// 	new CommentPostedMarkdown($comment)
		// );

		Mail::to($post->user)->queue(
			new CommentPostedMarkdown($comment)
		);

		PostWasCommented::dispatch($comment);

		// $when = now()->addMinutes(1);
		// Mail::to($post->user)->later(
		// 	$when,
		// 	new CommentPostedMarkdown($comment)
		// );

		// $request->session()->flash('request_status','Коммент добавлен');

		// return redirect()->route('posts.show',['post' => $post->id]);
		return redirect()->back()
		->withRequestStatus('Комментарий добавлен');
	}
}
