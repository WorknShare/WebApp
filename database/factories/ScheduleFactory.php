<?php

use Faker\Generator as Faker;

$factory->define(App\Schedule::class, function (Faker $faker) {
	$closing_hour = $faker->numberBetween(16,23);
	$closing_minute = $faker->numberBetween(0,59);
	if($closing_minute < 10) $closing_minute = '0'.$closing_minute;

	$opening_hour = $faker->numberBetween(2,$closing_hour-1);
	$opening_minute = $faker->numberBetween(0,59);
	if($opening_hour < 10) $opening_hour = '0'.$opening_hour;
	if($opening_minute < 10) $opening_minute = '0'.$opening_minute;

    return [
        'day' => $faker->numberBetween(0,6),
        'hour_opening' => $opening_hour.':'.$opening_minute,
        'hour_closing' => $closing_hour.':'.$closing_minute,
    ];
});
