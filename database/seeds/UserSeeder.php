<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = \Faker\Factory::create();

        factory(App\User::class, 500)->create()->each(function($user) use ($faker) {
            $now = date('Y-m-d H:i:s');
        	$date = Carbon::createFromTimeStamp($faker->dateTimeBetween('-4 year', '-2 month')->getTimestamp());
        	while($date < $now) {
				$limit = Carbon::createFromFormat('Y-m-d H:i:s', $date)->addMonth();

				$payment = factory(App\Payment::class)->make([
					'created_at' => $date,
					'updated_at' => $date,
					'limit_date' => $limit,
					'id_client' => $user->id_client
				]);
				$payment->save();

				$date = $limit;
        	}

        	$user->id_plan = $user->lastPayment()->id_plan;
        	$user->save();

        });
    }
}
