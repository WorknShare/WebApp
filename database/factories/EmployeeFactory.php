<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        'surname' => $faker->firstNameMale,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
        'role' => $faker->numberBetween(1,4),
        'password' => 'secret',
        'remember_token' => str_random(10),
        'changed_password' => 1,
    ];
});
