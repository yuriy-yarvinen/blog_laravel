<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

// use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
		// 	'name' => 'Юрий',
		// 	'email' => 'dhfksjafd@djfhdsj.ru',
		// 	'email_verified_at' => now(),
		// 	'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
		// 	'remember_token' => Str::random(10),
		// 	'type' => 2,			
		// ]);

		// $else_users = factory(App\User::class,25)->create();
		// $user_yuriy = factory(App\User::class)->states('test_new_user')->create();

		// $all_users = $else_users->concat([$user_yuriy]);

		// dd($all_users->count());

		// $posts = factory(App\BlogPost::class,50)->make()->each(function($post) use ($all_users){
		// 	$post->user_id = $all_users->random()->id;
		// 	$post->save();
		// });

		// $comments = factory(App\Comment::class,150)->make()->each(function($comment) use ($posts){
		// 	$comment->blog_post_id = $posts->random()->id;
		// 	$comment->save();
		// });

		// $this->call(UsersTableSeeder::class);
		// $this->call(BlogPostsTableSeeder::class);
		// $this->call(CommentsTableSeeder::class);

		// if ($this->command->confirm('Do you want to refresh database?', true)) {
		// 	$this->command->call('migrate:refresh');
		// 	$this->command->info('Database was refreshed');
		// }
		if ($this->command->confirm('Do you want to refresh database?',true)) {
			$this->command->call('migrate:refresh');
			$this->command->info('Database was refreshed');
		}

		Cache::tags(['blog-post'])->flush();

		$this->call([
			UsersTableSeeder::class,
			BlogPostsTableSeeder::class,
			CommentsTableSeeder::class,
			TagsTableSeeder::class,
			BlogPostTagsTableSeeder::class,
		]);

    }
}
