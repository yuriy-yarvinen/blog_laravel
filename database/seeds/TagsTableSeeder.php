<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$tags = collect(['Sport', 'Economy', 'Science', 'Anime', 'Tv']);

		$tags->each(function ($tagName){
			$tag = new Tag();
			$tag->name = $tagName;
			$tag->save();
		});
    }
}
