@extends('layouts.app')
@section('title', 'Edit Absensi - ' . $attendance->employee->nama_lengkap)

@section('content')

<div class="font-[Poppins] bg-gray-50 flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
        <x-action-buttons type="back" />

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Data Absensi</h2>

        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Pegawai -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Pegawai</label>
                <select name="karyawan_id" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" 
                            {{ old('karyawan_id', $attendance->karyawan_id) == $employee->id ? 'selected' : '' }}>
                            {{ $employee->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $attendance->tanggal) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Waktu Masuk -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Waktu Masuk</label>
                <input type="time" name="waktu_masuk" value="{{ old('waktu_masuk', $attendance->waktu_masuk) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Waktu Keluar -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Waktu Keluar</label>
                <input type="time" name="waktu_keluar" value="{{ old('waktu_keluar', $attendance->waktu_keluar) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Status Absensi -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Status Absensi</label>
                <select name="status_absensi"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="hadir" {{ old('status_absensi', $attendance->status_absensi) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ old('status_absensi', $attendance->status_absensi) == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status_absensi', $attendance->status_absensi) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="alpha" {{ old('status_absensi', $attendance->status_absensi) == 'alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
