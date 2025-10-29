<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        // Get current week dates (Monday to Saturday)
        $startOfWeek = now()->startOfWeek(); // Monday
        $endOfWeek = now()->endOfWeek()->subDay(); // Saturday (minus Sunday)
        
        $employees = Employee::with([
            'department',
            'attendances' => function($query) use ($startOfWeek, $endOfWeek) {
                return $query->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
                            ->orderBy('tanggal', 'asc');
            }
        ])->orderBy('departemen_id')->get();

        $departments = Department::orderBy('nama_departemen')->get();
        
        // Week days for display (Monday to Saturday)
        $weekDays = [];
        for ($i = 0; $i < 6; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $weekDays[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => $date->locale('id')->translatedFormat('l'), // Senin, Selasa, etc.
                'short_day' => $date->locale('id')->translatedFormat('D') // Sen, Sel, etc.
            ];
        }

        return view('attendances.index', compact(
            'employees', 
            'departments', 
            'weekDays',
            'startOfWeek',
            'endOfWeek'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i',
            'status_absensi' => 'required|in:hadir,izin,sakit',
        ]);

        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');

        // Check if attendance already exists for this employee and date
        $existingAttendance = Attendance::where('karyawan_id', $request->karyawan_id)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($existingAttendance) {
            // Update existing attendance
            if ($request->status_absensi === 'hadir' && $request->waktu_masuk) {
                $existingAttendance->waktu_masuk = $request->waktu_masuk;
            }
            
            if ($request->waktu_keluar) {
                $existingAttendance->waktu_keluar = $request->waktu_keluar;
            }
            
            $existingAttendance->status_absensi = $request->status_absensi;
            $existingAttendance->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil diperbarui.',
                'data' => $existingAttendance
            ]);
        } else {
            // Create new attendance
            $attendanceData = [
                'karyawan_id' => $request->karyawan_id,
                'tanggal' => $request->tanggal,
                'status_absensi' => $request->status_absensi,
            ];

            if ($request->status_absensi === 'hadir' && $request->waktu_masuk) {
                $attendanceData['waktu_masuk'] = $request->waktu_masuk;
            }

            if ($request->waktu_keluar) {
                $attendanceData['waktu_keluar'] = $request->waktu_keluar;
            }

            $attendance = Attendance::create($attendanceData);
            
            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil ditambahkan.',
                'data' => $attendance
            ]);
        }
    }

    public function destroyToday($employeeId)
    {
        $today = now()->format('Y-m-d');
        
        $attendance = Attendance::where('karyawan_id', $employeeId)
            ->where('tanggal', $today)
            ->first();

        if ($attendance) {
            $attendance->delete();
            return response()->json([
                'success' => true,
                'message' => 'Absensi hari ini berhasil dihapus.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada absensi untuk dihapus.'
        ], 404);
    }

    // Keep other methods the same...
    public function create()
    {
        $employees = Employee::all();
        return view('attendances.create', compact('employees'));
    }

    public function show($id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);
        return view('attendances.show', compact('attendance'));
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        return view('attendances.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());
        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil dihapus.');
    }

}