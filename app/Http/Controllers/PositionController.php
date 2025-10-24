<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::orderBy('id')->get();
        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:positions,nama_jabatan',
            'gaji_pokok'   => 'required|numeric|min:0',
        ], [
            'nama_jabatan.required' => 'Nama jabatan wajib diisi.',
            'nama_jabatan.unique'   => 'Jabatan ini sudah ada dalam daftar.',
            'gaji_pokok.required'   => 'Gaji pokok wajib diisi.',
            'gaji_pokok.numeric'    => 'Gaji pokok harus berupa angka.',
        ]);

        Position::create($request->all());
        return redirect()->route('positions.index')->with('success', 'Posisi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $position = Position::findOrFail($id);
        return view('positions.show', compact('position'));
    }

    public function edit($id)
    {
        $position = Position::findOrFail($id);
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:positions,nama_jabatan,' . $id,
            'gaji_pokok'   => 'required|numeric|min:0',
        ]);

        $position = Position::findOrFail($id);
        $position->update($request->all());
        return redirect()->route('positions.index')->with('success', 'Posisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Position::findOrFail($id)->delete();
        return redirect()->route('positions.index')->with('success', 'Posisi berhasil dihapus.');
    }
}
