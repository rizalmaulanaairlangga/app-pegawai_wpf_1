@extends('layouts.auth')

@section('title', 'Reset Password')
@section('auth_title', 'Reset Password')

@section('form')
{{-- Tambahkan di atas form --}}
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
  {{-- JANGAN PAKAI @method('PUT') --}}

  <input type="hidden" name="token" value="{{ $token }}">

  <div>
    <label class="block mb-1 font-medium text-gray-700">Email</label>
    <input type="email" name="email" value="{{ old('email', $email) }}" required
      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none bg-gray-50"
      readonly />
  </div>

  <div class="relative">
    <label class="block mb-1 font-medium text-gray-700">Password Baru</label>
    <input type="password" name="password" required 
      class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none" />
    
    <button type="button" onclick="togglePassword(this)" 
      class="absolute right-3 bottom-2 text-gray-500 hover:text-indigo-600">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.476 0 8.268 2.943 9.542 7-1.274 4.057-5.066 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
      </svg>
    </button>
  </div>

  <div class="relative">
    <label class="block mb-1 font-medium text-gray-700">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" required 
      class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none" />
    
    <button type="button" onclick="togglePassword(this)" 
      class="absolute right-3 bottom-2 text-gray-500 hover:text-indigo-600">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.476 0 8.268 2.943 9.542 7-1.274 4.057-5.066 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
      </svg>
    </button>
  </div>

  <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
    Reset Password
  </button>
</form>

<script>
function togglePassword(button) {
  const input = button.parentElement.querySelector('input');
  const icon = button.querySelector('svg');
  
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
    `;
  } else {
    input.type = 'password';
    icon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.476 0 8.268 2.943 9.542 7-1.274 4.057-5.066 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
    `;
  }
}
</script>
@endsection