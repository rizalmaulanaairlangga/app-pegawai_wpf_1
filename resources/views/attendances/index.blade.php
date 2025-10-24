@extends('layouts.app')
@section('title', 'Data Kehadiran Karyawan')

@section('content')
  <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="border-b-2 border-blue-600 pb-2 mb-6"></div>

    <div class="overflow-x-auto">
      <x-table 
        :columns="['id', 'nama_karyawan', 'tanggal', 'waktu_masuk', 'waktu_keluar', 'status_absensi']"
        :data="$attendances"
        routePrefix="attendances"
      />
    </div>

    <x-action-buttons type="create" routePrefix="attendances" label="Tambah Data Kehadiran" />
  </div>
@endsection