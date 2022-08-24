<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PermissionFactory;
use Faker\Generator as Faker;

$factory->define(PermissionFactory::class, function (Faker $faker) {
    return [
        // 'roleId'=>
        // 'permissionName'=>'A'
        // 'permissionCode'=>1
        // 'status'=>1,
        // 'created_at'=>Carbon::now(),
    ];
});
