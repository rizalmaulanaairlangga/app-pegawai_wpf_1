@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-5xl mx-auto py-2 px-6">
    <x-action-buttons type="back" />
    <!-- Profile Card -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <!-- Header Profile Section -->
        <div class="flex flex-col md:flex-row md:items-center p-8 bg-gradient-to-r from-indigo-50 to-blue-50">
            <div class="flex-shrink-0 mx-auto md:mx-0 md:mr-6">
                @if ($employee->foto_profile && file_exists(public_path('storage/' . $employee->foto_profile)))
                    <div class="w-32 h-32 rounded-full overflow-hidden shadow-md">
                        <img src="{{ asset('storage/' . $employee->foto_profile) }}" alt="Profile"
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <div class="w-28 h-28 rounded-full bg-gradient-to-r 
                            @if(auth()->user()->role === 'admin') from-blue-500 to-purple-600
                            @elseif(auth()->user()->role === 'staff') from-green-500 to-teal-600
                            @else from-gray-500 to-gray-600 @endif
                            flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-6 md:mt-0 text-center md:text-left">
                <h2 class="text-2xl font-semibold text-gray-800">{{ $employee->nama_lengkap }}</h2>
                <p class="text-gray-500 mt-1">{{ $employee->position->nama_jabatan ?? 'Posisi tidak tersedia' }}</p>
                <p class="text-gray-600">{{ $employee->department->nama_departemen ?? 'Departemen tidak tersedia' }}</p>
                <div class="mt-3">
                    <span class="px-4 py-1 text-sm font-semibold rounded-full 
                        {{ $employee->status == 'aktif' 
                            ? 'bg-green-100 text-green-800' 
                            : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($employee->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Information Section -->
        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Personal Info -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">
                    Personal Information
                </h3>
                <dl class="space-y-5">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-base text-gray-900">{{ $employee->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                        <dd class="text-base text-gray-900">{{ $employee->nomor_telepon ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                        <dd class="text-base text-gray-900">
                            {{ $employee->tanggal_lahir ? \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d F Y') : '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="text-base text-gray-900">{{ $employee->alamat ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Employment Info -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">
                    Employment Information
                </h3>
                <dl class="space-y-5">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Masuk</dt>
                        <dd class="text-base text-gray-900">
                            {{ $employee->tanggal_masuk ? \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d F Y') : '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Departemen</dt>
                        <dd class="text-base text-gray-900">{{ $employee->department->nama_departemen ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                        <dd class="text-base text-gray-900">{{ $employee->position->nama_jabatan ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
