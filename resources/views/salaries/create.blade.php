@extends('layouts.app')
@section('title', 'Tambah Data Gaji')

@section('content')
<div class="font-[Poppins] bg-gray-50 h-full w-full flex items-center items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-5xl">
        <x-action-buttons type="back" />
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Form Tambah Gaji Karyawan</h2>

        <form action="{{ route('salaries.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Karyawan -->
            <div class="md:col-span-2">
                <label for="karyawan_id" class="block mb-1 text-gray-700 font-medium">Karyawan</label>
                <select id="karyawan_id" name="karyawan_id"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}" data-gaji-pokok="{{ $emp->position->gaji_pokok ?? 0 }}">
                            {{ $emp->nama_lengkap }} - {{ $emp->position->nama_jabatan ?? 'Tidak ada jabatan' }}
                        </option>
                    @endforeach
                </select>
                @error('karyawan_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bulan (Otomatis bulan sekarang) -->
            <div>
                <label for="bulan" class="block mb-1 text-gray-700 font-medium">Periode Gaji</label>
                <input type="month" id="bulan" name="bulan"
                       value="{{ date('Y-m') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('bulan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gaji Pokok -->
            <div>
                <label for="gaji_pokok" class="block mb-1 text-gray-700 font-medium">Gaji Pokok</label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 bg-blue-50 text-blue-700 font-semibold border-gray-300">
                        Rp
                    </span>
                    <input type="text" id="gaji_pokok" name="gaji_pokok"
                           value="{{ old('gaji_pokok') }}"
                           placeholder="0"
                           class="salary-input flex-1 min-w-0 block w-full px-4 py-2 rounded-r-lg border border-l-0 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-right tracking-wide"
                           data-field="gaji_pokok">
                </div>
                @error('gaji_pokok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tunjangan -->
            <div>
                <label for="tunjangan" class="block mb-1 text-gray-700 font-medium">Tunjangan</label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 bg-blue-50 text-blue-700 font-semibold border-gray-300">
                        Rp
                    </span>
                    <input type="text" id="tunjangan" name="tunjangan" 
                           value="{{ old('tunjangan', '0') }}"
                           class="salary-input flex-1 min-w-0 block w-full px-4 py-2 rounded-r-lg border border-l-0 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-right tracking-wide"
                           data-field="tunjangan">
                </div>
                @error('tunjangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Potongan -->
            <div>
                <label for="potongan" class="block mb-1 text-gray-700 font-medium">Potongan</label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 bg-blue-50 text-blue-700 font-semibold border-gray-300">
                        Rp
                    </span>
                    <input type="text" id="potongan" name="potongan" 
                           value="{{ old('potongan', '0') }}"
                           class="salary-input flex-1 min-w-0 block w-full px-4 py-2 rounded-r-lg border border-l-0 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-right tracking-wide"
                           data-field="potongan">
                </div>
                @error('potongan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Gaji -->
            <div>
                <label for="total_gaji" class="block mb-1 text-gray-700 font-medium">Total Gaji</label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 bg-green-50 text-green-700 font-semibold border-gray-300">
                        Rp
                    </span>
                    <input type="text" id="total_gaji" name="total_gaji"
                           value="{{ old('total_gaji', '0') }}"
                           readonly
                           class="flex-1 min-w-0 block w-full px-4 py-2 rounded-r-lg border border-l-0 border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none text-right tracking-wide font-semibold bg-green-50 text-green-700">
                </div>
                <p class="text-sm text-gray-500 mt-1">*Total dihitung otomatis</p>
                @error('total_gaji')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <div class="md:col-span-2 flex justify-end pt-4">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript untuk Auto Calculate -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const salaryInputs = document.querySelectorAll('.salary-input');
    const karyawanSelect = document.getElementById('karyawan_id');
    const gajiPokokInput = document.getElementById('gaji_pokok');
    const tunjanganInput = document.getElementById('tunjangan');
    const potonganInput = document.getElementById('potongan');
    const totalGajiInput = document.getElementById('total_gaji');

    function formatCurrency(value) {
        const numericValue = value.replace(/\D/g, '');
        return numericValue ? new Intl.NumberFormat('id-ID').format(numericValue) : '0';
    }

    function parseCurrency(value) {
        return parseInt(value.replace(/\D/g, '')) || 0;
    }

    function calculateTotal() {
        const gajiPokok = parseCurrency(gajiPokokInput.value);
        const tunjangan = parseCurrency(tunjanganInput.value);
        const potongan = parseCurrency(potonganInput.value);
        
        const total = gajiPokok + tunjangan - potongan;
        totalGajiInput.value = formatCurrency(total.toString());
    }

    // Auto fill gaji pokok ketika karyawan dipilih
    karyawanSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const gajiPokok = selectedOption.getAttribute('data-gaji-pokok') || '0';
        gajiPokokInput.value = formatCurrency(gajiPokok);
        calculateTotal();
    });

    // Hitung total ketika input berubah
    salaryInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Format input
            this.value = formatCurrency(this.value);
            // Hitung total
            calculateTotal();
        });
    });

    // Format semua input saat load
    salaryInputs.forEach(input => {
        if (input.value) {
            input.value = formatCurrency(input.value);
        }
    });

    // Hitung total awal
    calculateTotal();

    // Format sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        // Convert semua input ke numeric sebelum submit
        salaryInputs.forEach(input => {
            input.value = parseCurrency(input.value);
        });
        totalGajiInput.value = parseCurrency(totalGajiInput.value);
    });
});
</script>
@endsection