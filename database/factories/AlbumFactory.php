<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Album;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Album::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'genre'=>$faker->name,
        // 'artistId'=>,
        'releaseDate'=>$faker->date,
        'status'=>1,
        'created_at'=>Carbon::now(),
    ];
});
