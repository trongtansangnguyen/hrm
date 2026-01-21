<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            // IT Positions
            [
                'name' => 'Intern Developer',
                'description' => 'Thực tập sinh phát triển phần mềm',
                'level' => 1,
                'base_salary' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Junior Developer',
                'description' => 'Lập trình viên mới',
                'level' => 2,
                'base_salary' => 10000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Senior Developer',
                'description' => 'Lập trình viên cao cấp',
                'level' => 3,
                'base_salary' => 25000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tech Lead',
                'description' => 'Trưởng nhóm kỹ thuật',
                'level' => 4,
                'base_salary' => 40000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Sales Positions
            [
                'name' => 'Sales Executive',
                'description' => 'Nhân viên kinh doanh',
                'level' => 2,
                'base_salary' => 8000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sales Manager',
                'description' => 'Quản lý kinh doanh',
                'level' => 4,
                'base_salary' => 30000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Marketing Positions
            [
                'name' => 'Marketing Executive',
                'description' => 'Nhân viên Marketing',
                'level' => 2,
                'base_salary' => 9000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marketing Manager',
                'description' => 'Quản lý Marketing',
                'level' => 4,
                'base_salary' => 28000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // HR Positions
            [
                'name' => 'HR Executive',
                'description' => 'Nhân viên nhân sự',
                'level' => 2,
                'base_salary' => 10000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HR Manager',
                'description' => 'Quản lý nhân sự',
                'level' => 4,
                'base_salary' => 30000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('positions')->insert($positions);
    }
}
