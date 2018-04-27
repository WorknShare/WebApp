<?php

use Faker\Generator as Faker;

$factory->define(App\PlanAdvantage::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence()
    ];
});
