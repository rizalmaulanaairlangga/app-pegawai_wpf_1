@extends('layouts.auth')

@section('title', 'Reset Password')
@section('auth_title', 'Lupa Password')

@section('form')
<form action="{{ route('forgot.password.send') }}" method="POST" class="space-y-4">
  @csrf

  <div>
    <label class="block mb-1 font-medium">Email terdaftar</label>
    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
  </div>

  <button type="submit"
    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
    Kirim Link Reset
  </button>
</form>
@endsection

@section('bottom_links')
<p class="mt-3">
  <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">⬅️ Kembali ke Login</a>
</p>
@endsection
