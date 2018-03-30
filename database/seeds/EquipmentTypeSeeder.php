<?php

use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EquipmentType::class, 15)->create()->each(function ($u) {
        	for ($i = 0 ; $i < 40 ; $i++) { 	
        		$u->equipment()->save(factory(App\Equipment::class)->make());
        	}
    	});
    }
}
