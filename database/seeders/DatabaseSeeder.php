<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cukup panggil RoleSeeder (karena user sudah dibuat di sana)
        $this->call(RoleSeeder::class);
    }
}