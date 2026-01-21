<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi các seeder khác
        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
            UserSeeder::class,
        ]);
    }
        
}
