<!DOCTYPE html>
<html lang="id">
<head>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>@yield('title', 'HRISense - Auth')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Style untuk flash messages */
        .alert {
            padding: 12px 16px;
            margin: 16px;
            border-radius: 8px;
            border-left: 4px solid;
            position: relative;
            transition: all 0.3s ease-out;
        }
        .alert-error {
            background-color: #fef2f2;
            border-color: #dc2626;
            color: #dc2626;
        }
        .alert-success {
            background-color: #f0fdf4;
            border-color: #16a34a;
            color: #16a34a;
        }
        .alert-warning {
            background-color: #fffbeb;
            border-color: #d97706;
            color: #d97706;
        }
        .alert-info {
            background-color: #eff6ff;
            border-color: #2563eb;
            color: #2563eb;
        }

        /* Style untuk tombol mata - bisa di-override di view lain */
        .pw-toggle {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }
        .pw-toggle:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>

    {{-- Stack untuk head scripts --}}
    @stack('styles')
</head>

<body class="bg-gradient-to-br from-indigo-100 to-indigo-300 min-h-screen flex items-center justify-center p-4">

  <div class="bg-white shadow-2xl rounded-2xl w-full max-w-md p-8 space-y-6">

    {{-- Logo + Judul --}}
    <div class="text-center">
      <img src="{{ asset('images/logo-utama.jpg') }}" alt="Logo HRISense"
        class="w-16 h-16 mx-auto rounded-full object-cover mb-4">
      <h1 class="text-3xl font-bold text-indigo-700">@yield('auth_title')</h1>
      <p class="text-gray-500 text-sm mt-2">HR Management System</p>
    </div>

    {{-- Flash Messages --}}
    <div class="space-y-2">
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show"
                x-transition
                class="alert alert-error flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="ml-4 p-1 rounded-full hover:bg-red-200 transition">
                ✕
            </button>
            </div>
        @endif

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show"
                x-transition
                class="alert alert-success flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="ml-4 p-1 rounded-full hover:bg-red-200 transition">
                ✕
            </button>
            </div>
        @endif

        @if(session('status'))
            <div x-data="{ show: true }" x-show="show"
                x-transition
                class="alert alert-warning flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span>{{ session('status') }}</span>
            </div>
            <button @click="show = false" class="ml-4 p-1 rounded-full hover:bg-red-200 transition">
                ✕
            </button>
            </div>
        @endif

        @if(session('info'))
            <div x-data="{ show: true }" x-show="show"
                x-transition
                class="alert alert-info flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span>{{ session('info') }}</span>
            </div>
            <button @click="show = false" class="ml-4 p-1 rounded-full hover:bg-red-200 transition">
                ✕
            </button>
            </div>
        @endif
    </div>

    {{-- Form Section --}}
    @yield('form')

    {{-- Bottom links --}}
    <div class="text-center text-sm text-gray-600 mt-6 pt-4 border-t">
      @yield('bottom_links')
    </div>

  </div>

  {{-- Default scripts untuk auth --}}
  <script>
  // Function untuk toggle password single field (untuk login)
  function togglePassword() {
      const passwordInput = document.getElementById("password");
      const eyeClosed = document.getElementById("eyeClosed");
      const eyeOpen = document.getElementById("eyeOpen");

      if (passwordInput && eyeClosed && eyeOpen) {
          if (passwordInput.type === "password") {
              // Show password
              passwordInput.type = "text";
              eyeClosed.classList.add("hidden");
              eyeOpen.classList.remove("hidden");
          } else {
              // Hide password
              passwordInput.type = "password";
              eyeOpen.classList.add("hidden");
              eyeClosed.classList.remove("hidden");
          }
      }
  }

  // Enter key support untuk semua form
  document.addEventListener('DOMContentLoaded', function() {
      const forms = document.querySelectorAll('form');
      forms.forEach(form => {
          form.addEventListener('keypress', function(e) {
              if (e.key === 'Enter' && e.target.type !== 'textarea') {
                  e.preventDefault();
                  const submitBtn = form.querySelector('button[type="submit"]');
                  if (submitBtn) {
                      submitBtn.click();
                  }
              }
          });
      });
  });
  </script>

  {{-- Stack untuk additional scripts dari view --}}
  @stack('scripts')

</body>
</html>