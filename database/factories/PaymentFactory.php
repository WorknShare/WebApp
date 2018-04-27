<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Payment::class, function (Faker $faker) {
	$user = App\User::inRandomOrder()->first();
	$date = Carbon::createFromTimeStamp($faker->dateTimeBetween('-1 year', '+1 year')->getTimestamp());
	$limit = Carbon::createFromFormat('Y-m-d H:i:s', $date)->addMonth();

	$exp_year = $faker->numberBetween(2018,2048);
	$exp_month = $faker->numberBetween(1,12);
	if($exp_month < 10) $exp_month = '0'.$exp_month;

	$dateExpiration = new DateTime($exp_year.'-'.$exp_month.'-01');
    $expiration = $dateExpiration->format("Y-m-d"); 

    return [
        'command_number' => $faker->uuid,
        'created_at' => $date,
        'updated_at' => $date,
        'limit_date' => $limit,
        'name' => $user->name,
        'surname' => $user->surname,
        'phone' => $faker->regexify('\d{10}'),
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'postal' => $faker->regexify('[0-9]{5}'),
        'credit_card_number' => $faker->creditCardNumber,
        'csc' => $faker->regexify('[0-9]{3}'),
        'expiration' => $expiration,
        'id_plan' => App\Plan::inRandomOrder()->first()->id_plan,
        'id_client' => $user->id_client
    ];
});
