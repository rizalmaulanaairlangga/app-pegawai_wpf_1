<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use Carbon\Carbon;

class AttendancesSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'izin', 'izin', 'izin', 'izin', 'sakit', 'sakit', 'sakit', 'sakit', 'alpha'];
        $records = [];
        $today = Carbon::now();

        $employees = Employee::all();

        foreach ($employees as $employee) {

            // ==== BULAN INI ====
            $bulanIni = $today->copy()->startOfMonth();
            $tanggalListBulanIni = [];

            // buat daftar tanggal lengkap dalam bulan ini
            for ($d = 1; $d <= $today->daysInMonth; $d++) {
                $tanggalListBulanIni[] = $bulanIni->copy()->addDays($d - 1)->format('Y-m-d');
            }

            // acak urutan dan ambil 26 tanggal unik
            shuffle($tanggalListBulanIni);
            $tanggalListBulanIni = array_slice($tanggalListBulanIni, 0, 26);

            foreach ($tanggalListBulanIni as $tanggal) {
                $status = $statuses[array_rand($statuses)];

                if ($status === 'hadir') {
                    // --- JAM MASUK (07:00 - 09:00, tapi dominan sekitar 08:00) ---
                    $rand = rand(1, 100);

                    if ($rand <= 75) { 
                        // 75% kemungkinan antara 07:45 - 08:15
                        $hourMasuk = 8;
                        $minuteMasuk = rand(0, 15);
                    } elseif ($rand <= 90) { 
                        // 15% kemungkinan antara 07:00 - 07:44
                        $hourMasuk = 7;
                        $minuteMasuk = rand(0, 44);
                    } else {
                        // 10% kemungkinan antara 08:16 - 09:00 (telat)
                        $hourMasuk = 8;
                        $minuteMasuk = rand(16, 59);
                    }

                    $waktuMasuk = sprintf('%02d:%02d:00', $hourMasuk, $minuteMasuk);

                    // --- JAM KELUAR (16:00 - 17:30) ---
                    $hourKeluar = rand(16, 17);
                    $minuteKeluar = ($hourKeluar === 17) ? rand(0, 30) : rand(0, 59);
                    $waktuKeluar = sprintf('%02d:%02d:00', $hourKeluar, $minuteKeluar);
                } else {
                    $waktuMasuk = null;
                    $waktuKeluar = null;
                }

                $records[] = [
                    'karyawan_id'    => $employee->id,
                    'tanggal'        => $tanggal,
                    'status_absensi' => $status,
                    'waktu_masuk'    => $waktuMasuk,
                    'waktu_keluar'   => $waktuKeluar,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            // ==== BULAN SEBELUMNYA ====
            $bulanLalu = $today->copy()->subMonth()->startOfMonth();
            $tanggalListBulanLalu = [];

            for ($d = 1; $d <= $bulanLalu->daysInMonth; $d++) {
                $tanggalListBulanLalu[] = $bulanLalu->copy()->addDays($d - 1)->format('Y-m-d');
            }

            shuffle($tanggalListBulanLalu);
            $tanggalListBulanLalu = array_slice($tanggalListBulanLalu, 0, 26);

            foreach ($tanggalListBulanLalu as $tanggal) {
                $status = $statuses[array_rand($statuses)];

                if ($status === 'hadir') {
                    $hourMasuk = rand(7, 8);
                    $minuteMasuk = rand(0, 59);
                    $waktuMasuk = sprintf('%02d:%02d:00', $hourMasuk, $minuteMasuk);

                    $hourKeluar = rand(16, 17);
                    $minuteKeluar = ($hourKeluar === 17) ? rand(0, 30) : rand(0, 59);
                    $waktuKeluar = sprintf('%02d:%02d:00', $hourKeluar, $minuteKeluar);
                } else {
                    $waktuMasuk = null;
                    $waktuKeluar = null;
                }

                $records[] = [
                    'karyawan_id'    => $employee->id,
                    'tanggal'        => $tanggal,
                    'status_absensi' => $status,
                    'waktu_masuk'    => $waktuMasuk,
                    'waktu_keluar'   => $waktuKeluar,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }
        }

        // Insert semua data sekaligus (lebih cepat)
        DB::table('attendances')->insert($records);
    }
}
