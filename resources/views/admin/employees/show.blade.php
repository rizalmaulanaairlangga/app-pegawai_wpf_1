@extends('layouts.app')
@section('title', 'Detail Pegawai - ' . $employee->nama_lengkap)

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
  <x-action-buttons type="back" />

  <h2 class="text-2xl font-bold mb-6 text-blue-700">Detail Pegawai</h2> {{-- Diperbaiki judul --}}

  <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
    <tbody class="divide-y divide-gray-100">
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left w-1/3">ID</th>
        <td class="px-4 py-2">{{ $employee->id }}</td>
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Nama Lengkap</th>
        <td class="px-4 py-2">{{ $employee->nama_lengkap }}</td>
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Email</th>
        <td class="px-4 py-2">
          <a href="mailto:{{ $employee->email }}" class="text-blue-600 hover:underline">
            {{ $employee->email }}
          </a>
        </td>
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Nomor Telepon</th>
        <td class="px-4 py-2">
          <a href="tel:{{ $employee->nomor_telepon }}" class="text-blue-600 hover:underline">
            {{ $employee->nomor_telepon }}
          </a>
        </td>
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Tanggal Lahir</th>
        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d F Y') }}</td> {{-- Format tanggal --}}
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Alamat</th>
        <td class="px-4 py-2">{{ $employee->alamat }}</td>
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Tanggal Masuk</th>
        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d F Y') }}</td> {{-- Format tanggal --}}
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Departemen</th>
        <td class="px-4 py-2">
          @if($employee->department)
            <a href="{{ route('departments.show', $employee->department->id) }}" 
               class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium hover:bg-blue-200 transition-colors duration-200">
              {{ $employee->department->nama_departemen }}
            </a>
          @else
            <span class="text-gray-500">-</span>
          @endif
        </td>
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Jabatan</th>
        <td class="px-4 py-2">
          @if($employee->position)
            <a href="{{ route('positions.show', $employee->position->id) }}" 
               class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium hover:bg-green-200 transition-colors duration-200">
              {{ $employee->position->nama_jabatan }}
            </a>
          @else
            <span class="text-gray-500">-</span>
          @endif
        </td>
      </tr>
      <tr>
        <th class="bg-gray-100 px-4 py-2 text-left">Status</th>
        <td class="px-4 py-2">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
            {{ $employee->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $employee->status }}
          </span>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="mt-6 flex justify-end space-x-3">
    {{-- Tombol Edit --}}
    <x-action-buttons type="edit" :routePrefix="'employees'" :id="$employee->id" />
    
    {{-- Tombol Delete --}}
    <x-action-buttons 
      type="delete" 
      :routePrefix="'employees'" 
      :id="$employee->id"
      confirmMessage="Yakin ingin menghapus data Pegawai {{ $employee->nama_lengkap }}?"/>
  </div>
</div>

@endsection