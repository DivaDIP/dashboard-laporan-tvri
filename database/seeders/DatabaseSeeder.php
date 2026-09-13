<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jalankan RoleSeeder terlebih dahulu
        $this->call(RoleSeeder::class);

        // Buat User Admin
        $admin = User::create([
            'name' => 'Admin Teknisi',
            'email' => 'admin@tvri.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        // Buat User Staf
        $staf = User::create([
            'name' => 'Staf Teknisi',
            'email' => 'staf@tvri.com',
            'password' => Hash::make('password123'),
        ]);
        $staf->assignRole('user'); // atau 'staf' sesuai nama role di RoleSeeder kamu
    }
}