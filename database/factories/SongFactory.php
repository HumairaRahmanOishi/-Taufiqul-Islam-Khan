<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Song;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Song::class, function (Faker $faker) {
    
    // $albumInfo=App\Models\Album::inRandomOrder()->first();

    return [
        'name'=>$faker->name,
        'description'=>$faker->realText(),
        'length'=>$faker->time(),
        'musicUrl'=>'songs/'.$faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36]).'.mp3',
        // 'albumId'=>$albumInfo->id,
        // 'artistId'=>$albumInfo->artistId,
        'status'=>1,
        'created_at'=>Carbon::now(),
    ];
});
