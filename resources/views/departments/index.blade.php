@extends('layouts.app')
@section('title', 'Daftar Departemen')

@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
        {{-- <h1 class="text-2xl font-bold text-gray-900 border-b-2 border-blue-600 pb-2 mb-6">
        Daftar Pegawai
        </h1> --}}
        <div class="border-b-2 border-blue-600 pb-2 mb-6"></div>
        <div class="overflow-x-auto">
            <x-table 
            :columns="['id', 'nama_departemen']"
            :data="$departments"
            routePrefix="departments" 
            />
        </div>

        {{-- Tombol Tambah Pegawai --}}
        <x-action-buttons type="create" routePrefix="departments" label="Tambah Departemen" />
    </div>

@endsection
