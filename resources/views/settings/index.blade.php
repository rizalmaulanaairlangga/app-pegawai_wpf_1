{{-- uploaded image (if you want to preview the design assets): /mnt/data/e70346d0-a5fb-4024-977d-9f83e59fac76.png --}}

@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="max-w-4xl mx-auto py-2 px-4">
        <x-action-buttons type="back" />

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gradient-to-r from-indigo-50 to-blue-50">
                <div class="flex-shrink-0">
                    @if (isset($user->employee) &&
                            $user->employee->foto_profile &&
                            file_exists(public_path('storage/' . $user->employee->foto_profile)))
                        <div class="w-28 h-28 rounded-full overflow-hidden shadow-md">
                            <img src="{{ asset('storage/' . $user->employee->foto_profile) }}" alt="avatar"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <div
                            class="w-28 h-28 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <div class="w-full md:flex-1 md:ml-2">
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        @if (isset($user->employee))
                            {{ $user->employee->position->nama_jabatan ?? '-' }} —
                            {{ $user->employee->department->nama_departemen ?? '-' }}
                        @else
                            -
                        @endif
                    </p>
                    <div class="mt-3 flex items-center gap-3">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold
                {{ (optional($user->employee)->status ?? 'aktif') == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst(optional($user->employee)->status ?? 'aktif') }}
                        </span>

                        <span class="text-sm text-gray-500 px-2">|</span>

                        <span class="text-sm text-gray-600">Role: <span
                                class="font-semibold">{{ ucfirst($user->role) }}</span></span>
                    </div>
                </div>
            </div>

            {{-- Content: two-column form (left: password, right: username/info) --}}
            <form action="{{ route('settings.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                @csrf
                @method('PUT')

                {{-- LEFT: Username & role (fixed name & role shown) --}}
                <div class="bg-white border border-gray-100 rounded-lg p-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Informasi Akun</h2>
                    <p class="text-sm text-gray-500 mb-4">Nama lengkap dan role tidak bisa diubah di sini.</p>

                    {{-- name (readonly) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" readonly
                            class="mt-1 w-full bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-700" />
                    </div>

                    {{-- username (editable) --}}
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" required value="{{ old('username', $user->username) }}"
                            class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-indigo-400 focus:border-indigo-400" />
                        <p class="text-xs text-gray-500 mt-1">Username hanya boleh huruf dan angka (3–32 karakter).</p>
                    </div>

                    {{-- role (readonly) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <input type="text" value="{{ ucfirst($user->role) }}" readonly
                            class="mt-1 w-full bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-700" />
                    </div>
                </div>

                {{-- RIGHT: Password settings --}}
                <div class="bg-white border border-gray-100 rounded-lg p-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Ganti Password</h2>
                    <p class="text-sm text-gray-500 mb-4">Kosongkan jika tidak ingin mengganti password.</p>

                    {{-- current password --}}
                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat
                            Ini</label>
                        <div class="relative mt-1">
                            <input id="current_password" name="current_password" type="password"
                                autocomplete="current-password"
                                class="peer w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm focus:ring-indigo-400 focus:border-indigo-400" />

                            <button type="button" class="pw-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                                aria-label="Toggle password visibility" data-target="current_password">

                                {{-- default: eye closed terlihat (HIDDEN karena password tersembunyi) --}}
                                <svg class="eye-closed w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                {{-- hidden: eye-open (SHOW karena password tersembunyi) --}}
                                <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- new password --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <div class="relative mt-1">
                            <input id="password" name="password" type="password" autocomplete="new-password"
                                class="peer w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm focus:ring-indigo-400 focus:border-indigo-400" />

                            <button type="button" class="pw-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                                aria-label="Toggle password visibility" data-target="password">

                                {{-- default: eye closed terlihat (HIDDEN karena password tersembunyi) --}}
                                <svg class="eye-closed w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                {{-- hidden: eye-open (SHOW karena password tersembunyi) --}}
                                <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- confirm new password --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password Baru</label>
                        <div class="relative mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                autocomplete="new-password"
                                class="peer w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm focus:ring-indigo-400 focus:border-indigo-400" />

                            <button type="button"
                                class="pw-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                                aria-label="Toggle password visibility" data-target="password_confirmation">

                                {{-- default: eye closed terlihat (HIDDEN karena password tersembunyi) --}}
                                <svg class="eye-closed w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                {{-- hidden: eye-open (SHOW karena password tersembunyi) --}}
                                <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- submit area (align bottom when tall) --}}
                    <div class="mt-4 flex items-center justify-end gap-3">
                        <a href="{{ url()->previous() }}"
                            class="px-4 py-2 border border-gray-200 rounded text-sm">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- JS: password toggles. Icons are persistent and consistent for all password inputs. --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all password toggles
            document.querySelectorAll('.pw-toggle').forEach(btn => {
                // Set initial state correctly
                const targetId = btn.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const eyeOpen = btn.querySelector('.eye-open');
                const eyeClosed = btn.querySelector('.eye-closed');

                // Ensure initial state: password hidden = show eye-open (mata tertutup)
                if (input && input.type === 'password') {
                    eyeOpen.classList.remove('hidden'); // Show mata tertutup
                    eyeClosed.classList.add('hidden'); // Hide mata terbuka
                }

                // Add click handler
                btn.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const eyeOpen = this.querySelector('.eye-open');
                    const eyeClosed = this.querySelector('.eye-closed');

                    if (!input) {
                        console.error('Input not found for target:', targetId);
                        return;
                    }

                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';

                    // Toggle visibility of eye icons
                    if (isHidden) {
                        // Show password: hide mata tertutup, show mata terbuka
                        eyeOpen.classList.add('hidden');
                        eyeClosed.classList.remove('hidden');
                    } else {
                        // Hide password: show mata tertutup, hide mata terbuka
                        eyeClosed.classList.add('hidden');
                        eyeOpen.classList.remove('hidden');
                    }
                });
            });
        });
    </script>

    <style>
        /* slightly larger clickable area for the eye */
        .pw-toggle {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background-color 0.12s ease;
            transform: translateY(-50%) !important;
            top: 50% !important;
        }

        .pw-toggle:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .pw-toggle svg {
            pointer-events: none;
        }

        /* Ensure proper positioning */
        .relative .pw-toggle {
            position: absolute;
            right: 0.75rem;
        }
    </style>
@endsection
