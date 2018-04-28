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
        $this->call(EquipmentTypeSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(TicketSeeder::class);
    }
}
