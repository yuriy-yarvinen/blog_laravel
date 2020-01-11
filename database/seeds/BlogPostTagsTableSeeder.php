<?php

use App\BlogPost;
use App\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$tagsCount = Tag::all()->count();
		
		if ($tagsCount === 0) {
			$this->command->info('No tags found, skip this action');
			return;
		}

		$howManyMin = (int)$this->command->ask('Minimal tags?', 0);
		$howManyMax = min((int)$this->command->ask('Max tags?', $tagsCount), $tagsCount);

		BlogPost::all()->each(function (BlogPost $post) use ($howManyMin, $howManyMax){
			$take = random_int($howManyMin, $howManyMax);
			$tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
			$post->tags()->sync($tags);
		});
    }
}
