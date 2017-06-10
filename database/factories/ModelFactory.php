<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Modules\Admin\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Modules\Admin\Models\Role::class, function (Faker\Generator $faker) {

    return [
        'name' => md5('role'.time().rand(0,10000)),
        'display_name' => str_random(10),
        //'description' => $faker->description,
    ];
});

