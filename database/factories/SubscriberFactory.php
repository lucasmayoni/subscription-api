<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Subscriber::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'blocked' => $faker->boolean(50),
        'email' => $faker->email,
        'deleted_at' => null,
        'msisdn' => $faker->e164PhoneNumber
    ];
});
