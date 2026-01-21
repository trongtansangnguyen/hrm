<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'IT',
                'description' => 'Phòng Công nghệ thông tin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sale',
                'description' => 'Phòng Kinh doanh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marketing',
                'description' => 'Phòng Marketing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HR',
                'description' => 'Phòng Nhân sự',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('departments')->insert($departments);
    }
}
