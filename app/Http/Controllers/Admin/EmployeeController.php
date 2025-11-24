<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['department', 'position'])
                        ->orderBy('id') 
                        ->paginate(5);
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();

        return view('admin.employees.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'nomor_telepon' => 'required|string|max:20',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required|string|max:255',
        'tanggal_masuk' => 'required|date',
        'departemen_id' => 'nullable|exists:departments,id',
        'jabatan_id'    => 'nullable|exists:positions,id',
        'status' => 'required|string|max:50',
        'role' => 'required|in:admin,staff',
        ]);

        // 1) buat employee
        $employee = Employee::create($request->only([
            'nama_lengkap', 'email', 'nomor_telepon',
            'tanggal_lahir', 'alamat', 'tanggal_masuk',
            'departemen_id','jabatan_id','status'
        ]));

        // 2) buat user minimal: nama, email, role, username = null, password random (tidak diketahui)
        $tempPassword = Str::random(12);
        $user = User::create([
            'name' => $employee->nama_lengkap,
            'username' => null,
            'email' => $employee->email,
            'password' => null, // BELUM DISET — menunggu user daftar
            'role' => $request->input('role', 'staff'),
        ]);

        // 3) hubungkan employee -> user
        $employee->update(['user_id' => $user->id]);

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil ditambahkan. User awal dibuat (user harus mendaftar untuk men-set username & password).');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::with(['department', 'position'])->findOrFail($id);
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $positions = Position::all();
        
        return view('admin.employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email,' . $id,
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|exists:departments,id', // TAMBAHKAN
            'jabatan_id' => 'required|exists:positions,id',     // TAMBAHKAN
            'status' => 'required|string|max:50',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all()); // GUNAKAN $request->all() BUKAN $request->only()

        return redirect()->route('employees.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        
        // optional: deactivate user instead of deleting
        if ($employee->user) {
            $employee->user->update(['is_active' => false]); // atau hapus
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee berhasil dihapus dan akun dinonaktifkan.');
    }

}