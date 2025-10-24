@extends('layouts.app')
@section('title', 'Data Gaji Karyawan')

@section('content')
  <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="border-b-2 border-blue-600 pb-2 mb-6"></div>
    
    <div class="overflow-x-auto">
      <x-table 
        :columns="['id', 'nama_karyawan', 'bulan', 'gaji_pokok', 'tunjangan', 'potongan', 'total_gaji']"
        :data="$salaries"
        routePrefix="salaries"
      />
    </div>

    <x-action-buttons type="create" routePrefix="salaries" label="Tambah Data Gaji" />
  </div>
@endsection