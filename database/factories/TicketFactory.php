<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {
    return [
        'status' => $faker->numberBetween(0, 4),
        'description' => $faker->text($faker->numberBetween(100, 400)) ,
        'id_equipment' => App\Equipment::inRandomOrder()->first()->id_equipment,
        'id_employee_src' => App\Employee::where([['role', '<' , 4],['role', '>' , 0]])->inRandomOrder()->first()->id_employee,
        'id_employee_assigned' => App\Employee::where('role', '=' , 4)->inRandomOrder()->first()->id_employee
    ];
});
