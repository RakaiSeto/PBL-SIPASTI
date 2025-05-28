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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        /* Button ripple effect */
        /* .btn-ripple {
            position: relative;
            overflow: hidden;
        }

        .btn-ripple::after {
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

        .btn-ripple:hover::after {
            width: 200px;
            height: 200px;
        } */

        #logoScroll {
            animation: scroll-left 40s linear infinite;
        }

        @keyframes scroll-left {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900" onload="AOS.init({ duration: 800, easing: 'ease-in-out', once: true })">
    <!-- Navbar -->
    <nav id="navbar" class="sticky top-0 z-50 transition-all duration-300"
        style="background: radial-gradient(circle at right center, #ebf8ff, #bfdbfe);">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- KIRI: Logo -->
            <div class="flex items-center gap-3 flex-shrink-0" data-aos="fade-right">
                <img src="{{ asset('assets/image/LOGO.svg') }}" alt="Logo SIPASTI"
                    class="w-10 h-10 hover:scale-110 transition-transform">
                <h1 class="text-2xl font-bold text-blue-800">SIPASTI</h1>
            </div>
            <!-- TENGAH: Menu navigasi desktop -->
            <div class="hidden md:flex space-x-8 text-base font-medium justify-center flex-1" data-aos="fade-down">
                <a href="#beranda" class="text-gray-600 hover:text-blue-800 transition-colors">Beranda</a>
                <a href="#layanan" class="text-gray-600 hover:text-blue-800 transition-colors">Layanan</a>
                <a href="#tentang" class="text-gray-600 hover:text-blue-800 transition-colors">Tentang</a>
                <a href="#kontak" class="text-gray-600 hover:text-blue-800 transition-colors">Kontak</a>
            </div>
            <!-- KANAN: Login/Register -->
            <div class="hidden md:flex items-center space-x-4 flex-shrink-0" data-aos="fade-left">
                @if (Auth::check())
                    @include('component.profile')
                @else
                    <a href="{{ route('login') }}"
                        class="w-26 text-sm font-medium border border-blue-800 text-blue-800 hover:bg-blue-800 hover:text-white px-5 py-2 rounded-lg transition-colors">Login</a>
                    <a href="{{ route('register') }}"
                        class="w-26 bg-blue-800 border border-blue-800 text-white px-5 py-2 text-sm font-medium rounded-lg hover:bg-blue-900 btn-ripple">Register</a>
                @endif
            </div>
            <!-- HAMBURGER (mobile only) -->
            <div class="md:hidden flex items-center cursor-pointer z-50 hamburger">
                <i class="fas fa-bars text-blue-800 text-2xl"></i>
                <i class="fas fa-times text-blue-800 text-2xl hidden"></i>
            </div>
        </div>
        <!-- MENU MOBILE -->
        <div
            class="mobile-menu md:hidden px-4 pb-4 space-y-2 hidden translate-y-[-20px] opacity-0 transition-all duration-300 absolute top-16 left-0 w-full bg-white shadow-lg z-40">
            <a href="#beranda"
                class="block py-3 text-center font-medium text-gray-600 hover:text-blue-800 hover:bg-blue-50 rounded-md">Beranda</a>
            <a href="#layanan"
                class="block py-3 text-center font-medium text-gray-600 hover:text-blue-800 hover:bg-blue-50 rounded-md">Layanan</a>
            <a href="#tentang"
                class="block py-3 text-center font-medium text-gray-600 hover:text-blue-800 hover:bg-blue-50 rounded-md">Tentang</a>
            <a href="#kontak"
                class="block py-3 text-center font-medium text-gray-600 hover:text-blue-800 hover:bg-blue-50 rounded-md">Kontak</a>
            @if (Auth::check())
                <div class="relative">
                    <button id="profileToggle" class="flex items-center focus:outline-none w-full justify-center">
                        <span class="mr-2 font-medium">Nama Pengguna</span>
                        <img src="https://randomuser.me/api/portraits/women/44.jpg"
                            class="w-10 h-10 rounded-full border" alt="Profile" />
                    </button>
                    <div id="profileMenu"
                        class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-md py-2 z-50 hidden">
                        <button onclick="openModal()"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ganti Profil</button>
                        <a href="#" onclick="openModal()"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ganti Password</a>
                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            @else
                <button class="block text-sm text-blue-800 py-2">Login</button>
                <button
                    class="block w-full bg-blue-800 text-white px-4 py-2 text-sm rounded-lg hover:bg-blue-900 btn-ripple">Register</button>
            @endif
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="beranda" class="relative py-20"
        style="background: radial-gradient(circle at right center, #ebf8ff, #bfdbfe);">

        <div
            class="max-w-7xl mx-auto px-2 md:px-10 flex flex-col-reverse md:flex-row items-center gap-12 relative z-10">
            <div class="w-full md:w-1/2 text-center md:text-left -ml-2 md:-ml-4" data-aos="fade-right">
                <p class="text-sm text-blue-800 font-medium">
                    SIPASTI — Sistem Pelaporan Sarana & Prasarana - JTI
                </p>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mt-8 mb-8 leading-tight">
                    Bantu Jaga Fasilitas Kampus<br />
                    <span class="text-blue-800">dengan Aksi Nyata dan Cepat</span>
                </h1>

                <p class="mt-6 text-gray-600 text-lg">
                    Temukan fasilitas rusak di Jurusan TI? Langsung laporkan lewat SIPASTI. Proses cepat, pelaporan
                    mudah, dan data langsung tercatat untuk ditindaklanjuti.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="#lapor"
                        class="bg-blue-800 text-white px-6 py-3 rounded-xl text-sm font-semibold hover:bg-blue-900 transition btn-ripple">Laporkan
                        Sekarang</a>
                    <a href="#fitur"
                        class="text-blue-800 border border-blue-600 px-6 py-3 rounded-xl text-sm font-semibold hover:bg-blue-50 transition">Lihat
                        Fitur Lengkap</a>
                </div>
            </div>
        </div>


        <div class="absolute right-0 top-[140px] h-fit w-[60%] md:flex hidden lg:w-[45%] xl:w-[40%] z-0 items-center"
            data-aos="fade-left">
            <img src="{{ asset('assets/image/laptop-hp.png') }}" alt="Ilustrasi Pelaporan"
                class="w-full h-auto scale-125 md:scale-150 transition-transform duration-300" />
        </div>

        <div class="mt-16 md:mt-36 overflow-hidden whitespace-nowrap w-full relative z-10">

            <div id="logoScroll" class="inline-flex space-x-12 logo-slider">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg"
                    alt="Stripe" class="h-10 opacity-70 grayscale" />
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google"
                    class="h-10 opacity-70 grayscale" />
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft"
                    class="h-10 opacity-70 grayscale" />
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/8e/Citibank.svg" alt="Citibank"
                    class="h-10 opacity-70 grayscale" />
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/0e/Shopify_logo_2018.svg" alt="Shopify"
                    class="h-10 opacity-70 grayscale" />
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="tentang" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-12">
            <!-- Gambar -->
            <div class="md:w-1/2" data-aos="zoom-in-up">
                <img src="{{ asset('assets/image/5.jpg') }}" alt="Tim Kami"
                    class="w-full rounded-2xl shadow-xl hover:-translate-y-2 hover:shadow-2xl transition-all">
            </div>
            <!-- Teks -->
            <div class="md:w-1/2" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                    Tentang <span class="text-blue-800">SIPASTI</span>
                </h2>
                <p class="text-base text-gray-600 mb-8">
                    <strong>Perbaikan kampus jadi mudah!</strong><br><br>
                    SIPASTI adalah platform inovatif untuk melaporkan kerusakan di kampus, diciptakan oleh tim Polinema
                    untuk menciptakan lingkungan belajar yang lebih nyaman dan efisien.
                </p>
                <button
                    class="bg-blue-800 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-900 btn-ripple">Pelajari
                    Lebih Lanjut</button>
                <!-- Statistik -->
                <div class="mt-8 grid grid-cols-3 gap-6">
                    <div data-aos="fade-up" data-aos-delay="300">
                        <p class="text-3xl font-bold text-blue-800">50+</p>
                        <p class="text-sm text-gray-600">Laporan Selesai</p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400">
                        <p class="text-3xl font-bold text-blue-800">24+</p>
                        <p class="text-sm text-gray-600">Instansi</p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="500">
                        <p class="text-3xl font-bold text-blue-800">30+</p>
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
                <div class="bg-white p-6 rounded-xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all"
                    data-aos="flip-up">
                    <i class="fa-solid fa-check-circle text-blue-800 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-blue-800 mb-3">Mudah</h3>
                    <p class="text-base text-gray-600">Antarmuka intuitif memungkinkan pelaporan tanpa pelatihan
                        teknis.</p>
                </div>
                <!-- Layanan 2 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all"
                    data-aos="flip-up" data-aos-delay="100">
                    <i class="fa-solid fa-bolt text-blue-800 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-blue-800 mb-3">Cepat</h3>
                    <p class="text-base text-gray-600">Laporan langsung diteruskan ke unit terkait untuk penanganan
                        cepat.</p>
                </div>
                <!-- Layanan 3 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all"
                    data-aos="flip-up" data-aos-delay="200">
                    <i class="fa-solid fa-eye text-blue-800 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-blue-800 mb-3">Transparan</h3>
                    <p class="text-base text-gray-600">Pantau status laporan secara real-time untuk kepercayaan
                        maksimal.</p>
                </div>
                <!-- Layanan 4 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all"
                    data-aos="flip-up" data-aos-delay="300">
                    <i class="fa-solid fa-plug text-blue-800 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-blue-800 mb-3">Terintegrasi</h3>
                    <p class="text-base text-gray-600">Terhubung dengan sistem kampus untuk efisiensi maksimal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja Section -->
    <section id="cara-kerja" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <!-- Kiri: Judul + Kotak-kotak langkah -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 md:mb-12 text-right"
                        data-aos="fade-up">
                        Cara Kerja <span class="text-blue-800">SIPASTI</span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Step 1 -->
                        <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-blue-800" data-aos="zoom-in">
                            <div class="flex items-center mb-2">
                                <i class="fa-solid fa-file-alt text-blue-800 text-2xl mr-3"></i>
                                <h3 class="text-lg font-semibold text-blue-800">1. Buat Laporan</h3>
                            </div>
                            <p class="text-sm text-gray-600">Isi detail kerusakan, lokasi, dan unggah bukti foto.</p>
                        </div>
                        <!-- Step 2 -->
                        <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-blue-800" data-aos="zoom-in"
                            data-aos-delay="100">
                            <div class="flex items-center mb-2">
                                <i class="fa-solid fa-check-circle text-blue-800 text-2xl mr-3"></i>
                                <h3 class="text-lg font-semibold text-blue-800">2. Verifikasi</h3>
                            </div>
                            <p class="text-sm text-gray-600">Tim memverifikasi laporan dengan cepat.</p>
                        </div>
                        <!-- Step 3 -->
                        <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-blue-800" data-aos="zoom-in"
                            data-aos-delay="200">
                            <div class="flex items-center mb-2">
                                <i class="fa-solid fa-tools text-blue-800 text-2xl mr-3"></i>
                                <h3 class="text-lg font-semibold text-blue-800">3. Tindak Lanjut</h3>
                            </div>
                            <p class="text-sm text-gray-600">Laporan diteruskan ke tim sarpras.</p>
                        </div>
                        <!-- Step 4 -->
                        <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-blue-800" data-aos="zoom-in"
                            data-aos-delay="300">
                            <div class="flex items-center mb-2">
                                <i class="fa-solid fa-bell text-blue-800 text-2xl mr-3"></i>
                                <h3 class="text-lg font-semibold text-blue-800">4. Selesai</h3>
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
                <div class="bg-white p-6 rounded-xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all"
                    data-aos="fade-up">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Testimoni Mahasiswa"
                            class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-800 text-base">Rina</h4>
                            <p class="text-sm text-gray-500">Mahasiswa TI</p>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm italic">"Lapor fasilitas rusak jadi super cepat! Gak perlu datang
                        ke TU, cukup isi form dan langsung ditindak!"</p>
                </div>
                <!-- Testimoni 2 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Testimoni Dosen"
                            class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-800 text-base">Pak Andi</h4>
                            <p class="text-sm text-gray-500">Dosen JTI</p>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm italic">"Sebagai dosen, saya bisa langsung pantau laporan di kelas.
                        Transparan dan respons cepat."</p>
                </div>
                <!-- Testimoni 3 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Testimoni Tendik"
                            class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-800 text-base">Bu Sari</h4>
                            <p class="text-sm text-gray-500">Staf Sarpras</p>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm italic">"Dengan SIPASTI, laporan masuk langsung ke sistem kami.
                        Memudahkan tim maintenance mengatur prioritas kerja."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-12">
            <!-- Gambar -->
            <div class="md:w-1/2" data-aos="fade-left">
                <img src="{{ asset('assets/image/2.png') }}" alt="Tim Kerja"
                    class="w-full rounded-xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all">
            </div>
            <!-- Formulir -->
            <div class="md:w-1/2" data-aos="fade-right">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Hubungi Kami</h2>
                <p class="text-base text-gray-600 mb-4">Kirim pesan untuk pertanyaan atau saran!</p>
                <div class="space-y-2">
                    <input type="text" placeholder="Nama"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-800 transition-shadow">
                    <input type="email" placeholder="Email"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-800 transition-shadow">
                    <textarea placeholder="Pesan"
                        class="w-full p-2 border rounded-lg h-28 focus:outline-none focus:ring-2 focus:ring-blue-800 transition-shadow"></textarea>
                    <button
                        class="bg-blue-800 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-900 btn-ripple">Kirim</button>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12" data-aos="fade-up">Pertanyaan
                Umum</h2>
            <div class="space-y-2">
                <!-- FAQ 1 -->
                <div class="border rounded-xl bg-white shadow-sm" data-aos="fade-up">
                    <button
                        class="w-full flex justify-between items-center p-5 text-left font-semibold text-gray-800 toggle-faq">
                        Apakah semua mahasiswa bisa melapor?
                        <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 hidden text-base text-gray-600">
                        Ya, semua mahasiswa dengan akun aktif bisa melapor.
                    </div>
                </div>
                <!-- FAQ 2 -->
                <div class="border rounded-xl bg-white shadow-sm" data-aos="fade-up" data-aos-delay="100">
                    <button
                        class="w-full flex justify-between items-center p-5 text-left font-semibold text-gray-800 toggle-faq">
                        Berapa lama laporan diproses?
                        <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 hidden text-base text-gray-600">
                        Biasanya 1x24 jam untuk verifikasi dan tindak lanjut.
                    </div>
                </div>
                <!-- FAQ 3 -->
                <div class="border rounded-xl bg-white shadow-sm" data-aos="fade-up" data-aos-delay="200">
                    <button
                        class="w-full flex justify-between items-center p-5 text-left font-semibold text-gray-800 toggle-faq">
                        Apakah laporan saya rahasia?
                        <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
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
    <footer class="bg-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tentang -->
            <div data-aos="fade-up">
                <img src="{{ asset('assets/image/sipasti.svg') }}" alt="Logo SIPASTI" class="h-10 mb-4">
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
                    <button class="bg-blue-900 text-white p-3 rounded-r-lg hover:bg-blue-950 btn-ripple">Kirim</button>
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
        const menuIcon = hamburger.querySelector('.fa-bars');
        const closeIcon = hamburger.querySelector('.fa-times');
        const mobileMenu = document.querySelector('.mobile-menu');
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
            mobileMenu.classList.toggle('active');
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('translate-y-[-20px]');
            mobileMenu.classList.toggle('opacity-0');
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

        const container = document.getElementById("logoScroll");
        const originalContent = container.innerHTML;

        // Duplikasi isi sebanyak 10 kali
        for (let i = 0; i < 10; i++) {
            container.innerHTML += originalContent;
        }

        // Navbar scroll effect
        const navbar = document.getElementById("navbar");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 0) {
                navbar.style.background = "white";
                navbar.classList.add("shadow-lg");
            } else {
                navbar.style.background = "radial-gradient(circle at right center, #ebf8ff, #bfdbfe)";
                navbar.classList.remove("shadow-lg");
            }
        });
    </script>
</body>

</html>
