<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'App Pegawai')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    .poppins { font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    [x-cloak] { display: none !important; }
    
    /* Smooth scrolling dan optimasi performa */
    html {
      scroll-behavior: smooth;
    }
    
    /* Optimasi untuk animasi */
    * {
      transform-style: preserve-3d;
      backface-visibility: hidden;
    }
  </style>
</head>

<body class="poppins bg-gray-100 text-gray-800" x-data>

  <div class="min-h-screen flex">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Main content --}}
    <div class="flex-1 min-h-screen flex flex-col transition-all duration-500 ease-out transform"
         style="will-change: margin-left;">

      {{-- TOPBAR --}}
      <header class="sticky top-0 bg-white border-b shadow-sm z-20 transition-all duration-500 ease-out transform"
              style="will-change: margin-left;">
        <div class="px-6 py-4 flex items-center justify-between transition-all duration-500 ease-out">

          {{-- Breadcrumb --}}
          <div class="transition-all duration-500 ease-out transform"
               :class="($store.sidebar.open || $store.sidebar.pinned) ? 'translate-x-0' : 'translate-x-2'">
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

          {{-- User info --}}
          <div class="flex items-center gap-4 transition-all duration-500 ease-out transform hover:scale-105">
            <div class="text-right mr-2 transition-all duration-500 ease-out">
              <div class="text-sm font-medium text-gray-800">Rizal Maulana</div>
              <div class="text-xs text-gray-500 transition-colors duration-300">Administrator</div>
            </div>
            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg transition-all duration-500 ease-out transform hover:rotate-12 hover:shadow-xl">
              RM
            </div>
          </div>
        </div>
      </header>

      {{-- Content --}}
      <main class="flex-1 p-2 transition-all duration-500 ease-out transform"
            :class="($store.sidebar.open || $store.sidebar.pinned) ? 'translate-x-0' : 'translate-x-1'">
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