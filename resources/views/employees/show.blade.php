@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Data Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body class="poppins-regular">
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-2xl">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">Detail Pegawai</h1>

        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="w-full text-left border-collapse">
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-gray-700 font-semibold w-1/3">Nama Lengkap</th>
                        <td class="px-4 py-3">{{ $employee->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-gray-700 font-semibold">Email</th>
                        <td class="px-4 py-3">{{ $employee->email }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-gray-700 font-semibold">Nomor Telepon</th>
                        <td class="px-4 py-3">{{ $employee->nomor_telepon }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-gray-700 font-semibold">Tanggal Lahir</th>
                        <td class="px-4 py-3">{{ $employee->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-gray-700 font-semibold">Alamat</th>
                        <td class="px-4 py-3">{{ $employee->alamat }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-gray-700 font-semibold">Tanggal Masuk</th>
                        <td class="px-4 py-3">{{ $employee->tanggal_masuk }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-gray-700 font-semibold">Status</th>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                {{ strtolower($employee->status) === 'aktif' 
                                    ? 'bg-green-100 text-green-800' 
                                    : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('employees.index') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-300">
                Kembali
            </a>
        </div>
    </div>
</div>
</html>