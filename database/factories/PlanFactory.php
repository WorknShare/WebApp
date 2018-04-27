<?php

use Faker\Generator as Faker;

$factory->define(App\Plan::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->randomFloat(2, 0, 250),
        'description' => $faker->sentence(),
        'notes' => $faker->sentence(),
        'order_meal' => $faker->boolean,
        'reserve' => $faker->boolean
    ];
});
