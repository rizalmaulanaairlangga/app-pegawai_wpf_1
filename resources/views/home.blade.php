<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HRISense - HR Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Poppins', sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #2563eb, #9333ea); }

    .gradient-bg {
        background: linear-gradient(90deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%);
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- HEADER -->
    <header class="gradient-bg text-white py-4 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 flex justify-between items-center">

            <!-- LOGO + NAMA -->
            <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-utama.jpg') }}" 
                alt="Logo HRISense" 
                class="w-10 h-10 rounded-lg object-cover shadow-md transition-transform duration-500 hover:rotate-6 hover:scale-110" />
            <h1 class="text-2xl md:text-3xl font-bold tracking-wide">
                HRISense
            </h1>
            </div>

            <!-- NAVIGATION -->
            <nav class="space-x-4 md:space-x-6 text-sm md:text-base flex items-center">
            <a href="#features" class="hover:text-yellow-300 transition-colors duration-300">Fitur</a>
            <a href="#about" class="hover:text-yellow-300 transition-colors duration-300">Tentang</a>
            <a href="#contact" class="hover:text-yellow-300 transition-colors duration-300">Kontak</a>

            <!-- Tombol Aksi -->
            @if(session('user'))
                <a href="{{ url('/dashboard') }}" 
                class="ml-4 bg-white text-indigo-700 font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                Masuk ke Dashboard
                </a>
            @else
                <a href="{{ url('/login') }}" 
                class="ml-4 bg-white text-indigo-700 font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                Mulai Sekarang
                </a>
            @endif
            </nav>

        </div>
    </header>

  <!-- HERO SECTION -->
  <section class="flex flex-col md:flex-row items-center justify-between container mx-auto px-6 py-20">
    <div class="md:w-1/2 mb-10 md:mb-0 text-center md:text-left">
      <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
        Kelola SDM Perusahaan Anda <br>
        Dengan <span class="text-indigo-600">HRISense</span>
      </h2>
      <p class="text-gray-600 mb-8 text-lg">
        Platform HRIS modern untuk mengelola kehadiran, absensi, cuti, dan penggajian dalam satu sistem terintegrasi.
      </p>
      @if(session('user'))
        <a href="{{ url('/dashboard') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition transform hover:-translate-y-1">
          Masuk ke Dashboard
        </a>
      @else
        <a href="{{ url('/login') }}" 
        class="relative z-10 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg
                transition-all duration-300 ease-out transform hover:-translate-y-1 hover:scale-105 hover:shadow-xl">
        Mulai Sekarang
        </a>
      @endif
    </div>

    <!-- GAMBAR HERO -->
    <div class="md:w-1/2 flex justify-center">
      <img src="/images/home-head-section.jpg" alt="Ilustrasi HR Management"
           class="w-4/5 md:w-full drop-shadow-xl rounded-xl">
    </div>
  </section>

    <!-- FITUR -->
    <section id="features" class="relative bg-white py-32 overflow-hidden">

    <!-- Gambar latar lebar penuh -->
    <div class="absolute inset-0">
        <img src="/images/home-hero-section.jpg" 
            alt="Ilustrasi HRISense"
            class="w-full h-[420px] object-cover object-center">
        <!-- 💡 Gambar saran: ilustrasi tim HR bekerja, layar dashboard HRIS, atau kantor modern -->
        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/70 to-transparent"></div>
    </div>

    <!-- Konten -->
    <div class="relative container mx-auto px-6 text-center">
        <h3 class="text-3xl md:text-4xl font-bold mb-16 text-gray-900">
        Fitur Unggulan <span class="text-indigo-600">HRISense</span>
        </h3>

        <!-- GRID FITUR -->
        <div class="grid md:grid-cols-3 gap-10 relative z-10">

        <!-- Fitur 1 -->
        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-indigo-500">
            <img src="/images/home-fitur-absensi.jpeg" alt="Fitur Kehadiran"
                class="w-full h-48 object-cover rounded-xl mb-5">
            <h4 class="text-xl font-semibold mb-3 text-gray-800">Manajemen Kehadiran</h4>
            <p class="text-gray-600">Pantau dan kelola absensi karyawan secara real-time dengan sistem digital yang akurat.</p>
        </div>

        <!-- Fitur 2 -->
        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-green-500">
            <img src="/images/home-fitur-hitung-gaji.jpg" alt="Fitur Payroll"
                class="w-full h-48 object-cover rounded-xl mb-5">
            <h4 class="text-xl font-semibold mb-3 text-gray-800">Penggajian Otomatis</h4>
            <p class="text-gray-600">Hitung gaji, lembur, dan potongan otomatis, terintegrasi langsung dengan data absensi.</p>
        </div>

        <!-- Fitur 3 -->
        <div class="bg-white shadow-lg rounded-2xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-yellow-500">
            <img src="/images/home-fitur-cuti.jpg" alt="Fitur Cuti"
                class="w-full h-48 object-cover rounded-xl mb-5">
            <h4 class="text-xl font-semibold mb-3 text-gray-800">Manajemen Cuti</h4>
            <p class="text-gray-600">Ajukan, setujui, dan catat cuti dengan sistem persetujuan yang transparan dan mudah.</p>
        </div>

        </div>
    </div>
    </section>

  <!-- TENTANG -->
  <section id="about" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center gap-10">
      <div class="md:w-1/2">
        <img src="/images/home-about.jpg" alt="Tentang HRISense"
             class="rounded-2xl shadow-lg">
      </div>
      <div class="md:w-1/2">
        <h3 class="text-3xl font-bold mb-4">Tentang HRISense</h3>
        <p class="text-gray-600 mb-4">
          HRISense dikembangkan untuk membantu perusahaan mengelola sumber daya manusia secara efisien.
          Dengan tampilan sederhana dan sistem aman, HRISense cocok untuk berbagai skala bisnis.
        </p>
        <p class="text-gray-600">
          Kami percaya manajemen SDM yang baik dimulai dari data yang akurat dan mudah diakses oleh semua pihak.
        </p>
      </div>
    </div>
  </section>

  <!-- KONTAK -->
  <section id="contact" class="py-20 bg-white">
    <div class="container mx-auto px-6 text-center max-w-2xl">
      <h3 class="text-3xl font-bold mb-6">Hubungi Kami</h3>
      <p class="text-gray-600 mb-8">Ingin tahu lebih banyak tentang HRISense atau melakukan demo sistem?</p>
      <a href="mailto:support@hrisense.com" 
         class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
        Email: support@hrisense.com
      </a>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-gray-400 py-8 text-center text-sm">
    <p>&copy; {{ date('Y') }} <span class="font-semibold text-white">HRISense</span> - HR Management System</p>
    <p class="mt-1 text-gray-500">Made with ❤️ for better human resource management</p>
  </footer>

</body>
</html>
