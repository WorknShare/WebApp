<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        'surname' => $faker->firstNameMale,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address(),
        'role' => $faker->numberBetween(1,4),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'changed_password' => 1,
    ];
});
