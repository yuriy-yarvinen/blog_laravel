<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
		'title' => $faker->sentence(10),
		'content' => $faker->text,
		'json' => json_encode([$faker->word => $faker->word]),
		'created_at' => $faker->dateTimeBetween('-3 months'),
    ];
});

$factory->state(BlogPost::class, 'test_new_title', function (Faker $faker){
	return [
		'title' => 'New title'
	];
});
