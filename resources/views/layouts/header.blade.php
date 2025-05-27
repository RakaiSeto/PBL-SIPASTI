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

<header class="md:sticky md:top-0 z-40 flex justify-between items-center bg-white px-6 py-4 shadow">
    <button id="toggleSidebar" class="md:hidden text-2xl">☰</button>
    <h2 class="text-2xl font-semibold">{{ $pageTitle }}</h2>

    {{-- <h2 class="text-2xl font-semibold">{{ Auth::user()->role->role_nama }}</h2> --}}

    <!-- Profil & Dropdown -->
    @include('component.profile')
    @include('component.gantipassword')

  </header>



