<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - HRISense</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-indigo-300 min-h-screen flex items-center justify-center">

  <div class="bg-white shadow-2xl rounded-2xl w-full max-w-md p-10 space-y-6">
    <div class="text-center">
      <img src="{{ asset('images/logo-utama.jpg') }}" alt="Logo HRISense"
           class="w-16 h-16 mx-auto rounded-full object-cover mb-4">
      <h1 class="text-3xl font-bold text-indigo-700">Login ke HRISense</h1>
      <p class="text-gray-500 text-sm mt-2">HR Management System</p>
    </div>

    @if($errors->any())
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ url('/login') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label for="login" class="block font-semibold text-gray-700 mb-1">Email atau Username</label>
        <input type="text" id="login" name="login" value="{{ old('login') }}" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none">
      </div>

      <div>
        <label for="password" class="block font-semibold text-gray-700 mb-1">Password</label>
        <input type="password" id="password" name="password" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none">
      </div>

      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
        Masuk Sekarang
      </button>
    </form>

    <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600 mt-4 gap-3">
      <a href="{{ url('/forgot-password') }}" class="text-indigo-600 hover:underline">Lupa Password?</a>
      <a href="{{ url('/') }}" class="text-indigo-600 hover:underline flex items-center gap-1">
        ⬅️ Kembali ke Beranda
      </a>
    </div>
  </div>

</body>
</html>
