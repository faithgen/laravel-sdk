<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Models\Pivots\MinistryUser;
use FaithGen\SDK\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'id'       => Str::uuid()->toString(),
        'name'     => $faker->name,
        'email'    => $faker->safeEmail,
        'phone'    => $faker->phoneNumber,
        'password' => Hash::make('secret'),
    ];
});

$factory->define(MinistryUser::class, function (Faker $faker) {
    return [
        'ministry_id' => Ministry::inRandomOrder()->first()->id,
        'id'          => Str::uuid()->toString(),
    ];
});
