<aside id="sidebar" class="w-64 bg-white p-4 shadow-md hidden md:block fixed md:static inset-y-0 left-0 z-50">
  <!-- Tombol tutup (mobile) -->
  <div class="flex justify-between items-center mb-4 md:hidden">
    <h1 class="text-xl font-bold">SIPASTI</h1>
    <button id="closeSidebar" class="text-2xl">✕</button>
  </div>

  <!-- Logo Desktop -->
  <a href="/">
  <div class="hidden md:flex items-center mb-2 mr-3">
      <img src="{{ asset('assets/image/LOGO.svg') }}" class="h-8 mr-1 text-center" alt="Logo" />
      <h1 class="text-xl font-bold">SIPASTI</h1>
  </div>
  </a>

  <!-- Menu Navigasi -->
  <nav class="space-y-2 text-sm font-medium overflow-y-auto max-h-[calc(100vh-100px)]">
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Main Menu</h2>
    @if (Auth::user()->role->role_nama == 'Admin')
    <a href="{{ url('/admin/dashboard') }}"
       class="flex items-center p-3 rounded font-semibold
              {{ Request::is('admin/dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <span class="material-icons mr-2">dashboard</span> Dashboard
    </a>
    @elseif (Auth::user()->role->role_nama == 'Teknisi')
    <a href="{{ url('/teknisi/dashboard') }}"
       class="flex items-center block p-3 rounded
              {{ Request::is('teknisi/dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <span class="material-icons mr-2">dashboard</span> Dashboard Teknisi
    </a>
    @elseif (Auth::user()->role->role_nama == 'Sarpras')
    <a href="{{ url('/sarpras') }}"
       class="flex items-center p-3 rounded font-semibold
              {{ Request::is('sarpras/dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <span class="material-icons mr-2">dashboard</span> Dashboard Sarpras
    </a>
    @elseif (Auth::user()->role->role_nama == 'Civitas')
    <a href="{{ url('/civitas') }}"
        class="block p-3 rounded
            {{ Request::is('civitas') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
    <i class="fa-solid fa-building mr-2"></i> Dashboard Pelapor
    </a>
    @endif

    @if (Auth::user()->role->role_nama == 'Admin')
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Data Pengguna</h2>
    <a href="{{ url('/admin/datapengguna') }}"
       class="block p-3 rounded
              {{ Request::is('admin/datapengguna*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-user-tie mr-2"></i> Kelola Pengguna
    </a>
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">DATA INVENTARIS</h2>
    <a href="{{ url('/admin/ruangan') }}"
       class="block p-3 rounded
              {{ Request::is('admin/ruangan') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
              <i class="fa-solid fa-building mr-2"></i> Kelola Ruangan
    </a>
    <a href="{{ url('/admin/fasilitas') }}"
       class="block p-3 rounded
              {{ Request::is('admin/fasilitas') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
              <i class="fa-solid fa-screwdriver-wrench mr-2"></i> Kelola Fasilitas
    </a>

    <a href="{{ url('/admin/ruanganfasilitas') }}"
       class="block p-3 rounded
              {{ Request::is('admin/ruanganfasilitas') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-chalkboard mr-2"></i> Kelola Ruang & Fasilitas
    </a>
    @endif
    {{-- <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Sidebar untuk Civitas</h2> --}}
    @if (Auth::user()->role->role_nama == 'Civitas')
    <a href="{{ url('/civitas/laporkan') }}"
       class="block p-3 rounded
              {{ Request::is('civitas/laporkan*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-building mr-2"></i> Laporkan
    </a>

    <a href="{{ url('/civitas/status') }}"
       class="block p-3 rounded
              {{ Request::is('civitas/status*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-building mr-2"></i> Status Laporan
    </a>
    <a href="{{ url('/civitas/rating') }}"
       class="block p-3 rounded
              {{ Request::is('civitas/rating*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-building mr-2"></i> Beri Feedback
    </a>
    @endif

    @if (Auth::user()->role->role_nama == 'Teknisi')
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">DATA PERBAIKAN</h2>
    <a href="{{ url('/teknisi/tugas') }}"
       class="block p-3 rounded
        {{ Request::is('teknisi/tugas*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-wrench mr-2"></i> Tugas Perbaikan
    </a>
    <a href="{{ url('/teknisi/riwayat') }}"
        class="block p-3 rounded
          {{ Request::is('/teknisi/riwayat*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
        <i class="fa-solid fa-history mr-2"></i> Riwayat Perbaikan
    </a>
    @endif

    @if (Auth::user()->role->role_nama == 'Sarpras')
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">DATA PERBAIKAN</h2>
    <a href="{{ url('/sarpras/kelolaLaporan') }}"
       class="block p-3 rounded
        {{ Request::is('sarpras/kelolaLaporan*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-wrench mr-2"></i> Kelola Laporan
    </a>
    <a href="{{ url('/teknisi/riwayat') }}"
        class="block p-3 rounded
          {{ Request::is('/teknisi/riwayat*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
        <i class="fa-solid fa-history mr-2"></i> Riwayat Perbaikan
    </a>
    @endif
  </nav>
</aside>

<script>
  // Toggle sidebar on mobile
  const toggleSidebar = document.getElementById("toggleSidebar");
  const closeSidebar = document.getElementById("closeSidebar");
  const sidebar = document.getElementById("sidebar");

  if (toggleSidebar) {
    toggleSidebar.addEventListener("click", () => {
      sidebar.classList.toggle("hidden");
    });
  }

  if (closeSidebar) {
    closeSidebar.addEventListener("click", () => {
      sidebar.classList.add("hidden");
    });
  }
</script>
