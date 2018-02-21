<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('employees')->insert([
    		'name' => 'Admin',
    		'surname' => 'Admin',
    		'email' => 'admin@worknshare.fr',
    		'password' => bcrypt('admin'),
    		'address' => 'address',
    		'role' => 1
    	]);
    	$this->command->info('Admin user created!');
    }
}
