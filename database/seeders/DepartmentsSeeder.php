<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            ['nama_departemen' => 'Human Resource', 'created_at' => now(), 'updated_at' => now()],
            ['nama_departemen' => 'Finance',        'created_at' => now(), 'updated_at' => now()],
            ['nama_departemen' => 'IT',             'created_at' => now(), 'updated_at' => now()],
            ['nama_departemen' => 'Marketing',      'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
