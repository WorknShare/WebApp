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
        factory(App\ReserveRoom::class, 500)->create()->each(function($reserve) use ($faker) {
            $site = \App\Room::where('id_room', $reserve->id_room)->first()->site()->first()->id_site;
            $count = \App\Equipment::where('id_site', $site)->count();
            $equipments = \App\Equipment::where('id_site', $site)->get();



            $reserve->equipments()->attach(
    		        $equipments->random(rand(0, 5))->pluck('id_equipment')->toArray()
    		    );

        });
    }
}
