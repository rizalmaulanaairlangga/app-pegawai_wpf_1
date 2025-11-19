@extends('layouts.app')

@section('title', 'My Attendance')

@section('content')
<div class="max-w-6xl mx-auto py-2 px-6">

    {{-- Breadcrumb / Back Button --}}
    <x-action-buttons type="back" />


    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        {{-- Header --}}
        <div class="mt-2 mb-4 px-8 pt-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Rekap Data Attendance</h1>
                <p class="text-gray-500 mt-1 text-lg">{{ $employee->nama_lengkap }}</p>
            </div>
        </div>

        {{-- Section: Absensi Hari Ini + Rekap Bulanan --}}
        <div class="px-8 mt-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Kiri: Absensi Hari Ini --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Absensi Hari Ini</h2>

                    @php
                        $status = $attendanceToday->status_absensi ?? 'belum_absen';
                        $warna = match($status) {
                            'hadir' => 'bg-green-100 text-green-800 border-green-300',
                            'izin' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'sakit' => 'bg-blue-100 text-blue-800 border-blue-300',
                            'alpha' => 'bg-red-100 text-red-800 border-red-300',
                            default => 'bg-gray-100 text-gray-600 border-gray-200'
                        };
                        $statusLabel = match($status) {
                            'hadir' => '✅ Hadir',
                            'izin' => '🟡 Izin',
                            'sakit' => '🩺 Sakit',
                            'alpha' => '❌ Alpha',
                            default => 'Belum Absen'
                        };
                    @endphp

                    <div class="{{ $warna }} border rounded-xl p-4 mb-4">
                        <p class="text-sm font-medium text-gray-600">Status Hari Ini</p>
                        <h3 class="text-xl font-bold mt-1">{{ $statusLabel }}</h3>
                        @if($attendanceToday)
                            <p class="text-sm text-gray-700 mt-2">
                                Masuk: {{ $attendanceToday->waktu_masuk ?? '-' }} |
                                Pulang: {{ $attendanceToday->waktu_keluar ?? '-' }}
                            </p>

                            {{-- Tambahkan keterangan keterlambatan --}}
                            @if(isset($attendanceToday->is_telat) && $attendanceToday->is_telat)
                                <p class="mt-1 text-sm font-medium text-orange-700">
                                    ⚠️ Telat {{ $attendanceToday->selisih_telat }} menit
                                </p>
                            @elseif($attendanceToday->status_absensi === 'hadir')
                                <p class="mt-1 text-sm text-green-700">🕒 Tepat waktu</p>
                            @endif
                        @endif
                    </div>

                    {{-- Tombol Check In / Check Out --}}
                    <div class="flex flex-wrap gap-3">
                        <form method="POST" action="{{ route('myattendance.checkin') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow 
                                    {{ $attendanceToday && $attendanceToday->waktu_masuk ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $attendanceToday && $attendanceToday->waktu_masuk ? 'disabled' : '' }}>
                                ⏰ Check In
                            </button>
                        </form>

                        <form method="POST" action="{{ route('myattendance.checkout') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow">
                                🏁 Check Out
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Kanan: Rekap Bulan Ini --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Rekap Absensi Bulan Ini</h2>
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                        @if($countTelat > 0)
                            <div class="bg-orange-50 border border-orange-200 rounded-xl shadow-sm p-4 text-center">
                                <p class="text-xs text-gray-500">Telat</p>
                                <h3 class="text-lg font-bold text-orange-700 mt-1">{{ $countTelat }}x ⚠️</h3>
                            </div>
                        @endif

                        @if($countIzin > 0)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm p-4 text-center">
                                <p class="text-xs text-gray-500">Izin</p>
                                <h3 class="text-lg font-bold text-yellow-700 mt-1">{{ $countIzin }}x 🟡</h3>
                            </div>
                        @endif

                        @if($countSakit > 0)
                            <div class="bg-blue-50 border border-blue-200 rounded-xl shadow-sm p-4 text-center">
                                <p class="text-xs text-gray-500">Sakit</p>
                                <h3 class="text-lg font-bold text-blue-700 mt-1">{{ $countSakit }}x 🩺</h3>
                            </div>
                        @endif

                        @if($countAlpha > 0)
                            <div class="bg-red-50 border border-red-200 rounded-xl shadow-sm p-4 text-center">
                                <p class="text-xs text-gray-500">Alpha</p>
                                <h3 class="text-lg font-bold text-red-700 mt-1">{{ $countAlpha }}x ❌</h3>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Filter Bulan & Tahun --}}
        <div class="px-8 my-3">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Filter Absensi
                    </h2>
                </div>

                <form method="GET" action="{{ route('myattendance.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
                    {{-- Filter Bulan --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                        <label for="bulan" class="text-gray-600 text-sm font-medium">Bulan:</label>
                        <select id="bulan" name="bulan"
                            class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                            @foreach($monthList as $value => $label)
                                <option value="{{ $value }}" {{ $selectedMonth == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Tahun --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                        <label for="tahun" class="text-gray-600 text-sm font-medium">Tahun:</label>
                        <select id="tahun" name="tahun"
                            class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                            @foreach($yearList as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit"
                        class="mt-2 sm:mt-0 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 active:scale-[0.98] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h4a1 1 0 010 2H5v14h14v-3a1 1 0 112 0v4a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm15.293 1.707a1 1 0 010 1.414L13.414 12l4.879 4.879a1 1 0 01-1.414 1.414L12 13.414l-4.879 4.879a1 1 0 01-1.414-1.414L10.586 12 5.707 7.121a1 1 0 011.414-1.414L12 10.586l4.879-4.879a1 1 0 011.414 0z" />
                        </svg>
                        Terapkan
                    </button>
                </form>
            </div>
        </div>

        {{-- TABEL ABSENSI PER MINGGU --}}
        <div class="px-8 pb-8">
            @php
                use Carbon\Carbon;
                $grouped = $attendances->groupBy(function($item) {
                    // Kelompokkan berdasarkan minggu dalam bulan
                    return Carbon::parse($item->tanggal)->weekOfMonth;
                });
                $monthName = Carbon::parse($attendances->first()->tanggal ?? now())->translatedFormat('F Y');
            @endphp

            @forelse($grouped as $week => $records)
                @php
                    $startDate = Carbon::parse($records->first()->tanggal)->format('d');
                    $endDate = Carbon::parse($records->last()->tanggal)->format('d');
                    $weekColor = match($week % 4) {
                        1 => 'bg-gray-50 border-l-4 border-l-indigo-400',
                        2 => 'bg-blue-50 border-l-4 border-l-blue-400',
                        3 => 'bg-green-50 border-l-4 border-l-green-400',
                        0 => 'bg-yellow-50 border-l-4 border-l-yellow-400',
                        default => 'bg-gray-50 border-l-4 border-l-indigo-400',
                    };
                @endphp

                <div class="mb-6 rounded-xl overflow-hidden shadow-sm {{ $weekColor }}">
                    <div class="px-4 py-3 bg-white border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">
                            📅 Minggu ke-{{ $week }} ({{ $endDate }} – {{ $startDate }} {{ $monthName }})
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700">
                            <thead class="bg-gray-100 border-t border-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left">Hari</th>
                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                    <th class="px-4 py-2 text-center">Masuk</th>
                                    <th class="px-4 py-2 text-center">Pulang</th>
                                    <th class="px-4 py-2 text-center">Status</th>
                                    <th class="px-4 py-2 text-left">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $absen)
                                    @php
                                        $hariObj = Carbon::parse($absen->tanggal);
                                        $hari = $hariObj->translatedFormat('l');
                                        $warnaIcon = '';
                                        $statusIcon = '';
                                        $statusText = ucfirst($absen->status_absensi ?? '-');

                                        switch ($absen->status_absensi) {
                                            case 'hadir':
                                                $warnaIcon = '🟢';
                                                $statusIcon = '✅';
                                                break;
                                            case 'izin':
                                                $warnaIcon = '🔵';
                                                $statusIcon = '💤';
                                                break;
                                            case 'sakit':
                                                $warnaIcon = '🩺';
                                                $statusIcon = '🤒';
                                                break;
                                            case 'alpha':
                                                $warnaIcon = '🔴';
                                                $statusIcon = '❌';
                                                break;
                                            default:
                                                $warnaIcon = '⚪';
                                                $statusIcon = '⏳';
                                        }

                                        // Highlight hari ini
                                        $isToday = $hariObj->isToday();
                                    @endphp

                                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition {{ $isToday ? 'bg-green-100 font-semibold' : '' }}">
                                        <td class="px-4 py-2 font-medium flex items-center gap-1">
                                            <span>{{ $warnaIcon }}</span> {{ $hari }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $hariObj->format('d M Y') }}</td>
                                        <td class="px-4 py-2 text-center">{{ $absen->waktu_masuk ? substr($absen->waktu_masuk, 0, 5) : '-' }}</td>
                                        <td class="px-4 py-2 text-center">{{ $absen->waktu_keluar ? substr($absen->waktu_keluar, 0, 5) : '-' }}</td>
                                        <td class="px-4 py-2 text-center font-semibold">
                                            {{ $statusIcon }} {{ $statusText }}
                                            @if(isset($absen->is_telat) && $absen->is_telat)
                                                <span class="block text-xs font-normal text-orange-600 mt-1">
                                                    ⚠️ Telat {{ $absen->selisih_telat }} menit
                                                </span>
                                            @elseif($absen->status_absensi === 'hadir')
                                                <span class="block text-xs font-normal text-green-600 mt-1">
                                                    🕒 Tepat waktu
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-2">{{ $absen->keterangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    Belum ada data absensi untuk bulan ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
