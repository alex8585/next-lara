<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
          'name' => 'alex85',
          'email' => 'blyakher85@gmail.com',
          'password' => Hash::make('password'),
          'role' => 'admin',
        ]);
    }
}
