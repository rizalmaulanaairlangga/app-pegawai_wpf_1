@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body class="poppins-regular bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">Form Pegawai</h1>

        <form action="{{ route('employees.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" id="nomor_telepon" name="nomor_telepon" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" 
                          class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Tanggal Masuk -->
            <div>
                <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</body>
</html>
