@php
    $pageTitles = [
        'admin.dashboard' => 'Dashboard',
        'admin.mahasiswa' => 'Data Mahasiswa',
        'admin.datapengguna' => 'Data Pengguna',
        'admin.fasilitas' => 'Data Fasilitas',
        'admin.ruangan' => 'Data Ruangan',
        'admin.ruanganfasilitas' => 'Ruangan & Fasilitas',
        'admin.laporanstatistik' => 'Laporan Statistik',
        'admin.datalaporan' => 'Data Laporan Kerusakan',
        'admin.roleruangan' => 'Kelola Role Ruangan',

        'civitas.dashboard' => 'Dashboard',
        'civitas.laporkan' => 'Laporkan Kerusakan',
        'civitas.status' => 'Status Laporan',
        'civitas.rating' => 'Beri Rating',

        'sarpras.dashboard' => 'Dashboard',
        'sarpras.kelolaLaporan' => 'Kelola Laporan',
        'sarpras.statistik' => 'Statistik',
        'sarpras.status' => 'Status',
        'sarpras.tugaskan' => 'Tugaskan Teknisi',
        'sarpras.rekomendasi' => 'Rekomendasi',
        'sarpras.kategorisasi' => 'Kategorisasi',

        'teknisi.dashboard' => 'Dashboard',
        'teknisi.tugas' => 'Daftar Tugas',
        'teknisi.perbarui' => 'Perbarui Status',
        'teknisi.riwayat' => 'Riwayat Pekerjaan',
    ];

    $currentRoute = Route::currentRouteName();
    $pageTitle = $pageTitles[$currentRoute] ?? Auth::user()->role->role_nama;
@endphp
<header class="sticky top-0 z-40 flex justify-between items-center bg-white px-6 py-4 shadow">

    {{-- Tombol Hamburger --}}
    <button id="toggleSidebar" class="md:hidden text-2xl">☰</button>

    {{-- Judul halaman (hanya tampil di layar md ke atas) --}}
    <h2 class="text-xl font-semibold hidden md:block">
        {{ $pageTitle }}
    </h2>

    {{-- Judul pendek saat mobile --}}
    <span class="text-xl font-semibold block md:hidden">SIPASTI</span>

    {{-- Profil lengkap (tampilkan hanya di desktop) --}}
    <div class="hidden md:block">
        @include('component.profile')
    </div>

    {{-- Foto profil saja saat mobile --}}
    <div class="block md:hidden">
        <button id="profileToggleMobile" type="button"
            class="w-10 h-10 rounded-full overflow-hidden ring-2 ring-blue-500 focus:outline-none">
            <img src="{{ Auth::user()->profile_picture ? asset('assets/profile/' . Auth::user()->profile_picture) : asset('assets/profile/default.jpg') }}"
                alt="Foto Profil" class="w-full h-full object-cover">
        </button>
    </div>

</header>
