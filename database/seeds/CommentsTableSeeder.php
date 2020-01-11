<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$posts = App\BlogPost::all();
		$all_users = App\User::all();
		
		if ($posts->count() === 0) {
			$this->command->info('There is no blog posts, so no comments added');
			return;
		}
		$commentsCount = max((int)$this->command->ask('How many comments do you want?',150), 1);

		factory(App\Comment::class, $commentsCount)->make()->each(function($comment) use ($posts, $all_users){
			$comment->blog_post_id = $posts->random()->id;
			$comment->user_id = $all_users->random()->id;
			$comment->save();
		});
    }
}
