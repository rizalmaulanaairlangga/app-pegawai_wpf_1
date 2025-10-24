<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // tampilkan semua data
    public function index()
    {
        $departments = Department::orderBy('id')->get();
        return view('departments.index', compact('departments'));
    }

    // tampilkan form tambah data
    public function create()
    {
        return view('departments.create');
    }

    // simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        Department::create($request->all());
        return redirect()->route('departments.index')->with('success', 'Department berhasil ditambahkan.');
    }

    // tampilkan detail data
    public function show($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.show', compact('department'));
    }

    // tampilkan form edit
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    // update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());
        return redirect()->route('departments.index')->with('success', 'Department berhasil diperbarui.');
    }

    // hapus data
    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return redirect()->route('departments.index')->with('success', 'Department berhasil dihapus.');
    }
}
