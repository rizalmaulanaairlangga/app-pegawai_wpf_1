@extends('layouts.app')
@section('title', 'Tambah Posisi / Jabatan')

@section('content')
<div class="font-[Poppins] bg-gray-50 flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-3xl">
        <x-action-buttons type="back" />
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Form Tambah Posisi / Jabatan</h2>

        <form action="{{ route('positions.store') }}" method="POST" class="grid grid-cols-1 gap-6">
            @csrf

            <!-- Nama Jabatan -->
            <div>
                <label for="nama_jabatan" class="block mb-1 text-gray-700 font-medium">Nama Jabatan</label>
                <input type="text" id="nama_jabatan" name="nama_jabatan"
                       value="{{ old('nama_jabatan') }}"
                       placeholder="Contoh: Staff HRD, Manager Produksi"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('nama_jabatan')
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
                           class="currency-input flex-1 min-w-0 block w-full px-4 py-2 rounded-r-lg border border-l-0 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-right tracking-wide">
                </div>
                @error('gaji_pokok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JS: Format angka otomatis -->
<script>
document.querySelectorAll('.currency-input').forEach(input => {
    input.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        this.value = new Intl.NumberFormat('id-ID').format(value);
    });
});
</script>

<script>
document.querySelector('form').addEventListener('submit', function (e) {
    document.querySelectorAll('.currency-input').forEach(input => {
        input.value = input.value.replace(/\D/g, '');
    });
});
</script>

@endsection