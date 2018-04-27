<?php

use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Site::class, 10)->create()->each(function ($site) {

            //Schedules
        	for ($i = 0 ; $i < 7 ; $i++) { 	
        		$site->schedules()->save(factory(App\Schedule::class)->make([
				    'day' => $i,
				]));
        	}

            //Rooms
            for ($i = 0 ; $i < 15 ; $i++) {  
                $site->rooms()->save(factory(App\Room::class)->make());
            }
    	});
    }
}
