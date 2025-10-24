@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'App Pegawai')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body class="poppins-regular bg-gray-100 text-gray-800">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Judul Halaman -->
            <h1 class="text-2xl font-bold text-gray-800">
                @yield('page-title', 'App Pegawai')
            </h1>

            <!-- Navigasi -->
            <nav>
                <ul class="flex space-x-6">
                    <li>    
                        <a href="{{ url('/employees') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                            Employee
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/department') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                            Department
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/attendance') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                            Attendance
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/report') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                            Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/settings') }}"
                        class="text-gray-700 hover:text-blue-600 font-medium transition">
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

<footer class="bg-gray-100 border-t mt-8">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600 text-sm">
        <p>&copy; {{ date('Y') }} App Pegawai. All rights reserved.</p>
    </div>
    </footer>
</body>
</html>