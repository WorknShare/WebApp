<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\ReserveRoom::class, function (Faker $faker) {

    $dateStart = Carbon::createFromTimeStamp($faker->dateTimeBetween('-1 year', 'now')->getTimestamp());
    $dateEnd = $dateStart->copy()->addHours($faker->numberBetween(1, 3));

    return [
      'id_client' => App\User::inRandomOrder()->first()->id_client,
      'id_room' => App\Room::inRandomOrder()->first()->id_room,
      'date_start' => $dateStart,
      'date_end' => $dateEnd,
      'command_number' => $faker->uuid
    ];
});
