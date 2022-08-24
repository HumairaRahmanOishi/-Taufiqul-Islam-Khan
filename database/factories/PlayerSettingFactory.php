<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PlayerSetting;
use Faker\Generator as Faker;
use Carbon\Carbon;


$factory->define(PlayerSetting::class, function (Faker $faker) {
    return [
        // 'listernerId'=>
        'isSuffle'=>$faker->randomElement([0,1]),
        'isRepeat'=>$faker->randomElement([1,2,3]),
        'created_at'=>Carbon::now(),
    ];
});
