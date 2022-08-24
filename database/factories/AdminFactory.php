<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Admin::class, function (Faker $faker) {
    return [  
        'name'=>$faker->name,
        'email'=>$faker->unique()->safeEmail(),
        'phone'=>$faker->unique()->phoneNumber,
        'password'=>bcrypt('123asd'),
        'role'=>1,
        'avatar'=>'https://picsum.photos/200/300?random='.$faker->randomNumber(),
        'status'=>1,//$faker->randomElement([0,1]),
        'created_at'=>Carbon::now(),
    ];
});
