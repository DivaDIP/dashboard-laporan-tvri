<?php

namespace Database\Seeders; // <--- WAJIB TAMBAHKAN BARIS INI

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Role
        $adminRole = Role::create(['name' => 'admin']);
        $userRole  = Role::create(['name' => 'user']);

        // Buat 1 Akun Admin Default
        $admin = User::create([
            'name' => 'Admin Teknisi',
            'email' => 'admin@tvri.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole($adminRole);

        // Buat 1 Akun User Default
        $user = User::create([
            'name' => 'Staf Teknisi',
            'email' => 'staf@tvri.com',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole($userRole);
    }
}