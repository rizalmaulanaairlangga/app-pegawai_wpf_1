@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-[Poppins] bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Data Pegawai</h2>

        <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $employee->nama_lengkap) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $employee->email) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $employee->nomor_telepon) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $employee->tanggal_lahir) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Alamat -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $employee->alamat) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Tanggal Masuk -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $employee->tanggal_masuk) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Status -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Status</label>
                <select name="status"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="aktif" {{ strtolower(old('status', $employee->status)) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ strtolower(old('status', $employee->status)) == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
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

</body>
</html>
