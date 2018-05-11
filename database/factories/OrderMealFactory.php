<?php

use Faker\Generator as Faker;

$factory->define(App\ReserveMeal::class, function (Faker $faker) {

    $date = $faker->dateTimeBetween('-1 year', '+1 year');
    $site = App\Site::inRandomOrder()->first();
    return [
      'id_client' => App\User::inRandomOrder()->first()->id_client,
      'id_site' => $site->id_site,
      'hour' => $date,
      'command_number' => $faker->uuid,
      'id_meal' => $site->meals()->inRandomOrder()->first()->id_meal
    ];
});
