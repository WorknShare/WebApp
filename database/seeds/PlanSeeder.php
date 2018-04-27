<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PlanAdvantage::class, 10)->create();

        factory(App\Plan::class, 3)->create();

        $advantages = App\PlanAdvantage::all();
        $max = App\Plan::max('price');

        App\Plan::all()->each(function ($plan) use ($advantages, $max) { 
		    $plan->advantages()->attach(
		        $advantages->random($plan->price / $max * 10)->pluck('id_plan_advantage')->toArray()
		    ); 
		});
    }
}
