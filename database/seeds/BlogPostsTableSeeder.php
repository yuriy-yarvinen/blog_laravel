<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// $blogPostsCount = max((int)$this->command->ask('How many posts do you want?',50), 1);
		$blogPostsCount = (int)$this->command->ask('How many posts do you want?',50);

		$all_users = App\User::all();
		factory(App\BlogPost::class, $blogPostsCount)->make()->each(function($post) use ($all_users){
			$post->user_id = $all_users->random()->id;
			$post->save();
		});
    }
}
