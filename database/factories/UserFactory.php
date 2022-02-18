<?php

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

$factory->define(LaraBooking\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'description' => $faker->sentence,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip_code' => $faker->postcode,
    ];
});
