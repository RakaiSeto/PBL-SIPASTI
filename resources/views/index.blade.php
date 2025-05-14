<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIPASTI - Laporan Sarana Kampus</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- AOS untuk animasi -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <!-- Font Poppins -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Warna utama dengan gradient */
    :root {
      --primary: #1e40af;
      --primary-hover: #1e3a8a;
      --light-blue: #e0f2fe;
      --gradient-bg: linear-gradient(135deg, #1e40af, #3b82f6);
    }

    body {
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
      background: #f9fafb;
    }

    /* Gaya hamburger untuk mobile */
    .hamburger {
      display: none;
      flex-direction: column;
      gap: 6px;
      width: 28px;
      cursor: pointer;
      z-index: 50;
    }

    .hamburger span {
      height: 4px;
      background: var(--primary);
      border-radius: 2px;
      transition: all 0.3s ease;
    }

    .hamburger.active span:nth-child(1) {
      transform: rotate(45deg) translate(6px, 6px);
    }

    .hamburger.active span:nth-child(2) {
      opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
      transform: rotate(-45deg) translate(6px, -6px);
    }

    /* Menu mobile */
    .mobile-menu {
      display: none;
      transform: translateY(-20px);
      opacity: 0;
      transition: all 0.4s ease;
    }

    .mobile-menu.active {
      display: flex;
      flex-direction: column;
      position: absolute;
      top: 72px;
      left: 0;
      width: 100%;
      background: white;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transform: translateY(0);
      opacity: 1;
      z-index: 40;
    }

    .mobile-menu a,
    .mobile-menu button {
      padding: 0.75rem;
      text-align: center;
      font-weight: 500;
      color: #4b5563;
      transition: color 0.3s ease, background 0.3s ease;
    }

    .mobile-menu a:hover,
    .mobile-menu button:hover {
      color: var(--primary);
      background: var(--light-blue);
      border-radius: 6px;
    }

    /* Enhanced button styles */
    button,
    .btn {
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    button::after,
    .btn::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s ease, height 0.4s ease;
    }

    button:hover::after,
    .btn:hover::after {
      width: 200px;
      height: 200px;
    }

    /* Card hover effects */
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    /* Media Queries */
    @media (max-width: 768px) {
      .hamburger {
        display: flex;
      }

      .desktop-menu {
        display: none;
      }
    }
  </style>

  @vite('resources/css/app.css', 'resources/js/app.js')
</head>

<body class="bg-white text-gray-900" onload="AOS.init({ duration: 800, easing: 'ease-in-out', once: true })">
  <!-- Navbar -->
  <nav id="navbar" class="bg-[var(--light-blue)] sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <!-- KIRI: Logo -->
      <div class="flex items-center gap-3 flex-shrink-0" data-aos="fade-right">
        <img src="assets/image/LOGO.svg" alt="Logo SIPASTI"
          class="w-10 h-10 transform hover:scale-110 transition-transform">
        <h1 class="text-2xl font-bold text-[var(--primary)]">SIPASTI</h1>
      </div>
      <!-- TENGAH: Menu navigasi desktop -->
      <div class="hidden md:flex desktop-menu space-x-8 text-base font-medium justify-center flex-1"
        data-aos="fade-down">
        <a href="#beranda" class="text-gray-600 hover:text-[var(--primary)] transition-colors duration-200">Beranda</a>
        <a href="#layanan" class="text-gray-600 hover:text-[var(--primary)] transition-colors duration-200">Layanan</a>
        <a href="#tentang" class="text-gray-600 hover:text-[var(--primary)] transition-colors duration-200">Tentang</a>
        <a href="#kontak" class="text-gray-600 hover:text-[var(--primary)] transition-colors duration-200">Kontak</a>
      </div>
      <!-- KANAN: Login/Register -->
      <div class="hidden md:flex items-center space-x-4 flex-shrink-0" data-aos="fade-left">
<<<<<<< HEAD
        <a href="{{ route('login') }}" class="text-sm font-medium text-[var(--primary)] hover:bg-[var(--light-blue)] px-3 py-1 rounded transition-colors">Login</a>
        {{-- <button class="text-sm font-medium text-[var(--primary)] hover:bg-[var(--light-blue)] px-3 py-1 rounded transition-colors">Login</button> --}}
        <button class="bg-[var(--primary)] text-white px-5 py-2 text-sm font-medium rounded-lg hover:bg-[var(--primary-hover)] btn">Register</button>
=======
      @if (Auth::check() == true)
      @include('component.profile')
      @else
        <a href="{{ route('login') }}"
          class="w-[6.5rem] text-sm font-medium border border-[var(--primary)] text-[var(--primary)] hover:bg-[var(--primary)] hover:text-white px-5 text-center py-2 rounded-lg transition-colors">Login</a>
        <a href="{{ route('register') }}"
          class="w-[6.5rem] bg-[var(--primary)] border border-[var(--primary)] text-white px-5 text-center py-2 text-sm font-medium rounded-lg hover:bg-[var(--primary-hover)] btn">Register</a>
      @endif
>>>>>>> d50ea04c5749843a85e821600e68ab8109759b10
      </div>
      <!-- HAMBURGER (mobile only) -->
      <div class="md:hidden hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <!-- MENU MOBILE -->
    <div class="mobile-menu md:hidden px-4 pb-4 space-y-2">
      <a href="#beranda" class="block">Beranda</a>
      <a href="#layanan" class="block">Layanan</a>
      <a href="#tentang" class="block">Tentang</a>
      <a href="#kontak" class="block">Kontak</a>
      @if (Auth::check() == true)
      {{-- @dd(Auth::user()) --}}
      <div class="relative">
      <button id="profileToggle" class="flex items-center focus:outline-none">
        <span class="mr-2 font-medium">Nama Pengguna</span>
        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-10 h-10 rounded-full border"
        alt="Profile" />
      </button>

      <!-- Dropdown menu -->
      <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-md py-2 z-50 hidden">
        <button onclick="openModal()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Ganti Profil
        </button>
        <a href="#" onclick="openModal()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ganti
        Password</a>
        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
      </div>
      </div>
    @else
      <button class="block text-sm text-[var(--primary)]">Login</button>
      <button
      class="block w-full bg-[var(--primary)] text-white px-4 py-2 text-sm rounded-lg hover:bg-[var(--primary-hover)] btn">Register</button>
    @endif
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="beranda" class="bg-gradient-to-r from-[var(--light-blue)] to-blue-100 py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-12">
      <!-- Teks -->
      <div class="md:w-1/2" data-aos="fade-right" data-aos-delay="200">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-snug text-gray-800">
          Sistem Pelaporan Sarana dan Prasarana<br>JTI - Polinema
        </h1>
        <p class="text-base md:text-lg text-gray-600 mb-8">
          Laporkan kerusakan fasilitas kampus dengan mudah dan cepat melalui platform terpadu yang mendorong kolaborasi
          untuk lingkungan kampus yang lebih baik.
        </p>
        <button
          class="bg-[var(--primary)] text-white px-6 py-3 rounded-lg font-medium hover:bg-[var(--primary-hover)] btn">
          Laporkan Kerusakan
        </button>
      </div>
      <!-- Gambar -->
      <div class="md:w-1/2" data-aos="zoom-in" data-aos-delay="400">
        <img src="assets/image/4.png" alt="Ilustrasi Laporan"
          class="w-full transform hover:scale-105 transition-transform">
      </div>
    </div>
  </section>

  <section class="relative bg-gradient-to-r from-blue-50 to-blue-100 py-20">
  <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-12">
    <!-- Teks -->
    <div class="md:w-1/2" data-aos="fade-right" data-aos-delay="200">
      <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-snug text-gray-800">
        Sistem Pelaporan Sarana dan Prasarana<br>JTI - Polinema
      </h1>
      <p class="text-base md:text-lg text-gray-600 mb-8">
        Laporkan kerusakan fasilitas kampus dengan mudah dan cepat melalui platform terpadu yang mendorong kolaborasi untuk lingkungan kampus yang lebih baik.
      </p>
      <a href="#" class="bg-[var(--primary)] text-white px-6 py-3 rounded-lg font-medium hover:bg-[var(--primary-hover)] btn">
        Laporkan Kerusakan
      </a>
    </div>
    <!-- Gambar -->
    <div class="md:w-1/2" data-aos="zoom-in" data-aos-delay="400">
      <img src="assets/image/4.png" alt="Ilustrasi Laporan" class="w-full transform hover:scale-105 transition-transform">
    </div>
  </div>
</section>


  <!-- About Section -->
  <section id="tentang" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-12">
      <!-- Gambar -->
      <div class="md:w-1/2" data-aos="zoom-in-up">
        <img src="assets/image/5.jpg" alt="Tim Kami" class="w-full rounded-2xl shadow-xl card">
      </div>
      <!-- Teks -->
      <div class="md:w-1/2" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
          Tentang <span class="text-[var(--primary)]">SIPASTI</span>
        </h2>
        <p class="text-base text-gray-600 mb-8">
          <strong>Perbaikan kampus jadi mudah!</strong><br><br>
          SIPASTI adalah platform inovatif untuk melaporkan kerusakan di kampus, diciptakan oleh tim Polinema untuk
          menciptakan lingkungan belajar yang lebih nyaman dan efisien.
        </p>
        <button
          class="bg-[var(--primary)] text-white px-6 py-3 rounded-lg font-medium hover:bg-[var(--primary-hover)] btn">
          Pelajari Lebih Lanjut
        </button>
        <!-- Statistik -->
        <div class="mt-8 grid grid-cols-3 gap-6">
          <div data-aos="fade-up" data-aos-delay="300">
            <p class="text-3xl font-bold text-[var(--primary)]">50+</p>
            <p class="text-sm text-gray-600">Laporan Selesai</p>
          </div>
          <div data-aos="fade-up" data-aos-delay="400">
            <p class="text-3xl font-bold text-[var(--primary)]">24+</p>
            <p class="text-sm text-gray-600">Instansi</p>
          </div>
          <div data-aos="fade-up" data-aos-delay="500">
            <p class="text-3xl font-bold text-[var(--primary)]">30+</p>
            <p class="text-sm text-gray-600">Kontributor</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->

  <section id="layanan" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6" data-aos="fade-up">Layanan Kami</h2>
      <p class="text-base text-gray-600 mb-12" data-aos="fade-up" data-aos-delay="100">
        Fitur unggulan untuk pelaporan yang cepat dan efisien.
      </p>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

        <!-- Layanan 1 -->
        <div class="bg-white p-6 rounded-xl shadow-lg card" data-aos="flip-up">
          <i class="fa fa-check-circle text-[var(--primary)] text-3xl mb-4"></i>
          <h3 class="text-xl font-bold text-[var(--primary)] mb-3">Mudah</h3>
          <p class="text-base text-gray-600">Antarmuka intuitif memungkinkan pelaporan tanpa pelatihan teknis.</p>
        </div>

        <!-- Layanan 2 -->
        <div class="bg-white p-6 rounded-xl shadow-lg card" data-aos="flip-up" data-aos-delay="100">
          <i class="fa fa-bolt text-[var(--primary)] text-3xl mb-4"></i>
          <h3 class="text-xl font-bold text-[var(--primary)] mb-3">Cepat</h3>
          <p class="text-base text-gray-600">Laporan langsung diteruskan ke unit terkait untuk penanganan cepat.</p>
        </div>

        <!-- Layanan 3 -->
        <div class="bg-white p-6 rounded-xl shadow-lg card" data-aos="flip-up" data-aos-delay="200">
          <i class="fa fa-eye text-[var(--primary)] text-3xl mb-4"></i>
          <h3 class="text-xl font-bold text-[var(--primary)] mb-3">Transparan</h3>
          <p class="text-base text-gray-600">Pantau status laporan secara real-time untuk kepercayaan maksimal.</p>
        </div>

        <!-- Layanan 4 -->
        <div class="bg-white p-6 rounded-xl shadow-lg card" data-aos="flip-up" data-aos-delay="300">
          <i class="fa fa-plug text-[var(--primary)] text-3xl mb-4"></i>
          <h3 class="text-xl font-bold text-[var(--primary)] mb-3">Terintegrasi</h3>
          <p class="text-base text-gray-600">Terhubung dengan sistem kampus untuk efisiensi maksimal.</p>
        </div>

      </div>
    </div>
  </section>

  <section id="cara-kerja" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid md:grid-cols-2 gap-10 items-center">

        <!-- Kiri: Judul + Kotak-kotak langkah -->
        <div>
          <!-- Judul dipindah ke sini agar sejajar dengan gambar -->
          <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 md:mb-12 text-right" data-aos="fade-up">
            Cara Kerja <span class="text-[var(--primary)]">SIPASTI</span>
          </h2>

          <!-- Grid kotak langkah 2x2 -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            <!-- Step 1 -->
            <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-[var(--primary)]" data-aos="zoom-in">
              <div class="flex items-center mb-2">
                <i class="fa fa-file-alt text-[var(--primary)] text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-[var(--primary)]">1. Buat Laporan</h3>
              </div>
              <p class="text-sm text-gray-600">Isi detail kerusakan, lokasi, dan unggah bukti foto.</p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-[var(--primary)]" data-aos="zoom-in"
              data-aos-delay="100">
              <div class="flex items-center mb-2">
                <i class="fa fa-check-circle text-[var(--primary)] text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-[var(--primary)]">2. Verifikasi</h3>
              </div>
              <p class="text-sm text-gray-600">Tim memverifikasi laporan dengan cepat.</p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-[var(--primary)]" data-aos="zoom-in"
              data-aos-delay="200">
              <div class="flex items-center mb-2">
                <i class="fa fa-tools text-[var(--primary)] text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-[var(--primary)]">3. Tindak Lanjut</h3>
              </div>
              <p class="text-sm text-gray-600">Laporan diteruskan ke tim sarpras.</p>
            </div>

            <!-- Step 4 -->
            <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-[var(--primary)]" data-aos="zoom-in"
              data-aos-delay="300">
              <div class="flex items-center mb-2">
                <i class="fa fa-bell text-[var(--primary)] text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-[var(--primary)]">4. Selesai</h3>
              </div>
              <p class="text-sm text-gray-600">Notifikasi dikirim saat selesai.</p>
            </div>

          </div>
        </div>

        <!-- Kanan: Gambar -->
        <div data-aos="fade-left">
          <img src="{{ asset('assets/image/3.jpg') }}" alt="Ilustrasi Cara Kerja SIPASTI"
            class="w-full rounded-xl shadow-lg" />
        </div>

      </div>
    </div>
  </section>

  <!-- Testimoni Section -->
  <section id="testimoni" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6" data-aos="fade-up">Apa Kata Mereka?</h2>
      <p class="text-base text-gray-600 mb-12" data-aos="fade-up" data-aos-delay="100">
        Pengguna SIPASTI berbagi pengalaman mereka
      </p>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Testimoni 1 -->
        <div class="bg-white p-6 rounded-xl shadow-lg card" data-aos="fade-up">
          <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Testimoni Mahasiswa"
              class="w-16 h-16 rounded-full object-cover mr-4">
            <div>
              <h4 class="font-semibold text-gray-800 text-base">Rina</h4>
              <p class="text-sm text-gray-500">Mahasiswa TI</p>
            </div>
          </div>
          <p class="text-gray-700 text-sm italic">"Lapor fasilitas rusak jadi super cepat! Gak perlu datang ke TU, cukup
            isi form dan langsung ditindak!"</p>
        </div>
        <!-- Testimoni 2 -->
        <div class="bg-white p-6 rounded-xl shadow-lg card" data-aos="fade-up" data-aos-delay="100">
          <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Testimoni Dosen"
              class="w-16 h-16 rounded-full object-cover mr-4">
            <div>
              <h4 class="font-semibold text-gray-800 text-base">Pak Andi</h4>
              <p class="text-sm text-gray-500">Dosen JTI</p>
            </div>
          </div>
          <p class="text-gray-700 text-sm italic">"Sebagai dosen, saya bisa langsung pantau laporan di kelas. Transparan
            dan respons cepat."</p>
        </div>
        <!-- Testimoni 3 -->
        <div class="bg-white p-6 rounded-xl shadow-lg card" data-aos="fade-up" data-aos-delay="200">
          <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Testimoni Tendik"
              class="w-16 h-16 rounded-full object-cover mr-4">
            <div>
              <h4 class="font-semibold text-gray-800 text-base">Bu Sari</h4>
              <p class="text-sm text-gray-500">Staf Sarpras</p>
            </div>
          </div>
          <p class="text-gray-700 text-sm italic">"Dengan SIPASTI, laporan masuk langsung ke sistem kami. Memudahkan tim
            maintenance mengatur prioritas kerja."</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="kontak" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-12">
      <!-- Gambar -->
      <div class="md:w-1/2" data-aos="fade-left">
        <img src="{{ asset('assets/image/2.png') }}" alt="Tim Kerja" class="w-full card rounded-xl shadow">
      </div>
      <!-- Formulir -->
      <div class="md:w-1/2" data-aos="fade-right">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Hubungi Kami</h2>
        <p class="text-base text-gray-600 mb-4">Kirim pesan untuk pertanyaan atau saran!</p>
        <div class="space-y-2">
          <input type="text" placeholder="Nama"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary)] transition-shadow">
          <input type="email" placeholder="Email"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary)] transition-shadow">
          <textarea placeholder="Pesan"
            class="w-full p-2 border rounded-lg h-28 focus:outline-none focus:ring-2 focus:ring-[var(--primary)] transition-shadow"></textarea>
          <button
            class="bg-[var(--primary)] text-white px-6 py-2 rounded-lg font-medium hover:bg-[var(--primary-hover)] btn">Kirim</button>
        </div>
      </div>

    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12" data-aos="fade-up">Pertanyaan Umum</h2>
      <div class="space-y-2">
        <!-- FAQ 1 -->
        <div class="border rounded-xl bg-white shadow-sm" data-aos="fade-up">
          <button class="w-full flex justify-between items-center p-5 text-left font-semibold text-gray-800 toggle-faq">
            Apakah semua mahasiswa bisa melapor?
            <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="faq-content px-5 pb-5 hidden text-base text-gray-600">
            Ya, semua mahasiswa dengan akun aktif bisa melapor.
          </div>
        </div>
        <!-- FAQ 2 -->
        <div class="border rounded-xl bg-white shadow-sm" data-aos="fade-up" data-aos-delay="100">
          <button class="w-full flex justify-between items-center p-5 text-left font-semibold text-gray-800 toggle-faq">
            Berapa lama laporan diproses?
            <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="faq-content px-5 pb-5 hidden text-base text-gray-600">
            Biasanya 1x24 jam untuk verifikasi dan tindak lanjut.
          </div>
        </div>
        <!-- FAQ 3 -->
        <div class="border rounded-xl bg-white shadow-sm" data-aos="fade-up" data-aos-delay="200">
          <button class="w-full flex justify-between items-center p-5 text-left font-semibold text-gray-800 toggle-faq">
            Apakah laporan saya rahasia?
            <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="faq-content px-5 pb-5 hidden text-base text-gray-600">
            Ya, laporan hanya untuk petugas dan pelapor.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[var(--primary)] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Tentang -->
      <div data-aos="fade-up">
        <img src="{{asset('assets/image/sipasti.svg')}}" alt="Logo SIPASTI" class="h-10 mb-4">
        <p class="text-sm">
          SIPASTI untuk laporan kerusakan kampus yang mudah dan efisien.
        </p>
      </div>
      <!-- Kontak -->
      <div data-aos="fade-up" data-aos-delay="100">
        <h4 class="text-lg font-semibold mb-4">Kontak Kami</h4>
        <p class="text-sm">Jl. Soekarno Hatta No. 190, Malang</p>
        <p class="text-sm">sipasti@polinema.ac.id</p>
        <p class="text-sm">+62 822-9384-0090</p>
      </div>
      <!-- Newsletter -->
      <div data-aos="fade-up" data-aos-delay="200">
        <h4 class="text-lg font-semibold mb-4">Newsletter</h4>
        <p class="text-sm mb-4">Dapatkan info terbaru.</p>
        <div class="flex">
          <input type="email" placeholder="Email"
            class="p-3 rounded-l-lg text-sm w-full text-gray-800 focus:outline-none">
          <button class="bg-[var(--primary-hover)] text-white p-3 rounded-r-lg hover:bg-blue-800 btn">Kirim</button>
        </div>
      </div>
    </div>
    <hr class="my-8 border-gray-400">
    <p class="text-center text-sm">
      © 2025 SIPASTI | Dibuat oleh Tim JTI Polinema
    </p>
  </footer>

  <!-- JavaScript -->
  <script>
    // Hamburger menu
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });

    // FAQ accordion
    document.querySelectorAll('.toggle-faq').forEach(button => {
      button.addEventListener('click', () => {
        const content = button.nextElementSibling;
        const icon = button.querySelector('svg');
        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
      });
    });

    // Navbar scroll effect
    const navbar = document.getElementById("navbar");
    window.addEventListener("scroll", () => {
      if (window.scrollY > 0) {
        navbar.classList.add("bg-white", "shadow-lg");
        navbar.classList.remove("bg-[var(--light-blue)]");
      } else {
        navbar.classList.remove("bg-white", "shadow-lg");
        navbar.classList.add("bg-[var(--light-blue)]");
      }
    });
  </script>
</body>

</html>
