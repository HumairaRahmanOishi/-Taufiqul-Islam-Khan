<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PlayListSong;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(PlayListSong::class, function (Faker $faker) {
    $songInfo=App\Models\Song::inRandomOrder()->first();
    return [
        'songId'=>$songInfo->id,
        'status'=>1,
        'created_at'=>Carbon::now(),
    ];
});
