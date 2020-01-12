<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use App\User;
use App\Comment;
use App\Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
	public function __construct()
	{
		// $this->middleware('auth');
		$this->middleware('auth')->only(['store','edit','update','destroy']);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//DB::connection()->enableQueryLog();

		// $posts = BlogPost::all();
		// $posts = BlogPost::with('comments')->get();

		// foreach($posts as $post)
		// {
		// 	foreach($post->comments as $comment)
		// 	{
		// 		echo $comment->content;
		// 	}
		// }

		// dd(DB::getQueryLog());

		// remove to ViewComposers ActivityComposer
		// $most_commented = Cache::tags(['blog-post'])->remember('most_commented', now()->addSeconds(20), function () {
		// 	return BlogPost::mostCommented()->take(5)->get();
		// });

		// $most_active = Cache::tags(['blog-post'])->remember('most_active', 60, function () {
		// 	return User::mostActive()->take(5)->get();
		// });

		// $most_active_last_month = Cache::tags(['blog-post'])->remember('most_active_last_month', 60, function () {
		// 	return User::mostActiveLastMonth()->take(5)->get();
		// });

		return view('posts.index',
			// ['posts' => BlogPost::withCount('comments')->orderBy('created_at', 'desc')->get()]
			[
				// 'posts' => BlogPost::scopes('Newlatest')->withCount('comments')->get(),
				'posts' => BlogPost::postWithRelations()->get(),
				// 'most_commented' => $most_commented,
				// 'most_active' => $most_active,
				// 'most_active_last_month' => $most_active_last_month,
			]
		);
    }

	   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		// return view('posts.show',['post' => BlogPost::find($id)]);
		// $request->session()->reflash();
		// return view('posts.show',['post' => BlogPost::findOrFail($id)]);

		// return view('posts.show',['post' => BlogPost::with(['comments' => function($query){
		// 	return $query->scopes('Latest');
		// }])->findOrFail($id)]);

		$userSessionId = session()->getId();
		$counterKey = "blog-post-$id-counter";
		$usersKey = "blog-post-$id-users";

		$usersInCache = Cache::tags(['blog-post'])->get($usersKey, []);
		$usersUpdate = [];
		$diffrence = 0;
		$now = now();

		foreach ($usersInCache as $session => $lastVisit) {
			if ($now->diffInMinutes($lastVisit) >= 1) {
				$diffrence--;
			}
			else{
				$usersUpdate[$session] = $lastVisit;
			}
		}

		if (
			!array_key_exists($userSessionId, $usersInCache) ||
			$now->diffInMinutes($usersInCache[$userSessionId]) >= 1 
		) {
			$diffrence++;
		}

		$usersUpdate[$userSessionId] = $now;
		Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);
		if (!Cache::tags(['blog-post'])->has($counterKey)) {
			Cache::tags(['blog-post'])->forever($counterKey, 1);
		}
		else{
			Cache::tags(['blog-post'])->increment($counterKey, $diffrence);
		}

		$userCounter = Cache::tags(['blog-post'])->get($counterKey);

		$blogPost = Cache::tags(['blog-post'])->remember("blog-post-$id", 60, function () use ($id) {
			return BlogPost::with('comments', 'tags', 'user', 'comments.user', 'image')
			->findOrFail($id);
		});

		return view('posts.show',[
			'post' => $blogPost,
			'userCounter' => $userCounter
		]);
	}
		
    public function create()
    {
		return view('posts.create');
	}
		
    public function store(StorePost $request)
    {
		$validatedData = $request->validated();
		$validatedData['user_id'] = $request->user()->id;

		// dd($validatedData);

		// $blogPost = new BlogPost();
		// $blogPost->title = $request->input('title');
		// $blogPost->content = $request->input('content');
		// $blogPost->json = $request->input('json');
		// $blogPost->save();

		$blogPost = BlogPost::create($validatedData);

		// $hasFile = $request->hasFile('image');

		// dump($hasFile);

		if ($request->hasFile('image')) {
			$path = $request->file('image')->store('image');

			$blogPost->image()->save(
				Image::create([
					'path' => $path
				])
			);

			// dump($file);
			// dump($file->getClientMimeType());
			// dump($file->getClientOriginalExtension());
			// dump($file->store('images'));
			// dump(Storage::disk('public')->putFile('images', $file));

			// $name1 = $file->storeAs('images', $blogPost->id . '.' . $file->guessExtension());
			// $name3 = $file->storeAs('image', $blogPost->id . '.' . $file->guessExtension());
			// dump(Storage::putFileAs('images', $file , $blogPost->id . '.' . $file->guessExtension()));
			// $name2 = Storage::disk('local')->putFileAs('images', $file , $blogPost->id . '.' . $file->guessExtension());

			// dump(Storage::url($name1));
			// dump(Storage::disk('local')->url($name2));
			
		}

		$request->session()->flash('request_status','Пост создан');
		
		return redirect()->route('posts.show',['post' => $blogPost->id]);
	}

    public function edit($id)
    {
		$post = BlogPost::findOrFail($id);
		// if (Gate::denies('update-post', $post)) {
		// 	abort(403, "You can't edit this blog post");
		// }
		$this->authorize('update', $post);
		return view('posts.edit',['post' => $post]);
	}

    public function update(StorePost $request, $id)
    {
		$validatedData = $request->validated();

		$post = BlogPost::findOrFail($id);

		// if (Gate::denies('update-post', $post)) {
		// 	abort(403, "You can't edit this blog post");
		// }
		$this->authorize('update', $post);
		$post->fill($validatedData);

		if ($request->hasFile('image')) {
			$path = $request->file('image')->store('image');

			if ($post->image) {
				Storage::delete($post->image->path);
				$post->image->path = $path;
				$post->image->save();
			}
			else {
				$post->image()->save(
					Image::create([
						'path' => $path
					])
				);				
			}
		}

		$post->save();

		$request->session()->flash('request_status','Пост обновлен');
		
		return redirect()->route('posts.show',['post' => $post->id]);
	}

    public function destroy(Request $request, $id)
    {
		$post = BlogPost::findOrFail($id);

		// if (Gate::denies('delete-post', $post)) {
		// 	abort(403, "You can't delete this blog post");
		// }
		$this->authorize('delete', $post);
		$title = $post->title;

		$post->delete();

		// BlogPost::destroy($id);

		$request->session()->flash('request_status',"Пост $title удален");

		return redirect()->route('posts.index');
	}

}
