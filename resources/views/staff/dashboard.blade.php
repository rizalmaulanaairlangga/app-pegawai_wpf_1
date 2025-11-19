@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-6 space-y-6">

    {{-- 🔹 Greeting --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }} 👋</h1>
        <p class="text-gray-500 text-sm">Pantau absensi dan gajimu di sini</p>
    </div>

    {{-- 🔹 Tombol Check In / Check Out --}}
    <div class="flex flex-wrap justify-center gap-3">
        <form method="POST" action="{{ route('myattendance.checkin') }}">
            @csrf
            <button type="submit"
                class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow
                    {{ $attendanceToday && $attendanceToday->waktu_masuk ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ $attendanceToday && $attendanceToday->waktu_masuk ? 'disabled' : '' }}>
                ⏰ Check In
            </button>
        </form>

        <form method="POST" action="{{ route('myattendance.checkout') }}">
            @csrf
            <button type="submit"
                class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow">
                🏁 Check Out
            </button>
        </form>
    </div>

    {{-- 🔹 Mini Kalender Absensi Minggu Ini --}}
    <div class="bg-white shadow rounded-xl p-4">
        <h2 class="font-semibold text-gray-700 mb-3">📅 Absensi Minggu Ini</h2>

        <div class="grid grid-cols-7 text-center font-semibold text-gray-600 border-b pb-2 mb-2">
            <div>Su</div>
            <div>Mo</div>
            <div>Tu</div>
            <div>We</div>
            <div>Th</div>
            <div>Fr</div>
            <div>Sa</div>
        </div>

        <div class="grid grid-cols-7 text-center text-xl">
            @foreach($weeklyAttendance as $absen)
                @php
                    switch ($absen->status_absensi) {
                        case 'hadir':
                            $icon = $absen->is_telat ? '⚠️' : '✅';
                            break;
                        case 'izin':
                            $icon = '💤';
                            break;
                        case 'sakit':
                            $icon = '🩺';
                            break;
                        case 'alpha':
                            $icon = '❌';
                            break;
                        default:
                            $icon = '-';
                    }
                @endphp
                <div>{{ $icon }}</div>
            @endforeach
        </div>
    </div>

    {{-- 🔹 Ringkasan Gaji 3 Bulan Terakhir --}}
    <div class="bg-white shadow rounded-xl p-4">
        <h2 class="font-semibold text-gray-700 mb-3">💰 Gaji 3 Bulan Terakhir</h2>

        <table class="w-full text-sm text-gray-700">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Bulan</th>
                    <th class="text-right py-2">Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentSalaries as $salary)
                    @php
                        $bulanText = \Carbon\Carbon::createFromFormat('Y-m', $salary->bulan)->translatedFormat('F Y');
                    @endphp
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="py-2">{{ $bulanText }}</td>
                        <td class="py-2 text-right font-semibold text-indigo-700">
                            Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
