<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalariesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('salaries')->insert([
            [
                'karyawan_id' => 1,
                'bulan'       => '2025-09',
                'gaji_pokok'  => 6000000,
                'tunjangan'   => 500000,
                'potongan'    => 200000,
                'total_gaji'  => 6300000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'karyawan_id' => 2,
                'bulan'       => '2025-09',
                'gaji_pokok'  => 9000000,
                'tunjangan'   => 700000,
                'potongan'    => 300000,
                'total_gaji'  => 9400000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'karyawan_id' => 3,
                'bulan'       => '2025-09',
                'gaji_pokok'  => 12000000,
                'tunjangan'   => 1500000,
                'potongan'    => 500000,
                'total_gaji'  => 13000000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
