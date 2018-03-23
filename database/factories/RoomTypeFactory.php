<?php

use Faker\Generator as Faker;

$factory->define(App\RoomTypes::class, function (Faker $faker) {
    return [
        'name' => $faker->streetName
    ];
});
