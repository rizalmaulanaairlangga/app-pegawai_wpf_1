<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with(['employee'])
                      ->orderBy('id') 
                      ->paginate(5);
        return view('salaries.index', compact('salaries'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('salaries.create', compact('employees'));
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
        return view('salaries.show', compact('salary'));
    }

    public function edit($id)
    {
        $salary = Salary::findOrFail($id);
        $employees = Employee::all();
        return view('salaries.edit', compact('salary', 'employees'));
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
