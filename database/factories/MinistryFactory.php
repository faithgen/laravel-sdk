<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use FaithGen\SDK\Models\Ministry;
use Faker\Generator as Faker;

$factory->define(Ministry::class, function (Faker $faker) {
    return [
        'name'     => $faker->company,
        'email'    => $faker->safeEmail,
        'phone'    => $faker->phoneNumber,
        'password' => \Illuminate\Support\Facades\Hash::make('secret'),
    ];
});
