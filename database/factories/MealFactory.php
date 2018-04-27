<?php

use Faker\Generator as Faker;

$factory->define(App\Meal::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->randomFloat(2, 0, 100),
        'menu' => $faker->text($faker->numberBetween(50, 100))
    ];
});
