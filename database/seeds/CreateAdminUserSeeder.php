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
        $adminExists = DB::table('employees')->where('email','=','admin@worknshare.fr')->exists();

        if(!$adminExists)
        {
        	DB::table('employees')->insert([
        		'name' => 'Admin',
        		'surname' => 'Admin',
        		'email' => 'admin@worknshare.fr',
        		'password' => bcrypt('admin'),
        		'address' => 'address',
        		'role' => 1,
                'changed_password' => 1
        	]);
        	$this->command->info('Admin user created!');
        } 
        else $this->command->info('Admin user already exists.');
        
    }
}
