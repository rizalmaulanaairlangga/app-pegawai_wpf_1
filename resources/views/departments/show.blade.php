@extends('layouts.app')
@section('title', 'Detail Departemen - ' . $department->nama_departemen)

@section('content')

<div class="poppins-regular h-full w-full flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
        <x-action-buttons type="back" />
    
        <h2 class="text-2xl font-bold mb-6 text-blue-700">Detail Karyawan</h2>
    
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <tbody class="divide-y divide-gray-100">
            <tr>
                <th class="bg-gray-100 px-4 py-2 text-left w-1/3">ID</th>
                <td class="px-4 py-2">{{ $department->id }}</td>
            </tr>
            <tr>
                <th class="bg-gray-100 px-4 py-2 text-left">Nama Lengkap</th>
                <td class="px-4 py-2">{{ $department->nama_departemen }}</td>
            </tr>
            </tbody>
        </table>
    
        <div class="mt-6 flex justify-end space-x-3">
            {{-- Tombol Edit --}}
            <x-action-buttons type="edit" :routePrefix="'departments'" :id="$department->id" />

            {{-- Tombol Delete --}}
            <x-action-buttons 
            type="delete" 
            :routePrefix="'departments'" :id="$department->id" 
            confirmMessage="Yakin ingin menghapus data Departemen ini?" />
        </div>
    </div>
</div>

@endsection
