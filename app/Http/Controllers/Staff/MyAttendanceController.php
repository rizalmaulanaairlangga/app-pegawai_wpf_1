<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $employee = $user?->employee;

        if (!$employee) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Data karyawan tidak ditemukan.');
        }

        // --- 1) Tahun dan Bulan Dropdown ---
        $currentYear = Carbon::now()->year;
        $yearList = range($currentYear, $currentYear - 4); // 5 tahun terakhir

        $monthList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // --- 2) Ambil filter dari request ---
        $selectedMonth = $request->get('bulan', now()->month);
        $selectedYear = $request->get('tahun', now()->year);
        $search = $request->get('search');

        // --- 3) Query attendance berdasarkan bulan & tahun ---
        $query = Attendance::where('karyawan_id', $employee->id)
            ->whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->orderBy('tanggal', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                ->orWhere('tanggal', 'like', "%{$search}%");
            });
        }

        $attendances = $query->get();

        // --- 4) Tandai keterlambatan (>15 menit dari jam 07:00) ---
        foreach ($attendances as $absen) {
            if ($absen->status_absensi === 'hadir' && $absen->waktu_masuk) {
                $jamMasuk = Carbon::createFromFormat('H:i:s', $absen->waktu_masuk);
                $jamTepat = Carbon::createFromTime(8, 0, 0); // ubah jadi jam 8:00
                $terlambatMenit = $jamTepat->diffInMinutes($jamMasuk, false);

                if ($jamMasuk->greaterThan($jamTepat->addMinutes(15))) {
                    $absen->is_telat = true;
                    $absen->selisih_telat = $jamMasuk->diffInMinutes($jamTepat);
                } else {
                    $absen->is_telat = false;
                    $absen->selisih_telat = 0;
                }
            } else {
                $absen->is_telat = false;
                $absen->selisih_telat = 0;
            }
        }

        // --- 5) Hitung jumlah status ---
        $countHadir = $attendances->where('status_absensi', 'hadir')->count();
        $countIzin = $attendances->where('status_absensi', 'izin')->count();
        $countSakit = $attendances->where('status_absensi', 'sakit')->count();
        $countAlpha = $attendances->where('status_absensi', 'alpha')->count();
        $countTelat = $attendances->where('is_telat', true)->count();

        // --- 6) Attendance hari ini (optional tetap ditampilkan) ---
        $attendanceToday = Attendance::where('karyawan_id', $employee->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        return view('staff.myattendance.index', compact(
            'employee',
            'attendances',
            'attendanceToday',
            'countTelat',
            'countIzin',
            'countSakit',
            'countAlpha',
            'countHadir',
            'monthList',
            'yearList',
            'selectedMonth',
            'selectedYear',
            'search'
        ));
    }

    /**
     * Fungsi Check In
     */
    public function checkIn()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->route('myattendance.index')
                ->with('error', 'Data karyawan tidak ditemukan.');
        }

        // Cek apakah sudah check-in hari ini
        $today = Carbon::today();
        $attendance = Attendance::where('karyawan_id', $employee->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($attendance && $attendance->waktu_masuk) {
            return redirect()->route('myattendance.index')
                ->with('warning', 'Anda sudah melakukan Check In hari ini.');
        }

        // Buat record baru kalau belum ada
        Attendance::updateOrCreate(
            [
                'karyawan_id' => $employee->id,
                'tanggal' => $today,
            ],
            [
                'waktu_masuk' => now()->format('H:i:s'),
                'status_absensi' => 'hadir',
            ]
        );

        return redirect()->route('myattendance.index')->with('success', 'Check In berhasil!');
    }

    /**
     * Fungsi Check Out
     */
    public function checkout(Request $request)
    {
        $employee = Auth::user()->employee;
        $today = now()->toDateString();

        $attendance = Attendance::firstOrCreate(
            ['karyawan_id' => $employee->id, 'tanggal' => $today],
            ['status_absensi' => 'hadir', 'waktu_masuk' => now()]
        );

        // Setiap kali klik, update waktu_keluar ke waktu sekarang
        $attendance->update([
            'waktu_keluar' => now(),
        ]);

        return back()->with('success', 'Waktu keluar berhasil diperbarui: ' . now()->format('H:i:s'));
    }

    // ---------------------------------------
    // Fungsi lain diarahkan ke halaman index
    // ---------------------------------------

    public function create()
    {
        return redirect()->route('myattendance.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function store(Request $request)
    {
        return redirect()->route('myattendance.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function show($id)
    {
        return redirect()->route('myattendance.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function edit($id)
    {
        return redirect()->route('myattendance.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('myattendance.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function destroy($id)
    {
        return redirect()->route('myattendance.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }
}
