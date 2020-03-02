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

$factory->define(\App\Subscription::class, function (Faker $faker) {
    $service_id = factory(\App\Service::class)->create();
    $subscriber_id = factory(\App\Subscriber::class)->create();
    return [
        'service_id' => $service_id,
        'subscriber_id' => $subscriber_id,
        'insert_date' => $faker->date('Y-m-d'),
        'deleted_at' => null
    ];
});
