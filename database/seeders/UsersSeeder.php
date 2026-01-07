<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'ana',
            'username' => 'ana',
            'password' => Hash::make('1234'),
            'role' => 'admin',
            'foto' => '',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
