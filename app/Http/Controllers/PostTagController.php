<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function index($tagId){
		$tag = Tag::findOrFail($tagId);
		return view('posts.index',
		[
			// 'posts' => BlogPost::scopes('Newlatest')->withCount('comments')->with('user')->tag()->find($tagId)->get(),
			'posts' => $tag->BlogPost()->postWithRelations()->get(),
		]
		);
	}
}
