<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MySalaryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $employee = $user?->employee;

        if (!$employee) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Data karyawan tidak ditemukan.');
        }

        // Filter tahun (default = tahun ini)
        $selectedYear = $request->get('tahun', Carbon::now()->year);
        $yearList = range(Carbon::now()->year - 2, Carbon::now()->year); // contoh 3 tahun terakhir

        // Ambil data gaji
        $salaries = Salary::where('karyawan_id', $employee->id)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.mysalaries.index', compact(
            'employee',
            'salaries',
            'selectedYear',
            'yearList'
        ));
    }
}
