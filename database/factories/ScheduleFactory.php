<?php

use Faker\Generator as Faker;

$factory->define(App\Schedule::class, function (Faker $faker) {
	$closing = $faker->time('H:i', '23:00');
    return [
        'day' => $faker->numberBetween(0,6),
        'hour_opening' => $faker->time('H:i', $closing),
        'hour_closing' => $closing,
    ];
});
