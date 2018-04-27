<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'place' => $faker->numberBetween(5,25),
        'id_room_type' => App\RoomTypes::inRandomOrder()->first()->id_room_type
    ];
});
