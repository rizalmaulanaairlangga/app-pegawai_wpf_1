@extends('layouts.app')
@section('title', 'Edit Departemen - ' . $department->nama_departemen)

@section('content')

<div class="poppins-regular h-full w-full flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
        <x-action-buttons type="back" />

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Data Departemen</h2>

        <form action="{{ route('departments.update', $department->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Departemen -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Nama Departemen</label>
                <input type="text" name="nama_departemen" value="{{ old('nama_departemen', $department->nama_departemen) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>


            <!-- Tombol -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
