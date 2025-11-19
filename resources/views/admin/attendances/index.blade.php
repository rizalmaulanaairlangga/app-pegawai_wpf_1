@extends('layouts.app')
@section('title', 'Data Kehadiran Karyawan')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
  <div class="border-b-2 border-blue-600 pb-2 mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Rekap Kehadiran Karyawan</h1>

    {{-- Filter Bulan dan Tahun --}}
    <form method="GET" action="{{ route('attendances.index') }}" class="flex items-center gap-2">
      <select name="month" class="border-gray-300 rounded-lg text-sm px-3 py-1">
        @foreach(range(1,12) as $m)
          <option value="{{ $m }}" {{ $m == $selectedMonth ? 'selected' : '' }}>
            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
          </option>
        @endforeach
      </select>

      <select name="year" class="border-gray-300 rounded-lg text-sm px-3 py-1">
        @foreach($yearList as $year)
          <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
            {{ $year }}
          </option>
        @endforeach
      </select>

      <button type="submit"
        class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 transition">
        Tampilkan
      </button>
    </form>
  </div>

  {{-- Kalender Bulanan --}}
  <div class="overflow-x-auto no-scrollbar">
    <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-lg">
      <thead class="bg-indigo-50 text-gray-800">
        <tr>
          {{-- Header Kolom Karyawan --}}
          <th class="sticky left-0 z-20 bg-indigo-50 font-medium text-gray-800 px-4 py-2 shadow-[inset_-2px_0_0_0_#d1d5db]">
              Karyawan
          </th>

          @foreach(range(1, $daysInMonth) as $day)
            <th class="px-2 py-2 text-center border-l border-gray-200
              {{ $day % 7 == 0 ? 'border-r-4 border-indigo-200' : '' }}">
              {{ $day }}
            </th>
          @endforeach
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-100">
        @foreach($employees as $employee)
          <tr class="attendance-row transition odd:bg-white even:bg-gray-50">
            
            {{-- Nama Karyawan --}}
            <td class="sticky left-0 z-20 bg-white attendance-name-cell font-medium text-gray-800 px-4 py-2 shadow-[inset_-2px_0_0_0_#d1d5db]">
                {{ $employee->nama_lengkap }}
            </td>

            {{-- Status Tiap Hari --}}
            @foreach(range(1, $daysInMonth) as $day)
              @php
                $tanggal = \Carbon\Carbon::create($selectedYear, $selectedMonth, $day)->format('Y-m-d');

                $attendance = $attendances->first(fn($a) =>
                  $a->karyawan_id == $employee->id && $a->tanggal == $tanggal
                );

                $icon = '➖';
                $color = 'text-gray-400';

                if ($attendance) {
                    if ($attendance->status_absensi === 'hadir') {
                        // Deteksi telat jika lebih dari 08:15
                        $jamMasuk = $attendance->waktu_masuk
                            ? \Carbon\Carbon::createFromFormat('H:i:s', $attendance->waktu_masuk)
                            : null;

                        if ($jamMasuk && $jamMasuk->greaterThan(\Carbon\Carbon::createFromTime(8, 15))) {
                            $icon = '⚠️'; 
                            $color = 'text-yellow-600';
                        } else {
                            $icon = '✅'; 
                            $color = 'text-green-600';
                        }
                    } else {
                        switch($attendance->status_absensi) {
                            case 'izin': $icon = '📄'; $color = 'text-blue-500'; break;
                            case 'sakit': $icon = '🩺'; $color = 'text-purple-500'; break;
                            case 'alpha': $icon = '❌'; $color = 'text-red-600'; break;
                        }
                    }
                }
              @endphp

              <td class="px-2 py-2 text-center border-l border-gray-100
                  {{ $day % 7 == 0 ? 'border-r-4 border-indigo-200' : '' }}">

                @if ($attendance)
                  <a href="{{ route('attendances.show', $attendance->id) }}"
                    class="inline-block text-lg {{ $color }} hover:scale-125 transition-transform">
                    {{ $icon }}
                  </a>
                @else
                  <span class="text-gray-300">-</span>
                @endif
              </td>

            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    <x-action-buttons type="create" routePrefix="attendances" label="Tambah Data Kehadiran" />
  </div>
</div>

{{-- Hilangkan scrollbar tapi tetap bisa scroll --}}
<style>
  .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }

  /* Saat baris dihover → semua sel berubah warna */
  .attendance-row:hover td {
      background-color: #eef2ff !important; /* indigo-50 */
  }

  /* Pastikan kolom nama ikut berubah */
  .attendance-row:hover .attendance-name-cell {
      background-color: #eef2ff !important;
      /* Shadow tetap agar batas kanan terlihat */
      box-shadow: inset -2px 0 0 #c7d2fe;
  }

  /* Perbaiki teks status agar tetap jelas saat hover */
  .attendance-row:hover a,
  .attendance-row:hover span {
      opacity: 1 !important;
  }

</style>
@endsection
