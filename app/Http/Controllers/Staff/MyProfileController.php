<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class MyProfileController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Data profil tidak ditemukan.');
        }

        return view('staff.myprofile.index', compact('employee'));
    }

    public function create()
    {
        return redirect()->route('myprofile.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function store(Request $request)
    {
        return redirect()->route('myprofile.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function show($id)
    {
        // pastikan user hanya bisa lihat profil dirinya sendiri
        $employee = Auth::user()->employee;

        if (!$employee || $employee->id != $id) {
            return redirect()->route('myprofile.index')
                ->with('error', 'Anda tidak memiliki akses ke profil ini.');
        }

        return view('staff.myprofile.index', compact('employee'));
    }

    public function edit($id)
    {
        return redirect()->route('myprofile.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('myprofile.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }

    public function destroy($id)
    {
        return redirect()->route('myprofile.index')
            ->with('warning', 'Akses tidak diizinkan.');
    }
}
