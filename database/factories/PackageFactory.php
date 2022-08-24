<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Package;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Package::class, function (Faker $faker) {
    
    
    return [
        'title'=>$faker->name,
        'description'=>$faker->realText(),
        'validate'=>Carbon::now()->add('65 days'),
        'price'=>$faker->numberBetween(10,1000),
        'status'=>1,
        'created_at'=>Carbon::now(),
    ];
});
