<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure admin user exists in users table with role 'admin' for standard web auth guard
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('Admin123$'),
                'email_verified_at' => now(),
            ]
        );

        // Also allow kelvo4799@gmail.com if customized
        User::updateOrCreate(
            ['email' => 'kelvo4799@gmail.com'],
            [
                'name' => 'Kelvin Aso',
                'username' => 'kelvinaso',
                'role' => 'admin',
                'password' => Hash::make('Admin123$'),
                'email_verified_at' => now(),
            ]
        );

        // Also maintain admins table entry for backwards compatibility or dedicated admin guard
        Admin::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
    }
}
