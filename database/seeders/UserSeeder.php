<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin user
        User::create([
            'email' => 'admin@hrm.local',
            'password' => Hash::make('password123'),
            'role' => UserRole::ADMIN->value,
            'status' => UserStatus::ACTIVE->value,
            'email_verified_at' => now(),
        ]);

        // Create Manager user
        User::create([
            'email' => 'manager@hrm.local',
            'password' => Hash::make('password123'),
            'role' => UserRole::MANAGER->value,
            'status' => UserStatus::ACTIVE->value,
            'email_verified_at' => now(),
        ]);

        // Create Employee user
        User::create([
            'email' => 'employee@hrm.local',
            'password' => Hash::make('password123'),
            'role' => UserRole::EMPLOYEE->value,
            'status' => UserStatus::ACTIVE->value,
            'email_verified_at' => now(),
        ]);
    }
}
