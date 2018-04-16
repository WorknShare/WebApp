<?php

use Faker\Generator as Faker;

$factory->define(App\EquipmentType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'is_deleted' => 0
    ];
});
