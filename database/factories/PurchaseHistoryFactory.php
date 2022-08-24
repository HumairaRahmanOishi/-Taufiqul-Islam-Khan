<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PurchaseHistory;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(PurchaseHistory::class, function (Faker $faker) {
    
    $packageInfo=App\Models\Package::inRandomOrder()->first();

    return [
        // 'listernerId'=>
        'packageId'=>$packageInfo->id,
        'price'=>$packageInfo->price,
        'tranxId'=>substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,10),
        'bkashNo'=>$faker->phoneNumber,
        'expireDate'=>$packageInfo->validate,
        'status'=>1,
        'created_at'=>Carbon::now(),
    ];
});
