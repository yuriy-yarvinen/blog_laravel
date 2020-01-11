<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use App\Author;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [];
});

// $factory->afterCreating(Profile::class, function($profile,$faker){
// 	$profile->author()->save(factory(Author::class)->make());
// });
