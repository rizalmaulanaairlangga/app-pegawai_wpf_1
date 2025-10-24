<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendancesSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit', 'alpha'];
        $records = [];

        for ($i = 1; $i <= 16; $i++) {
            $status = $statuses[array_rand($statuses)];

            // Random tanggal antara 1–10 Oktober 2025
            $tanggal = '2025-10-' . str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT);

            if ($status === 'hadir') {
                // waktu masuk antara 07:00 dan 08:00
                $hourMasuk = rand(7, 8);
                $minuteMasuk = rand(0, 59);
                $waktuMasuk = sprintf('%02d:%02d:00', $hourMasuk, $minuteMasuk);

                // waktu keluar antara 16:00 dan 17:30
                $hourKeluar = rand(16, 17);
                $minuteKeluar = ($hourKeluar === 17) ? rand(0, 30) : rand(0, 59);
                $waktuKeluar = sprintf('%02d:%02d:00', $hourKeluar, $minuteKeluar);
            } else {
                $waktuMasuk = null;
                $waktuKeluar = null;
            }

            $records[] = [
                'karyawan_id'    => $i,
                'tanggal'        => $tanggal,
                'status_absensi' => $status,
                'waktu_masuk'    => $waktuMasuk,
                'waktu_keluar'   => $waktuKeluar,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        DB::table('attendances')->insert($records);
    }
}
