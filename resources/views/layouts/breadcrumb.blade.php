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

@php
    $role = Auth::check() ? Auth::user()->role->role_nama : null;
    $dashboardUrl = '/'; // default

    switch ($role) {
        case 'Admin':
            $dashboardUrl = '/admin';
            break;
        case 'Teknisi':
            $dashboardUrl = '/teknisi';
            break;
        case 'Sarpras':
            $dashboardUrl = '/sarpras';
            break;
        case 'Civitas':
            $dashboardUrl = '/civitas';
            break;
    }
@endphp

@unless(
    Request::is('admin') ||
    Request::is('teknisi') ||
    Request::is('sarpras') ||
    Request::is('civitas')
)
<div class="bg-white p-4 rounded shadow mb-4">
    <nav class="text-sm text-gray-600" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1">
            <li>
                <a href="{{ $dashboardUrl }}" class="text-gray-500 hover:text-blue-600">
                    Dashboard
                </a>
            </li>
            <li class="px-1">/</li>
            <li class="text-gray-700 font-medium">
                {{ $pageTitle }}
            </li>
        </ol>
    </nav>
</div>
@endunless

