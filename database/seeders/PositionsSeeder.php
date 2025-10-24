<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('positions')->insert([
            ['nama_jabatan' => 'Manager',       'gaji_pokok' => 12000000, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Supervisor',    'gaji_pokok' => 9000000,  'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Staff',         'gaji_pokok' => 6000000,  'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Intern',        'gaji_pokok' => 3000000,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
