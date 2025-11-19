<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', now()->month);
        $selectedYear = $request->get('year', now()->year);
        $daysInMonth = \Carbon\Carbon::create($selectedYear, $selectedMonth)->daysInMonth;

        $employees = \App\Models\Employee::all();
        $attendances = \App\Models\Attendance::whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->get();

        $yearList = range(now()->year - 2, now()->year + 1);

        return view('admin.attendances.index', compact(
            'employees', 'attendances', 'selectedMonth', 'selectedYear', 'daysInMonth', 'yearList'
        ));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('admin.attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        Attendance::create($request->all());
        return redirect()->route('admin.attendances.index')->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);
        return view('admin.attendances.show', compact('attendance'));
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        return view('admin.attendances.edit', compact('attendance', 'employees'));
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
        return redirect()->route('admin.attendances.index')->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect()->route('admin.attendances.index')->with('success', 'Absensi berhasil dihapus.');
    }

}
