@extends('layouts.app')
@section('title', 'Tambah Data Absensi')

@section('content')

<div class="font-[Poppins] bg-gray-50 h-full w-full flex items-center items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-4xl">
        <x-action-buttons type="back" />
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">Form Absensi Karyawan</h1>

        <form action="{{ route('attendances.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Karyawan -->
            <div class="md:col-span-2">
                <label for="karyawan_id" class="block text-sm font-medium text-gray-700">Karyawan</label>
                <select id="karyawan_id" name="karyawan_id" 
                        class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" 
                       class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Waktu Masuk -->
            <div>
                <label for="waktu_masuk" class="block text-sm font-medium text-gray-700">Waktu Masuk</label>
                <input type="time" id="waktu_masuk" name="waktu_masuk" 
                       class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Waktu Keluar -->
            <div>
                <label for="waktu_keluar" class="block text-sm font-medium text-gray-700">Waktu Keluar</label>
                <input type="time" id="waktu_keluar" name="waktu_keluar" 
                       class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status Absensi -->
            <div>
                <label for="status_absensi" class="block text-sm font-medium text-gray-700">Status Absensi</label>
                <select id="status_absensi" name="status_absensi" 
                        class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>

            <!-- Tombol Simpan -->
            <div class="md:col-span-2 flex justify-end pt-4">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
