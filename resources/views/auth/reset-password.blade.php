@extends('layouts.auth')

@section('title', 'Reset Password')
@section('auth_title', 'Reset Password')

@section('form')
@if($errors->any())
  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <strong>Errors:</strong>
    <ul>
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if(session('status'))
  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('status') }}
  </div>
@endif

<form method="POST" action="{{ route('password.update') }}" class="space-y-4">
  @csrf
  <input type="hidden" name="token" value="{{ $token }}">

  <div>
    <label class="block mb-1 font-medium text-gray-700">Email</label>
    <input type="email" name="email" value="{{ old('email', $email) }}" required
      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none bg-gray-50"
      readonly />
  </div>

  {{-- Password Baru --}}
  <div class="relative">
    <label for="password" class="block mb-1 font-medium text-gray-700">Password Baru</label>
    <input id="password" name="password" type="password" required
      class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none transition-colors" />
    
    <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
    
    <button type="button"
            class="pw-toggle absolute right-2 top-[56%] -translate-y-1/2 text-gray-500 hover:text-indigo-600 transition-colors"
            aria-label="Toggle password visibility"
            data-target="password">
      {{-- Eye open (hidden by default) --}}
      <svg class="eye-open hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
      </svg>

      {{-- Eye closed (visible by default) --}}
      <svg class="eye-closed w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
      </svg>
    </button>
  </div>

  {{-- Konfirmasi Password --}}
  <div class="relative">
    <label for="password_confirmation" class="block mb-1 font-medium text-gray-700">Konfirmasi Password</label>
    <input id="password_confirmation" name="password_confirmation" type="password" required
      class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none transition-colors" />
    
    <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
    
    <button type="button"
            class="pw-toggle absolute right-2 top-[56%] -translate-y-1/2 text-gray-500 hover:text-indigo-600 transition-colors"
            aria-label="Toggle confirmation visibility"
            data-target="password_confirmation">
      {{-- Eye open (hidden by default) --}}
      <svg class="eye-open hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
      </svg>

      {{-- Eye closed (visible by default) --}}
      <svg class="eye-closed w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
      </svg>
    </button>
  </div>

  <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
    Reset Password
  </button>
</form>
@endsection

@push('scripts')
<script>
// Custom script untuk reset password dengan multiple fields
document.addEventListener('DOMContentLoaded', function () {
  // Attach click handlers to all password toggle buttons
  document.querySelectorAll('.pw-toggle').forEach(btn => {
    btn.addEventListener('click', function () {
      const targetId = this.getAttribute('data-target');
      const input = document.getElementById(targetId);
      
      if (!input) {
        console.error('Input not found for target:', targetId);
        return;
      }

      const eyeOpen = this.querySelector('.eye-open');
      const eyeClosed = this.querySelector('.eye-closed');

      if (input.type === 'password') {
        // Show password
        input.type = 'text';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
      } else {
        // Hide password
        input.type = 'password';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
      }
    });
  });
});
</script>
@endpush