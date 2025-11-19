@extends('layouts.app')

@section('title', 'My Salaries')

@section('content')
<div class="max-w-6xl mx-auto py-2 px-6">
    <x-action-buttons type="back" />

    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Rekap Gaji Saya</h1>
                <p class="text-gray-500 mt-1 text-lg">{{ $employee->nama_lengkap }}</p>
            </div>
        </div>

        {{-- Filter Tahun --}}
        <div class="px-8 py-4 bg-gray-50 border-b border-gray-200">
            <form method="GET" action="{{ route('mysalaries.index') }}" class="flex flex-wrap items-center gap-3">
                <label for="tahun" class="text-sm text-gray-600 font-medium">Tahun:</label>
                <select id="tahun" name="tahun"
                    class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                    @foreach($yearList as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 active:scale-[0.98] transition">
                    Terapkan
                </button>
            </form>
        </div>

        {{-- Daftar Gaji --}}
        <div class="px-8 py-6">
            @if($salaries->isEmpty())
                <div class="text-center text-gray-500 py-8">
                    Belum ada data gaji untuk tahun ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-indigo-50 text-gray-800 font-semibold">
                            <tr>
                                <th class="px-4 py-2 text-left">Bulan</th>
                                <th class="px-4 py-2 text-right">Gaji Pokok</th>
                                <th class="px-4 py-2 text-right">Tunjangan</th>
                                <th class="px-4 py-2 text-right">Potongan</th>
                                <th class="px-4 py-2 text-right">Total Gaji</th>
                                <th class="px-4 py-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salaries as $salary)
                                @php
                                    $bulanText = \Carbon\Carbon::createFromFormat('Y-m', $salary->bulan)->translatedFormat('F');
                                @endphp
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 font-medium text-gray-800">{{ $bulanText }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right text-green-600">+ Rp {{ number_format($salary->tunjangan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right text-red-600">- Rp {{ number_format($salary->potongan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right font-semibold text-indigo-700">
                                        Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            ✅ Diterima
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
