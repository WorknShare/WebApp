<?php

use Faker\Generator as Faker;

$factory->define(App\Site::class, function (Faker $faker) {
    return [
        //'name' => $faker->unique()->streetName,
        'name' => $faker->unique()->streetName,
        'address' => $faker->unique()->address,
        'wifi' => $faker->boolean,
        'drink' => $faker->boolean,
    ];
});
