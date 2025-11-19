<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'App Pegawai')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    .poppins { font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    [x-cloak] { display: none !important; }
    
    html {
      scroll-behavior: smooth;
    }
    
    * {
      transform-style: preserve-3d;
      backface-visibility: hidden;
    }

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
    
    /* Animasi untuk alert */
    .alert-enter {
      opacity: 0;
      transform: translateY(-10px);
    }
    .alert-enter-active {
      opacity: 1;
      transform: translateY(0);
    }
    .alert-exit {
      opacity: 1;
      transform: translateY(0);
    }
    .alert-exit-active {
      opacity: 0;
      transform: translateY(-10px);
    }
  </style>
</head>

<body class="poppins bg-gray-100 text-gray-800" x-data>

  <div class="min-h-screen flex">

    {{-- Sidebar -- hanya tampil jika user sudah login --}}
    @auth
      @include('layouts.sidebar')
    @endauth

    {{-- Main content --}}
    <div class="flex-1 min-h-screen flex flex-col transition-all duration-500 ease-out transform"
         style="will-change: margin-left;">

      {{-- TOPBAR -- hanya tampil jika user sudah login --}}
      @auth
      <header class="sticky top-0 bg-white border-b shadow-sm z-20 transition-all duration-500 ease-out transform"
              style="will-change: margin-left;">
        <div class="px-6 py-4 flex items-center justify-between transition-all duration-500 ease-out">

          {{-- Breadcrumb --}}
          <div class="transition-all duration-500 ease-out transform"
               :class="($store.sidebar?.open || $store.sidebar?.pinned) ? 'translate-x-0' : 'translate-x-2'">
            @php
              $segments = Request::segments();
              $crumbs = [];
              $url = '';
            @endphp

            <nav class="text-sm text-gray-600 transition-all duration-500 ease-out" aria-label="Breadcrumb">
              <ol class="inline-flex items-center space-x-2">
                <li>
                  <a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">Home</a>
                </li>
                @foreach ($segments as $index => $segment)
                  @php
                    $url .= '/' . $segment;
                    $label = ucfirst(str_replace('-', ' ', $segment));
                  @endphp

                  <li class="flex items-center transition-all duration-300">
                    <svg class="w-4 h-4 mx-2 text-gray-400 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    @if ($index + 1 < count($segments))
                      <a href="{{ url($url) }}" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">{{ $label }}</a>
                    @else
                      <span class="text-blue-600 font-semibold transition-colors duration-500">{{ $label }}</span>
                    @endif
                  </li>
                @endforeach
              </ol>
            </nav>

            {{-- Judul halaman --}}
            <h2 class="text-xl font-bold text-gray-800 mt-2 transition-all duration-500 ease-out">
              @yield('title', 'Dashboard')
            </h2>
          </div>

          {{-- User info -- dinamis berdasarkan user yang login --}}
          <div class="flex items-center gap-4 transition-all duration-500 ease-out transform hover:scale-105">
            <div class="text-right mr-2 transition-all duration-500 ease-out">
              <div class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</div>
              <div class="text-xs text-gray-500 transition-colors duration-300 capitalize">
                {{ auth()->user()->role }}
              </div>
            </div>
            <div class="w-12 h-12 rounded-full bg-gradient-to-r 
              @if(auth()->user()->role === 'admin') from-blue-500 to-purple-600
              @elseif(auth()->user()->role === 'staff') from-green-500 to-teal-600
              @else from-gray-500 to-gray-600 @endif
              flex items-center justify-center text-white font-bold shadow-lg transition-all duration-500 ease-out transform hover:rotate-12 hover:shadow-xl">
              {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
          </div>
        </div>
      </header>
      @endauth

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

        @if(session('warning'))
          <div x-data="{ show: true }" x-show="show"
              x-transition
              class="alert alert-warning flex items-center justify-between">
            <div class="flex items-center space-x-2">
              <span>{{ session('warning') }}</span>
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

      {{-- Content --}}
      <main class="flex-1 p-2 transition-all duration-500 ease-out transform"
            :class="($store.sidebar?.open || $store.sidebar?.pinned) ? 'translate-x-0' : 'translate-x-1'">
        @yield('content')
      </main>

      {{-- Footer --}}
      <footer class="bg-white border-t mt-auto transition-all duration-500 ease-out">
        <div class="p-6 text-center text-gray-600 text-sm transition-all duration-500 ease-out">
          <p class="transition-colors duration-300 hover:text-gray-800">
            &copy; {{ date('Y') }} HRISense - HR Management System. All rights reserved.
          </p>
        </div>
      </footer>

    </div>
  </div>

  {{-- Sinkronisasi dengan sidebar --}}
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.store('sidebar', {
        open: false,
        pinned: false
      });
    });
  </script>

</body>
</html>