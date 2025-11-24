@extends('layouts.auth')

@section('title', 'Login - HRISense')
@section('auth_title', 'Login ke HRISense')

@section('form')
<form action="{{ route('login.process') }}" method="POST" class="space-y-4">
  @csrf

  @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded-lg">
      @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  @endif

  <div>
    <label class="block mb-1 font-medium">Email atau Username</label>
    <input type="text" name="login" value="{{ old('login') }}"
      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
  </div>

  <div class="relative">
      <label for="password" class="block font-semibold text-gray-700 mb-1">Password</label>
      <input type="password" id="password" name="password" required
          class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none transition-colors">
      
      {{-- Eye Toggle --}}
      <button type="button" onclick="togglePassword()" 
          class="absolute bottom-3 right-3 flex items-center justify-center text-gray-500 hover:text-indigo-600 transition-colors duration-200" tabindex="-1">
          {{-- Eye Open (default - HIDDEN karena password tersembunyi) --}}
          <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          
          {{-- Eye Closed (default - SHOW karena password tersembunyi) --}}
          <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
          </svg>
      </button>
  </div>

  <button type="submit"
    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
    Masuk Sekarang
  </button>
</form>

@endsection

@section('bottom_links')
<div class="flex justify-between mt-4">
  <a href="{{ route('forgot.password') }}" class="text-indigo-600 hover:underline">Lupa Password?</a>
  <a href="{{ url('/') }}" class="text-indigo-600 hover:underline">Beranda</a>
</div>
<p class="mt-3">
  Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-indigo-700">Daftar</a>
</p>
@endsection
