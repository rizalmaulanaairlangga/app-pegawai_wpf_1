<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalariesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('salaries')->truncate(); // bersihkan data lama

        $now = Carbon::now();
        $currentYear = $now->year;
        $lastYear = $currentYear - 1;

        // Ambil semua bulan dari Jan tahun lalu sampai bulan lalu tahun ini
        $months = [];

        // Tahun lalu (12 bulan)
        for ($m = 1; $m <= 12; $m++) {
            $months[] = sprintf('%d-%02d', $lastYear, $m);
        }

        // Tahun ini (sampai bulan lalu)
        for ($m = 1; $m < $now->month; $m++) {
            $months[] = sprintf('%d-%02d', $currentYear, $m);
        }

        $data = [];

        // 16 karyawan
        for ($employeeId = 1; $employeeId <= 16; $employeeId++) {
            // Tentukan gaji dasar berbeda-beda per karyawan
            $baseSalary = rand(5, 12) * 1000000; // 5–12 juta
            $allowanceBase = rand(300000, 1000000);
            $deductionBase = rand(100000, 400000);

            foreach ($months as $month) {
                $gajiPokok = $baseSalary;
                $tunjangan = $allowanceBase + rand(-100000, 100000);
                $potongan = $deductionBase + rand(-50000, 50000);
                $total = $gajiPokok + $tunjangan - $potongan;

                $data[] = [
                    'karyawan_id' => $employeeId,
                    'bulan'       => $month,
                    'gaji_pokok'  => $gajiPokok,
                    'tunjangan'   => $tunjangan,
                    'potongan'    => $potongan,
                    'total_gaji'  => $total,
                    'created_at'  => Carbon::createFromFormat('Y-m', $month)->endOfMonth(),
                    'updated_at'  => now(),
                ];
            }
        }

        DB::table('salaries')->insert($data);
    }
}
