<?php

namespace App\Http\ViewComposers;

use App\BlogPost;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
	public function compose(View $view)
	{
		$most_commented = Cache::tags(['blog-post'])->remember('most_commented', now()->addSeconds(20), function () {
			return BlogPost::mostCommented()->take(5)->get();
		});

		$most_active = Cache::tags(['blog-post'])->remember('most_active', 60, function () {
			return User::mostActive()->take(5)->get();
		});

		$most_active_last_month = Cache::tags(['blog-post'])->remember('most_active_last_month', 60, function () {
			return User::mostActiveLastMonth()->take(5)->get();
		});

		$view->with('most_commented', $most_commented);
		$view->with('most_active', $most_active);
		$view->with('most_active_last_month', $most_active_last_month);
	}
}