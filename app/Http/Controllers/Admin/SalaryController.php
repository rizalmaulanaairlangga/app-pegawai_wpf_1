<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Salary;
use App\Models\Employee;
use Carbon\Carbon;

class SalaryController extends Controller
{
public function index(Request $request)
{
    $departmentId = $request->get('department_id'); // bisa null (semua)
    $mode = $request->get('mode', 'month'); // 'month' or 'year'
    $month = (int)$request->get('bulan', now()->month);
    $year = (int)$request->get('year', now()->year);

    $yearList = range(now()->year - 3, now()->year + 1);

    // Ambil semua departemen (untuk populate select => selalu ada opsi semua)
    $allDepartments = Department::orderBy('nama_departemen')->get();

    // Dept yang akan diproses (jika ada filter department, ambil hanya itu, 
    // kalau tidak ambil semua departemen)
    $departments = Department::orderBy('nama_departemen')
                    ->when($departmentId, function($q) use ($departmentId) {
                        $q->where('id', $departmentId);
                    })->get();

    // Palet warna (cycle)
    $palet = [
        ['accent' => 'text-blue-700',   'soft'=>'bg-blue-100',    'stripe'=>'bg-blue-200'],
        ['accent' => 'text-green-700',  'soft'=>'bg-green-100',   'stripe'=>'bg-green-200'],
        ['accent' => 'text-yellow-700', 'soft'=>'bg-yellow-100',  'stripe'=>'bg-yellow-200'],
        ['accent' => 'text-purple-700', 'soft'=>'bg-purple-100',  'stripe'=>'bg-purple-200'],
    ];

    $summaries = [];

    foreach ($departments as $idx => $dept) {
        $color = $palet[$idx % count($palet)];

        // Ambil salary terkait departemen via relasi employee
        $salariesQuery = Salary::whereHas('employee', function($q) use ($dept) {
            $q->where('departemen_id', $dept->id);
        })->with(['employee.position'])->get();

        // Filter berdasarkan mode month/year
        if ($mode === 'month') {
            $periodPrefix = sprintf('%04d-%02d', $year, $month); // "2025-11"
            $salaries = $salariesQuery->filter(fn($s) => Str::startsWith($s->bulan, $periodPrefix));
            $titlePeriod = Carbon::createFromFormat('Y-m', $periodPrefix)->translatedFormat('F Y');
        } else {
            // tahun penuh
            $salaries = $salariesQuery->filter(fn($s) => Str::startsWith($s->bulan, (string)$year . '-'));
            $titlePeriod = (string)$year;
        }

        $totalGaji = $salaries->sum('total_gaji');
        $employeeCount = Employee::where('departemen_id', $dept->id)->count();

        $summaries[] = [
            'department' => $dept,
            'employee_count' => $employeeCount,
            'total_gaji' => $totalGaji,
            'salaries' => $salaries,
            'color' => $color,
        ];
    }

    // kirim semuaDepartements untuk select agar opsi selalu lengkap
    return view('admin.salaries.index', compact(
        'allDepartments', 'departments', 'summaries', 'yearList', 'titlePeriod', 'month', 'year', 'mode', 'departmentId'
    ));
}

    public function create()
    {
        $employees = Employee::all();
        return view('admin.salaries.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:10',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
            'total_gaji' => 'required|numeric|min:0',
        ]);

        Salary::create($request->all());
        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil ditambahkan.');
    }

    public function show($id)
    {
        $salary = Salary::with('employee')->findOrFail($id);
        return view('admin.salaries.show', compact('salary'));
    }

    public function edit($id)
    {
        $salary = Salary::findOrFail($id);
        $employees = Employee::all();
        return view('admin.salaries.edit', compact('salary', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:10',
            'gaji_pokok' => 'required',
            'tunjangan' => 'required',
            'potongan' => 'required',
        ]);

        // Hilangkan titik dari input agar bisa disimpan sebagai angka
        $data = $request->all();
        $data['gaji_pokok'] = str_replace('.', '', $request->gaji_pokok);
        $data['tunjangan'] = str_replace('.', '', $request->tunjangan);
        $data['potongan'] = str_replace('.', '', $request->potongan);

        // Hitung total gaji
        $data['total_gaji'] = ($data['gaji_pokok'] + $data['tunjangan']) - $data['potongan'];

        $salary = Salary::findOrFail($id);
        $salary->update($data);

        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Salary::findOrFail($id)->delete();
        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil dihapus.');
    }
}
