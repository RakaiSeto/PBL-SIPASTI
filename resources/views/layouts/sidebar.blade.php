<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-white p-4 shadow-md hidden md:block fixed md:static inset-y-0 left-0 z-50">
  <!-- Tombol tutup (mobile) -->
  <div class="flex justify-between items-center mb-4 md:hidden">
    <h1 class="text-xl font-bold">SIPASTI</h1>
    <button id="closeSidebar" class="text-2xl">✕</button>
  </div>

  <!-- Logo Desktop -->
  <a href="#">
    <div class="hidden md:flex items-center mb-2 mr-3">
      <img src="{{ asset('assets/image/LOGO.svg') }}" class="h-8 mr-1" alt="Logo" />
      <h1 class="text-xl font-bold">SIPASTI</h1>
    </div>
  </a>

  <!-- Menu Navigasi -->
  <nav class="space-y-2 text-sm font-medium overflow-y-auto max-h-[calc(100vh-100px)]">
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Main Menu</h2>

    @if (Auth::user()->role->role_nama == 'Admin')
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center p-3 rounded font-semibold
              {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
     <i class="fas fa-home mr-2"></i> Dashboard
    </a>

    @elseif (Auth::user()->role->role_nama == 'Teknisi')
    <a href="{{ route('teknisi.dashboard') }}"
       class="flex items-center p-3 rounded font-semibold
              {{ request()->routeIs('teknisi.dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fas fa-home mr-2"></i> Dashboard
    </a>

    @elseif (Auth::user()->role->role_nama == 'Sarpras')
    <a href="{{ route('sarpras.dashboard') }}"
    class="flex items-center p-3 rounded font-semibold
    {{ request()->routeIs('sarpras.dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
     <i class="fas fa-home mr-2"></i> Dashboard
    </a>

    @elseif (Auth::user()->role->role_nama == 'Civitas')
    <a href="{{ route('civitas.dashboard') }}"
       class="flex items-center p-3 rounded font-semibold
              {{ request()->routeIs('civitas.dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fas fa-home mr-2"></i> Dashboard
    </a>
    @endif

    @if (Auth::user()->role->role_nama == 'Admin')
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Data Pengguna</h2>
    <a href="{{ route('admin.datapengguna') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('admin.datapengguna') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-user-tie mr-2"></i> Kelola Pengguna
    </a>

    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Data Inventaris</h2>
    <a href="{{ route('admin.ruangan') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('admin.ruangan') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-building mr-2"></i> Kelola Ruangan
    </a>
    <a href="{{ route('admin.fasilitas') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('admin.fasilitas') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-screwdriver-wrench mr-2"></i> Kelola Fasilitas
    </a>
    <a href="{{ route('admin.hai') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('admin.hai') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-chalkboard mr-2"></i> Kelola Ruang & Fasilitas
    </a>
    @endif

    @if (Auth::user()->role->role_nama == 'Civitas')
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Main Menu</h2>

    <a href="{{ route('civitas.laporkan') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('civitas.laporkan') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-pen mr-2"></i> Laporkan
    </a>
    <a href="{{ route('civitas.status') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('civitas.status') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-clipboard-list mr-2"></i> Status Laporan
    </a>
    <a href="{{ route('civitas.rating') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('civitas.rating') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-star mr-2"></i> Beri Feedback
    </a>
    @endif

    @if (Auth::user()->role->role_nama == 'Teknisi')
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Data Perbaikan</h2>
    <a href="{{ route('teknisi.tugas') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('teknisi.tugas') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-wrench mr-2"></i> Tugas Perbaikan
    </a>
    <a href="{{ route('teknisi.riwayat') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('teknisi.riwayat') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-history mr-2"></i> Riwayat Perbaikan
    </a>
    @endif

    @if (Auth::user()->role->role_nama == 'Sarpras')
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Data Perbaikan</h2>
    <a href="{{ route('sarpras.kelolaLaporan') }}"
       class="block p-3 rounded font-semibold
              {{ request()->routeIs('sarpras.kelolaLaporan') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-wrench mr-2"></i> Kelola Laporan
    </a>
    <a href="{{ route('sarpras.kategorisasi') }}"
    class="block p-3 rounded font-semibold
          {{ request()->routeIs('sarpras.kategorisasi') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
  <i class="fa-solid fa-list mr-2"></i> Kategorisasi Laporan
</a>

<a href="{{ route('sarpras.rekomendasi') }}"
   class="block p-3 rounded font-semibold
          {{ request()->routeIs('sarpras.rekomendasi') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
  <i class="fa-solid fa-lightbulb mr-2"></i> Rekomendasi Perbaikan
</a>

<a href="{{ route('sarpras.tugaskan') }}"
   class="block p-3 rounded font-semibold
          {{ request()->routeIs('sarpras.tugaskan') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
  <i class="fa-solid fa-user-cog mr-2"></i> Tugaskan Teknisi
</a>

<a href="{{ route('sarpras.status') }}"
   class="block p-3 rounded font-semibold
          {{ request()->routeIs('sarpras.status') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
  <i class="fa-solid fa-circle-check mr-2"></i> Status Perbaikan
</a>

<a href="{{ route('sarpras.statistik') }}"
   class="block p-3 rounded font-semibold
          {{ request()->routeIs('sarpras.statistik') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
  <i class="fa-solid fa-chart-column mr-2"></i> Statistik
</a>

    @endif
  </nav>
</aside>

<!-- Script Sidebar -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
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
  });
</script>

