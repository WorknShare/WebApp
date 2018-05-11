<?php

use Illuminate\Database\Seeder;

class OrderMealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ReserveMeal::class, 500)->create();

    }
}
