@extends('layouts.app')
@section('title', 'Tambah Departemen')

@section('content')

<div class="poppins-regular h-full w-full flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl"> 
        <x-action-buttons type="back" />
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">Form Departemen</h1>

        <form action="{{ route('departments.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_departemen" class="block text-sm font-medium text-gray-700">Nama Departemen</label>
                <input type="text" id="nama_departemen" name="nama_departemen" 
                       class="mt-1 w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Tombol Submit -->
            <div class="md:col-span-2 flex justify-end pt-4">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
