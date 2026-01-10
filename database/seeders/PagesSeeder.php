<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pages')->insert([
            [
                'title' => 'Beranda',
                'slug' => 'beranda',
                'type' => 'pages',
                'content' => 'Ini halaman beranda',
                'active' => 1,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Profil',
                'slug' => 'profil',
                'type' => 'pages',
                'content' => 'Halaman profil',
                'active' => 1,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}