@extends('layouts.app')
@section('title', 'Detail Gaji - ' . $salary->id)

@section('content')
<div class="font-[Poppins] bg-gray-50 h-full w-full flex items-center items-center justify-center">
  <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
    <x-action-buttons type="back" />

    <h2 class="text-2xl font-bold mb-6 text-blue-700">Detail Gaji Karyawan</h2>

    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
      <tbody class="divide-y divide-gray-100">
        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left w-1/3">ID</th>
          <td class="px-4 py-2">{{ $salary->id }}</td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Nama Karyawan</th>
          <td class="px-4 py-2">
            <a href="{{ route('employees.show', $salary->employee->id) }}" 
              class="text-blue-600 hover:underline">
              {{ $salary->employee->nama_lengkap }}
            </a>
          </td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Bulan</th>
          <td class="px-4 py-2">{{ $salary->bulan }}</td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Gaji Pokok</th>
          <td class="px-4 py-2">Rp{{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Tunjangan</th>
          <td class="px-4 py-2">Rp{{ number_format($salary->tunjangan, 0, ',', '.') }}</td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Potongan</th>
          <td class="px-4 py-2">Rp{{ number_format($salary->potongan, 0, ',', '.') }}</td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Total Gaji</th>
          <td class="px-4 py-2 font-semibold text-green-700">
            Rp{{ number_format($salary->total_gaji, 0, ',', '.') }}
          </td>
        </tr>
      </tbody>
    </table>

    <div class="mt-6 flex justify-end space-x-3">
        {{-- Tombol Edit --}}
        <x-action-buttons type="edit" :routePrefix="'salaries'" :id="$salary->id" />

        {{-- Tombol Delete --}}
        <x-action-buttons 
        type="delete" 
        :routePrefix="'salaries'" :id="$salary->id" 
        confirmMessage="Yakin ingin menghapus data Gaji ini?" />
    </div>
  </div>
</div>
@endsection
