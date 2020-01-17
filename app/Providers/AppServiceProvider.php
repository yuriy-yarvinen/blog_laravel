<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		/// lenght for string ingex for morphs
		Schema::defaultStringLength(191);
        Blade::component('components.badge', 'badge');
        Blade::component('components.updated', 'updated');
        Blade::component('components.card', 'card');
		Blade::component('components.tags', 'tags');
		Blade::component('components.errors', 'errors');
		Blade::component('components.comment_form', 'commentForm');
		Blade::component('components.comment_list', 'commentList');
		
		view()->composer(['posts.index','posts.show'], ActivityComposer::class);
		// view()->composer('*', ActivityComposer::class);
    }
}
