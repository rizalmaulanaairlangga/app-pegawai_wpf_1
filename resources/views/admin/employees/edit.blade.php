@extends('layouts.app')
@section('title', 'Edit Pegawai - ' . $employee->nama_lengkap)

@section('content')

<div class="poppins-regular bg-gray-100 flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-6xl">
        <x-action-buttons type="back" />
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">Edit Data Pegawai</h1>

        <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap"
                    value="{{ old('nama_lengkap', $employee->nama_lengkap) }}"
                    class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 
                           focus:ring-blue-500 focus:border-blue-500">
                @error('nama_lengkap')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', $employee->email) }}"
                    class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 
                           focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" id="nomor_telepon" name="nomor_telepon"
                    value="{{ old('nomor_telepon', $employee->nomor_telepon) }}"
                    class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 
                           focus:ring-blue-500 focus:border-blue-500">
                @error('nomor_telepon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $employee->tanggal_lahir) }}"
                    class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 
                           focus:ring-blue-500 focus:border-blue-500">
                @error('tanggal_lahir')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"
                    class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 
                           focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $employee->alamat) }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Masuk -->
            <div>
                <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                    value="{{ old('tanggal_masuk', $employee->tanggal_masuk) }}"
                    class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 
                           focus:ring-blue-500 focus:border-blue-500">
                @error('tanggal_masuk')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Departemen -->
            <div>
                <label for="departemen_id" class="block text-sm font-medium text-gray-700">Departemen</label>
                <select id="departemen_id" name="departemen_id"
                        class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Departemen --</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" 
                            {{ old('departemen_id', $employee->departemen_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->nama_departemen }}
                        </option>
                    @endforeach
                </select>
                @error('departemen_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jabatan -->
            <div>
                <label for="jabatan_id" class="block text-sm font-medium text-gray-700">Jabatan</label>
                <select id="jabatan_id" name="jabatan_id"
                        class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach ($positions as $pos)
                        <option value="{{ $pos->id }}"
                            {{ old('jabatan_id', $employee->jabatan_id) == $pos->id ? 'selected' : '' }}>
                            {{ $pos->nama_jabatan }}
                        </option>
                    @endforeach
                </select>
                @error('jabatan_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                    class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 
                        focus:ring-blue-500 focus:border-blue-500">
                    @php
                        $currentStatus = old('status', $employee->status);
                    @endphp
                    <option value="Aktif" 
                        {{ $currentStatus == 'Aktif' || strtolower($currentStatus) == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="Nonaktif" 
                        {{ $currentStatus == 'Nonaktif' || strtolower($currentStatus) == 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Update -->
            <div class="md:col-span-2 flex justify-end pt-4">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-300">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection