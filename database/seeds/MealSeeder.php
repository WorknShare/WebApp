<?php

use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Meal::class, 40)->create();

        $meals = App\Meal::all();
        App\Site::all()->each(function ($site) use ($meals) { 
		    $site->meals()->attach(
		        $meals->random(rand(1, 10))->pluck('id_meal')->toArray()
		    ); 
		});
    }
}
