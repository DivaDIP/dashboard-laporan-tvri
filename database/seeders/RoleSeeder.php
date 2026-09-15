<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat atau Ambil Role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        // Buat atau Update Akun Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@tvri.com'],
            [
                'name' => 'Admin Teknisi',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole($adminRole);

        // Buat atau Update Akun Staf
        $staf = User::updateOrCreate(
            ['email' => 'staf@tvri.com'],
            [
                'name' => 'Staf Teknisi',
                'password' => Hash::make('password123'),
            ]
        );
        $staf->assignRole($userRole);
    }
}