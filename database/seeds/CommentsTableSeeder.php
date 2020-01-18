<?php

use App\BlogPost;
use App\User;
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
		
		if ($posts->count() === 0 || $all_users->count() === 0) {
			$this->command->info('There is no blog posts, or users, so no comments added');
			return;
		}
		$commentsCount = max((int)$this->command->ask('How many comments do you want?',150), 1);

		factory(App\Comment::class, $commentsCount)->make()->each(function($comment) use ($posts, $all_users){
			$comment->user_id = $all_users->random()->id;
			$comment->commentable_id = $posts->random()->id;
			$comment->commentable_type = BlogPost::class;
			$comment->save();
		});

		factory(App\Comment::class, $commentsCount)->make()->each(function($comment) use ($all_users){
			$comment->user_id = $all_users->random()->id;
			$comment->commentable_id = $all_users->random()->id;
			$comment->commentable_type = User::class;
			$comment->save();
		});
    }
}
