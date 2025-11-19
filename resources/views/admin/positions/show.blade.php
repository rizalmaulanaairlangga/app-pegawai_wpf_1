@extends('layouts.app')
@section('title', 'Detail Jabatan - ' . $position->nama_jabatan)

@section('content')

<div class="poppins-regular h-full w-full flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
        {{-- Tombol Kembali --}}
        <x-action-buttons type="back" />

        {{-- Judul Halaman --}}
        <h2 class="text-2xl font-bold mb-6 text-blue-700">Detail Jabatan</h2>

        {{-- Tabel Detail Jabatan --}}
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <tbody class="divide-y divide-gray-100">
                <tr>
                    <th class="bg-gray-100 px-4 py-2 text-left w-1/3">ID</th>
                    <td class="px-4 py-2">{{ $position->id }}</td>
                </tr>
                <tr>
                    <th class="bg-gray-100 px-4 py-2 text-left">Nama Jabatan</th>
                    <td class="px-4 py-2">{{ $position->nama_jabatan }}</td>
                </tr>
                <tr>
                    <th class="bg-gray-100 px-4 py-2 text-left">Gaji Pokok</th>
                    <td class="px-4 py-2">Rp {{ number_format($position->gaji_pokok, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex justify-end space-x-3">
            {{-- Tombol Edit --}}
            <x-action-buttons type="edit" :routePrefix="'positions'" :id="$position->id" />

            {{-- Tombol Delete --}}
            <x-action-buttons 
            type="delete" 
            :routePrefix="'positions'" :id="$position->id" 
            confirmMessage="Yakin ingin menghapus data Jabatan ini?" />
        </div>
    </div>
</div>

@endsection
