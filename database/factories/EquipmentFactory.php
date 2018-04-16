<?php

use Faker\Generator as Faker;

$factory->define(App\Equipment::class, function (Faker $faker) {
    return [
        'serial_number' => $faker->uuid,
        'is_deleted' => 0
    ];
});
