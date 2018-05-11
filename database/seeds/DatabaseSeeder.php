<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateAdminUserSeeder::class);
        $this->call(RoomTypeSeeder::class);
        $this->call(SiteSeeder::class);
        $this->call(EquipmentTypeSeeder::class);
        $this->call(MealSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ReserveRoomSeeder::class);
        $this->call(OrderMealSeeder::class);
    }
}
