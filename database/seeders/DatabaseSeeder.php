<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DepartmentsSeeder::class,
            PositionsSeeder::class,
            EmployeesSeeder::class,
            AttendancesSeeder::class,
            SalariesSeeder::class,
        ]);
    }
}
