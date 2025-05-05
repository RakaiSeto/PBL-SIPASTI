<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Pelaporan - Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      :root {
        --primary: #1652b7;
        --primary-hover: #1f3f97;
      }
    </style>
  </head>
  <body class="bg-white text-gray-900">
    <!-- Navbar -->
    <nav class="bg-blue-50 sticky top-0 z-50">
      <div class="max-w-screen-2xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-2">
          <img src="LOGO.svg" alt="Logo SIPASTI" class="w-10 h-10" />
          <div class="text-2xl font-bold">SIPASTI</div>
        </div>
        <!-- <div class="text-2xl font-bold text-[var(--primary)]">SaranaKampus</div> -->
        <div class="hidden md:flex space-x-6 text-base">
          <a href="#" class="text-gray-600 hover:text-[var(--primary)]">Beranda</a>
          <a href="#" class="text-gray-600 hover:text-[var(--primary)]">Layanan</a>
          <a href="#" class="text-gray-600 hover:text-[var(--primary)]">Tentang</a>
          <a href="#" class="text-gray-600 hover:text-[var(--primary)]">Kontak</a>
        </div>
        <div class="space-x-4">
          <button class="text-sm text-[var(--primary)]">Login</button>
          <button class="bg-[var(--primary)] text-white px-4 py-2 text-sm rounded">Register</button>
        </div>
      </div>
    </nav>

    <!-- Hero -->
    <!-- <section class="py-16 flex items-center bg-blue-50"> -->
    <!-- <section class="h-screen flex items-center bg-blue-50"> -->
    <section class="py-16 min-h-[700px] flex items-center bg-blue-50">
      <div class="max-w-screen-2xl mx-auto px-4 flex flex-col md:flex-row items-center gap-16">
        <!-- Kolom kiri -->
        <div class="md:w-5/12 mb-8 md:mb-0">
          <h1 class="text-5xl md:text-6xl font-bold mb-4 leading-relaxed">Sistem Pelaporan Sarana dan Prasarana Perbaikan<br />JTI - Polinema</h1>
          <p class="text-gray-600 mb-6 text-justify text-lg md:text-xl">
            Laporkan kerusakan fasilitas kampus dengan mudah dan cepat melalui platform terpadu yang mendorong kolaborasi antara mahasiswa, dosen, dan tendik untuk menciptakan lingkungan kampus yang lebih baik.
          </p>
          <button class="bg-[var(--primary)] hover:bg-[var(--primary-hover)] text-white px-6 py-3 rounded text-lg transition-colors duration-300">Laporkan Kerusakan</button>

          <!-- <button class="bg-[var(--primary)] text-white px-6 py-3 rounded text-lg">Laporkan Kerusakan</button> -->
          <p class="mt-4 text-sm md:text-base">Ingin akses cepat? <a href="#" class="text-[var(--primary)] font-semibold">Minta Demo</a></p>
        </div>

        <!-- Kolom kanan -->
        <div class="md:w-7/12">
          <img src="New Website Blue Mockup Instagram - Laptop.png" alt="Ilustrasi Laporan" class="rounded" />
        </div>
      </div>
    </section>

    <!-- Benefit Section -->
    <section class="py-16">
      <div class="max-w-screen-2xl mx-auto px-4 grid md:grid-cols-2 items-center gap-8">
        <div>
          <img
            src="portrait-asian-emgineer-male-female-technician-safty-uniform-standing-turn-around-look-camera-laugh-smile-with-cheerful-confident-machinery-factory-workplace-background.jpg"
            alt="Tim Kami"
            class="rounded shadow-md w-full md:w-[90%]"
          />
        </div>
        <div>
          <h2 class="text-3xl md:text-4xl font-bold mb-4">Tentang Kami, <span class="text-[var(--primary)]">SIPASTI</span></h2>
          <p class="text-gray-700 leading-relaxed text-justify">
            <strong>Fokus pada perbaikan kampus, biarkan sistem kami yang menangani pelaporannya!</strong><br /><br />
            SIPASTI adalah platform pelaporan sarana dan prasarana kampus yang dikembangkan oleh tim profesional dari kalangan akademisi dan teknolog. Kami berkomitmen untuk menghadirkan solusi digital yang efisien, transparan, dan
            responsif dalam menanggapi kerusakan fasilitas demi menciptakan lingkungan belajar yang lebih nyaman dan produktif.
          </p>
          <button class="mt-6 bg-[var(--primary)] text-white px-6 py-3 rounded">Pelajari Lebih Lanjut</button>

          <!-- Statistik -->
          <div class="mt-10 grid grid-cols-3 gap-4">
            <div>
              <p class="text-3xl font-bold">50+</p>
              <p class="text-gray-600 text-sm">Laporan terselesaikan</p>
            </div>
            <div>
              <p class="text-3xl font-bold">24+</p>
              <p class="text-gray-600 text-sm">Instansi Terlibat</p>
            </div>
            <div>
              <p class="text-3xl font-bold">30+</p>
              <p class="text-gray-600 text-sm">Kontributor Aktif</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Services -->
    <section class="py-16">
      <div class="max-w-screen-2xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Layanan Kami</h2>
        <p class="text-gray-600 mb-10">Fasilitas terbaik untuk menunjang pelaporan secara cepat dan efisien.</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-left">
          <!-- Mudah -->
          <div class="bg-blue-100 p-6 rounded shadow">
            <div class="mb-4 text-[var(--primary)]">
              <!-- Heroicons: ClipboardListIcon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h3.28a2 2 0 011.43.6l.59.6h3.28a2 2 0 012 2v12a2 2 0 01-2 2z" />
              </svg>
            </div>
            <h3 class="font-bold text-[var(--primary)] mb-2">Mudah</h3>
            <p class="text-sm text-gray-600 text-base md:text-base">
              Aplikasi kami dirancang dengan antarmuka yang intuitif dan ramah pengguna, sehingga siapa pun, baik mahasiswa maupun staf, dapat melaporkan masalah tanpa perlu pelatihan teknis.
            </p>
          </div>

          <!-- Cepat -->
          <div class="bg-blue-100 p-6 rounded shadow">
            <div class="mb-4 text-[var(--primary)]">
              <!-- Heroicons: LightningBoltIcon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <h3 class="font-bold text-[var(--primary)] mb-2">Cepat</h3>
            <p class="text-sm text-gray-600 text-base md:text-base">
              Setiap laporan yang masuk akan langsung diteruskan secara otomatis ke unit atau bagian yang bertanggung jawab, mempercepat proses penanganan tanpa harus melalui birokrasi berbelit.
            </p>
          </div>

          <!-- Transparan -->
          <div class="bg-blue-100 p-6 rounded shadow">
            <div class="mb-4 text-[var(--primary)]">
              <!-- Heroicons: EyeIcon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
              </svg>
            </div>
            <h3 class="font-bold text-[var(--primary)] mb-2">Transparan</h3>
            <p class="text-sm text-gray-600 text-base md:text-base">
              Pengguna dapat memantau status laporan mereka secara langsung melalui sistem, mulai dari proses verifikasi hingga penyelesaian, sehingga memberikan kepercayaan dan akuntabilitas yang tinggi.
            </p>
          </div>

          <!-- Terintegrasi -->
          <div class="bg-blue-100 p-6 rounded shadow">
            <div class="mb-4 text-[var(--primary)]">
              <!-- Heroicons: ChipIcon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7H7v6h6V7zM5 3v2M5 19v2M19 3v2M19 19v2M3 5h2M3 19h2M21 5h-2M21 19h-2M17 7h4v10h-4zM3 7h4v10H3z" />
              </svg>
            </div>
            <h3 class="font-bold text-[var(--primary)] mb-2">Terintegrasi</h3>
            <p class="text-sm text-gray-600 text-base md:text-base">
              Sistem ini telah terhubung dengan berbagai layanan dan database kampus, memastikan setiap laporan dapat diproses secara efisien tanpa perlu input ulang atau proses manual.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Benefit Section -->
    <section class="py-16">
      <div class="max-w-screen-2xl mx-auto px-4 grid md:grid-cols-2 items-center">
        <div>
          <h2 class="text-3xl font-bold mb-4 text-[var(--primary)]">Platform Terpercaya</h2>
          <ul class="list-disc pl-5 text-gray-700 space-y-2">
            <li>Digunakan oleh berbagai kampus di seluruh Indonesia.</li>
            <li>Meningkatkan efisiensi dan kecepatan penanganan masalah.</li>
            <li>Memudahkan pelaporan tanpa harus datang langsung ke unit terkait.</li>
          </ul>
          <button class="mt-6 bg-[var(--primary)] text-white px-6 py-3 rounded">Pelajari Lebih Lanjut</button>
        </div>
        <div>
          <img src="Group 400.png" alt="Tim Kerja" class="rounded" />
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 py-8">
      <div class="max-w-screen-2xl mx-auto px-4 text-center text-sm text-gray-500">© 2025 SaranaKampus. All rights reserved.</div>
    </footer>
  </body>
</html>
