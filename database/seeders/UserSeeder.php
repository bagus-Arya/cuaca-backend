<?php

namespace Database\Seeders;

use \Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * 
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@2024'),
        ]);
        
        //$data = [
        //    'name' => 'admin',
        //    'email' => 'admin@mail.com',
        //    'password' => Hash::make('Admin@2024')
        //];

        //Users:create($data);
    }
}
