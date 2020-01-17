<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\BlogPost' => 'App\Policies\BlogPostPolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('update-post', function($user, $post){
		// 	return $user->id === $post->user_id;
		// });
        // Gate::define('delete-post', function($user, $post){
		// 	return $user->id === $post->user_id;
		// });

		Gate::define('contact.secret', function($user){
			return $user->type === 111;
		});
		Gate::before(function($user, $ability){
			if($user->type === 111 && in_array($ability, ['update','delete', 'restore'])){
				return true;
			}
		});

		// Gate::define('post.update', 'App\Policies\BlogPostPolicy@update');
		// Gate::define('post.delete', 'App\Policies\BlogPostPolicy@delete');

		// Gate::resorce('post', 'App\Policies\BlogPostPolicy');
		// post.create, post.update, post.view, post.delete

		// Gate::after(function($user, $ability, $result){
		// 	if($user->type === 111){
		// 		return true;
		// 	}
		// });
    }
}
