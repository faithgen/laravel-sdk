<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use FaithGen\SDK\Helpers\Helper;
use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Models\Ministry\Account;
use FaithGen\SDK\Models\Ministry\Activation;
use FaithGen\SDK\Models\Ministry\Profile;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(\FaithGen\SDK\Models\Ministry::class, function (Faker $faker) {
    return [
        'name'       => $faker->company,
        'email'      => $faker->safeEmail,
        'phone'      => $faker->phoneNumber,
        'password'   => Hash::make('secret'),
        'id'         => Str::uuid()->toString(),
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString(),
    ];
});

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'id'        => Str::uuid()->toString(),
        'about_us'  => $faker->randomHtml(2, 3),
        'mission'   => $faker->sentence(75),
        'vision'    => $faker->sentence(75),
        'website'   => $faker->url,
        'facebook'  => $faker->url,
        'youtube'   => $faker->url,
        'twitter'   => $faker->url,
        'instagram' => $faker->url,
        'color'     => $faker->hexColor,
        'phones'    => [
            $faker->phoneNumber,
            $faker->phoneNumber,
        ],
        'emails'    => [
            $faker->email,
            $faker->email,
        ],
    ];
});

$factory->define(Account::class, function () {
    return [
        'id' => Str::uuid()->toString(),
    ];
});

$factory->define(Activation::class, function (Faker $faker) {
    return [
        'id'     => Str::uuid()->toString(),
        'code'   => $faker->randomNumber(7),
        'active' => true,
    ];
});

$factory->define(Ministry\APIKey::class, function () {
    return [
        'id'      => Str::uuid()->toString(),
        'api_key' => str_shuffle(Str::uuid()->toString()),
    ];
});

$factory->define(Ministry\DailyService::class, function (Faker $faker) {
    return [
        'id'     => Str::uuid()->toString(),
        'day'    => Helper::$weekDays[(rand(0, count(Helper::$weekDays) - 1))],
        'alias'  => $faker->word,
        'start'  => '08:00',
        'finish' => '11:00',
    ];
});
