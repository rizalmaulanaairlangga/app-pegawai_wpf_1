{{-- resources/views/layouts/sidebar.blade.php --}}
<aside
  x-data="{}"
  @mouseenter="if (!$store.sidebar.pinned) { $store.sidebar.open = true }"
  @mouseleave="if (!$store.sidebar.pinned) { $store.sidebar.open = false }"
  class="sticky top-0 left-0 h-screen z-30 bg-white shadow-xl transition-all duration-500 ease-out"
  :class="{
    'w-64': $store.sidebar.open || $store.sidebar.pinned,
    'w-16': !($store.sidebar.open || $store.sidebar.pinned)
  }"
  style="will-change: transform, width;"
>
  <div class="h-full bg-white flex flex-col"
       :class="{
         'translate-x-0': $store.sidebar.open || $store.sidebar.pinned,
         '-translate-x-2': !($store.sidebar.open || $store.sidebar.pinned)
       }">
    
    {{-- Logo dan pin --}}
    <div class="flex items-center justify-between px-3 h-16 border-b transition-all duration-500 ease-out">
      <a href="{{ url('/') }}" 
        class="flex items-center transition-all duration-500 ease-out transform"
        :class="($store.sidebar.open || $store.sidebar.pinned) ? 'gap-3 justify-start scale-100' : 'justify-center w-full scale-90'">
        <img src="{{ asset('images/logo-utama.jpg') }}" 
            alt="Logo HRISense" 
            class="w-8 h-8 rounded object-cover transition-all duration-500 ease-out"
            :class="($store.sidebar.open || $store.sidebar.pinned) ? 'scale-100' : 'scale-110'">
        <span x-show="$store.sidebar.open || $store.sidebar.pinned" 
              x-transition:enter="transition-all duration-500 ease-out delay-100"
              x-transition:enter-start="opacity-0 transform -translate-x-4"
              x-transition:enter-end="opacity-100 transform translate-x-0"
              x-transition:leave="transition-all duration-300 ease-in"
              x-transition:leave-start="opacity-100 transform translate-x-0"
              x-transition:leave-end="opacity-0 transform -translate-x-4"
              class="font-semibold text-gray-800 whitespace-nowrap">
          <span class="text-blue-500 transition-colors duration-500">HR</span>ISense
        </span>
      </a>

      {{-- Tombol Pin --}}
      <button
        @click="$store.sidebar.pinned = !$store.sidebar.pinned"
        :class="$store.sidebar.pinned ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-700'"
        class="p-2 rounded-lg transition-all duration-500 ease-out transform hover:scale-110 hover:bg-gray-100 active:scale-95"
        title="Pin sidebar"
        x-show="$store.sidebar.open || $store.sidebar.pinned"
        x-transition:enter="transition-all duration-500 ease-out delay-150"
        x-transition:enter-start="opacity-0 transform scale-50"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition-all duration-300 ease-in"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-50"
      >
        <svg xmlns="http://www.w3.org/2000/svg" 
            :class="$store.sidebar.pinned ? 'rotate-45' : ''" 
            class="w-4 h-4 transition-all duration-500 ease-out" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
    </div>

    {{-- Menu -- Scrollable --}}
    <nav class="flex-1 overflow-y-auto mt-4 transition-all duration-500 ease-out">
      @php
        function active($pattern){
          return request()->is($pattern) ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900';
        }
      @endphp

      <ul class="px-3 space-y-2 transition-all duration-500 ease-out">
        @foreach ([
          ['url' => 'departments', 'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z', 'label' => 'Departments'],
          ['url' => 'employees',  'icon' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z', 'label' => 'Employees'],
          ['url' => 'positions',  'icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z', 'label' => 'Positions'],
          ['url' => 'attendances', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z', 'label' => 'Attendance'],
          ['url' => 'salaries',   'icon' => 'M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z', 'label' => 'Salaries'],
          ['url' => 'settings',   'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z', 'label' => 'Settings'],
        ] as $menu)
          <li class="transition-all duration-500 ease-out transform"
              :class="($store.sidebar.open || $store.sidebar.pinned) ? 'translate-x-0' : 'translate-x-1'">
            <a href="{{ url($menu['url']) }}" 
               class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-500 ease-out transform hover:scale-[1.02] active:scale-[0.98] group {{ active($menu['url'].'*') }}">
              <span class="w-6 flex justify-center transition-all duration-500 ease-out transform"
                    :class="($store.sidebar.open || $store.sidebar.pinned) ? 'scale-100' : 'scale-110'">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-5 h-5 transition-all duration-500 ease-out group-hover:scale-110" 
                     fill="none" 
                     viewBox="0 0 24 24" 
                     stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}" />
                </svg>
              </span>
              <span x-show="$store.sidebar.open || $store.sidebar.pinned" 
                    x-transition:enter="transition-all duration-500 ease-out"
                    x-transition:enter-start="opacity-0 transform -translate-x-6"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition-all duration-300 ease-in"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-6"
                    class="font-medium whitespace-nowrap transition-all duration-500 ease-out">
                {{ $menu['label'] }}
              </span>
            </a>
          </li>
        @endforeach
      </ul>
    </nav>

    {{-- Footer kecil di bawah --}}
    <div class="px-3 py-4 border-t transition-all duration-500 ease-out">
      <div x-show="$store.sidebar.open || $store.sidebar.pinned"
           x-transition:enter="transition-all duration-500 ease-out delay-200"
           x-transition:enter-start="opacity-0 transform translate-y-4"
           x-transition:enter-end="opacity-100 transform translate-y-0"
           x-transition:leave="transition-all duration-300 ease-in"
           x-transition:leave-start="opacity-100 transform translate-y-0"
           x-transition:leave-end="opacity-0 transform translate-y-4"
           class="text-xs text-gray-500 text-center">
        v1.0.0
      </div>
    </div>
  </div>
</aside>