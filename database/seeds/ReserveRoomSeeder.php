<?php

use Illuminate\Database\Seeder;

class ReserveRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        factory(App\ReserveRoom::class, 10)->create()->each(function($reserve) use ($faker) {
            $equipments = \App\Equipment::where('id_site', $reserve->id_site)->get();

            $reserve->equipments()->attach(
    		        $equipments->random($faker->numberBetween(0, $equipments->count()))->pluck('id_equipment')->toArray()
    		    );

        });
    }
}
