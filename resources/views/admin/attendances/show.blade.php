@extends('layouts.app')
@section('title', 'Detail Absensi - ' . $attendance->employee->nama_lengkap)

@section('content')
<div class="poppins-regular h-full w-full flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
    <x-action-buttons type="back" />

    <h2 class="text-2xl font-bold mb-6 text-blue-700">Detail Absensi</h2>

    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
      <tbody class="divide-y divide-gray-100">

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Nama Karyawan</th>
          <td class="px-4 py-2">
            <a href="{{ route('employees.show', $attendance->employee->id) }}" 
              class="text-blue-600 hover:underline">
              {{ $attendance->employee->nama_lengkap }}
            </a>
          </td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Tanggal</th>
          <td class="px-4 py-2">{{ $attendance->tanggal }}</td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Waktu Masuk</th>
          <td class="px-4 py-2">{{ $attendance->waktu_masuk ?? '-' }}</td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Waktu Keluar</th>
          <td class="px-4 py-2">{{ $attendance->waktu_keluar ?? '-' }}</td>
        </tr>

        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left">Status Absensi</th>
          <td class="px-4 py-2 capitalize">
            @php
              $status = $attendance->status_absensi;
              $statusIcon = match($status) {
                  'hadir' => '✅ Hadir',
                  'izin' => '🟡 Izin',
                  'sakit'=> '🩺 Sakit',
                  'alpha'=> '❌ Alpha',
                  default => '⏳ Proses'
              };
            @endphp
            {{ $statusIcon }}
          </td>
        </tr>

        @if($attendance->status_absensi === 'hadir')
          @php
            $jamMasuk = $attendance->waktu_masuk ? \Carbon\Carbon::parse($attendance->waktu_masuk) : null;
            $telat = $jamMasuk && $jamMasuk->greaterThan(\Carbon\Carbon::createFromTime(8, 15));
          @endphp

          <tr>
            <th class="bg-gray-100 px-4 py-2 text-left">Keterangan</th>
            <td class="px-4 py-2">
                @if($telat)
                  ⚠️ Terlambat {{ $jamMasuk->diffInMinutes(\Carbon\Carbon::createFromTime(8,15)) }} menit
                @else
                  🕒 Tepat waktu
                @endif
            </td>
          </tr>
        @endif

      </tbody>
    </table>

    <div class="mt-6 flex justify-end space-x-3">
        {{-- Tombol Edit --}}
        <x-action-buttons type="edit" :routePrefix="'attendances'" :id="$attendance->id" />

        {{-- Tombol Delete --}}
        <x-action-buttons 
        type="delete" 
        :routePrefix="'attendances'" :id="$attendance->id" 
        confirmMessage="Yakin ingin menghapus data Absen ini?" />
    </div>
  </div>
</div>
@endsection
