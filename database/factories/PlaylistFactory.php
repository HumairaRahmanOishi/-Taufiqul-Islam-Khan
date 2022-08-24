<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Playlist;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Playlist::class, function (Faker $faker) {
    
    return [
        'name'=>$faker->name,
        'status'=>1,
        'created_at'=>Carbon::now(),
    ];
});
