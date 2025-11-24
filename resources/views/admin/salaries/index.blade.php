@extends('layouts.app')

@section('title', 'Gaji Karyawan')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
  {{-- Header --}}
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Gaji Employee per Departemen</h1>
      <p class="text-sm text-gray-500 mt-1">Ringkasan gaji berdasarkan departemen — filter dan buka untuk melihat detail.</p>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('salaries.index') }}" class="flex items-center gap-3 flex-wrap mb-6">
      <select name="department_id" class="border rounded px-3 py-2 text-sm">
        <option value="">Semua Departemen</option>
        @foreach($allDepartments as $dept)
          <option value="{{ $dept->id }}" {{ (string)($departmentId) === (string)$dept->id ? 'selected' : '' }}>
            {{ $dept->nama_departemen }}
          </option>
        @endforeach
      </select>

      <select name="mode" id="modeSelect" class="border rounded px-3 py-2 text-sm">
        <option value="month" {{ $mode === 'month' ? 'selected' : '' }}>Bulan</option>
        <option value="year" {{ $mode === 'year' ? 'selected' : '' }}>Tahun penuh</option>
      </select>

      <select name="bulan" id="bulanSelect" class="border rounded px-3 py-2 text-sm" style="{{ ($mode ?? 'month') === 'month' ? '' : 'display:none' }}">
        @php
          $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        @endphp
        @foreach($months as $num => $label)
          <option value="{{ $num }}" {{ ($month ?? now()->month) == $num ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>

      <select name="year" class="border rounded px-3 py-2 text-sm">
        @foreach($yearList as $y)
          <option value="{{ $y }}" {{ ($year ?? now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endforeach
      </select>

      <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded shadow text-sm inline-flex items-center gap-2">
        Terapkan
      </button>
    </form>
  </div>

  <div class="space-y-6">
    @foreach($summaries as $summary)
        @php
            $dept = $summary['department'];
            $employeeCount = $summary['employee_count'];
            $salaries = $summary['salaries'];
            $color = $summary['color']; // dari controller (soft, stripe, accent)
            // derive accent bg from accent text-class (e.g. text-blue-700 -> bg-blue-700)
            $accentBg = str_replace('text-', 'bg-', $color['accent'] ?? 'text-blue-700');
            // fallback row classes
            $rowA = $color['soft'] ?? 'bg-gray-50';
            $rowB = $color['stripe'] ?? 'bg-gray-100';
            $totalDeptGaji = $salaries->sum('total_gaji');
        @endphp

        <div class="relative rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            {{-- Accent bar kiri (pada card utama) --}}
            <div class="absolute left-0 top-0 bottom-0 w-3 rounded-l-2xl {{ $accentBg }} opacity-90"></div>

            {{-- Card content (beri padding kiri untuk menghindari overlap) --}}
            <div class="pl-6">
                {{-- Header departemen --}}
                <div class="px-6 py-5 bg-white flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $dept->nama_departemen }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Total Karyawan: {{ $employeeCount }}</p>
                        <p class="text-sm text-gray-700 font-medium mt-1">Total Gaji: <span class="text-indigo-700">Rp {{ number_format($totalDeptGaji,0,',','.') }}</span></p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button"
                            class="toggle-salary inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-100 bg-white text-sm shadow-sm hover:shadow-md transition"
                            data-target="dept{{ $dept->id }}">
                            Lihat Semua
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>
                </div>

                {{-- TABLE GAJI (collapsed area) --}}
                <div id="dept{{ $dept->id }}" class="hidden px-6 pb-6 bg-white">
                    @if($salaries->isEmpty())
                        <p class="text-gray-500 italic text-sm py-3">Tidak ada data gaji untuk periode ini.</p>
                    @else
                        <div class="overflow-x-auto border border-gray-100 rounded-lg">
                            <table class="min-w-full text-sm text-gray-700">
                                {{-- Table header lebih gelap --}}
                                <thead class="bg-gray-200 text-gray-800">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                        <th class="px-4 py-3 text-left font-semibold">Jabatan</th>
                                        <th class="px-4 py-3 text-right font-semibold">Bulan</th>
                                        <th class="px-4 py-3 text-right font-semibold">Total</th>
                                        <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($salaries as $i => $salary)
                                        @php
                                            $i = $loop->index;

                                            $rowBg = $i % 2 === 0 ? $color['soft'] : $color['stripe'];

                                            try {
                                                $bulanText = \Carbon\Carbon::createFromFormat('Y-m', $salary->bulan)->translatedFormat('F Y');
                                            } catch (\Exception $e) {
                                                $bulanText = $salary->bulan;
                                            }
                                        @endphp

                                        <tr class="{{ $rowBg }} transition-colors hover:brightness-95">
                                            <td class="px-4 py-3 font-medium text-gray-800">
                                                {{ $salary->employee->nama_lengkap }}
                                            </td>

                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $salary->employee->position->nama_jabatan ?? '-' }}
                                            </td>

                                            <td class="px-4 py-3 text-right text-gray-700">
                                                {{ $bulanText }}
                                            </td>

                                            <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                                Rp {{ number_format($salary->total_gaji ?? 0,0,',','.') }}
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                <div class="inline-flex items-center gap-2">
                                                    <a href="{{ route('salaries.show', $salary->id) }}"
                                                      class="action-icon" title="Lihat">
                                                        🔍
                                                    </a>

                                                    <a href="{{ route('salaries.edit', $salary->id) }}"
                                                      class="action-icon" title="Edit">
                                                        ✏️
                                                    </a>

                                                    <form action="{{ route('salaries.destroy', $salary->id) }}"
                                                          method="POST" class="inline"
                                                          onsubmit="return confirm('Hapus data ini?')">
                                                        @csrf @method('DELETE')
                                                        <button class="action-icon" title="Hapus">
                                                            🗑️
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div> {{-- end pl-6 --}}
        </div> {{-- end card --}}
    @endforeach
  </div>

  {{-- Tombol Tambah Pegawai --}}
  <x-action-buttons type="create" routePrefix="salaries" label="Tambah Gaji" />
</div>

{{-- script show/hide bulan --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const mode = document.getElementById('modeSelect');
    const bulan = document.getElementById('bulanSelect');
    function update() { bulan.style.display = mode.value === 'month' ? 'inline-block' : 'none'; }
    if(mode) {
      mode.addEventListener('change', update);
      update();
    }

    // collapsible
    document.querySelectorAll('.toggle-salary').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.getElementById(btn.dataset.target);
            if (!target) return;
            target.classList.toggle('hidden');
            // smooth scroll to opened block (optional)
            if (!target.classList.contains('hidden')) {
                setTimeout(()=> target.scrollIntoView({behavior:'smooth', block:'start'}), 120);
            }
        });
    });
  });
</script>

{{-- kecilkan/beri efek pada icon aksi --}}
<style>
  .action-icon {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:32px;
    height:32px;
    border-radius:8px;
    transition: .2s ease-in-out;
  }
  .action-icon:hover {
    transform: scale(1.15);
    background-color: rgba(255,255,255,.4);
  }
</style>
@endsection
