<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = $user->employee;

        // --- Attendance hari ini ---
        $attendanceToday = Attendance::where('karyawan_id', $employee->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        // --- Attendance minggu ini ---
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $weeklyAttendance = Attendance::where('karyawan_id', $employee->id)
            ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->orderBy('tanggal', 'asc')
            ->get();

        // Hitung keterlambatan (bisa pakai logika yang sama seperti sebelumnya)
        foreach ($weeklyAttendance as $absen) {
            if ($absen->status_absensi === 'hadir' && $absen->waktu_masuk) {
                $jamMasuk = Carbon::createFromFormat('H:i:s', $absen->waktu_masuk);
                $jamTepat = Carbon::createFromTime(7, 0, 0);
                $terlambatMenit = $jamMasuk->diffInMinutes($jamTepat, false);
                $absen->is_telat = $terlambatMenit > 15;
            } else {
                $absen->is_telat = false;
            }
        }

        // --- Gaji 3 bulan terakhir ---
        $recentSalaries = Salary::where('karyawan_id', $employee->id)
            ->orderBy('bulan', 'desc')
            ->take(3)
            ->get();

        return view('staff.dashboard', compact(
            'attendanceToday',
            'weeklyAttendance',
            'recentSalaries'
        ));
    }
}
