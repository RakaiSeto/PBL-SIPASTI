<aside id="sidebar" class="w-64 bg-white p-4 shadow-md hidden md:block fixed md:static inset-y-0 left-0 z-50">
  <!-- Tombol tutup (mobile) -->
  <div class="flex justify-between items-center mb-4 md:hidden">
    <h1 class="text-xl font-bold">SIPASTI</h1>
    <button id="closeSidebar" class="text-2xl">✕</button>
  </div>

  <!-- Logo Desktop -->
  <div class="hidden md:flex items-center mb-2 mr-3">
    <img src="{{ asset('assets/image/LOGO.svg') }}" class="h-8 mr-1 text-center" alt="Logo" />
    <h1 class="text-xl font-bold">SIPASTI</h1>
  </div>

  <!-- Menu Navigasi -->
  <nav class="space-y-2 text-sm font-medium overflow-y-auto max-h-[calc(100vh-100px)]">
    <h2 class="text-xs mt-6 mb-2 uppercase font-semibold">Main Menu</h2>
    <a href="{{ url('/admin/dashboard') }}"
       class="flex items-center p-3 rounded font-semibold
              {{ Request::is('admin/dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <span class="material-icons mr-2">dashboard</span> Dashboard
    </a>

    <h2 class="text-xs text-bold mt-4 mb-1 uppercase font-semibold">Manajemen Pengguna</h2>
    <a href="{{ url('/admin/dosen') }}"
       class="block p-3 rounded
              {{ Request::is('admin/dosen*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-user-tie mr-2"></i> Data Dosen
    </a>
    <a href="{{ url('/admin/mahasiswa') }}"
       class="block p-3 rounded
              {{ Request::is('admin/mahasiswa*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-user-graduate mr-2"></i> Data Mahasiswa
    </a>
    <a href="{{ url('/admin/teknisi') }}"
       class="block p-3 rounded
              {{ Request::is('admin/teknisi*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-screwdriver-wrench mr-2"></i> Data Teknisi
    </a>
    <a href="{{ url('/admin/sarpras') }}"
       class="block p-3 rounded
              {{ Request::is('admin/sarpras*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-database mr-2"></i> Data Sarana Prasarana
    </a>

    <h2 class="text-xs mt-4 mb-1 uppercase font-semibold">Manajemen Infrastruktur</h2>
    <a href="{{ url('/admin/gedung') }}"
       class="block p-3 rounded
              {{ Request::is('admin/gedung*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-building mr-2"></i> Data Gedung
    </a>
    <a href="{{ url('/admin/fasilitas') }}"
       class="block p-3 rounded
              {{ Request::is('admin/fasilitas*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-chair mr-2"></i> Data Fasilitas
    </a>

    <h2 class="text-xs mt-4 mb-1 uppercase font-semibold">Manajemen Infrastruktur</h2>
    <a href="{{ url('/civitas/laporkan') }}"
       class="block p-3 rounded
              {{ Request::is('civitas/laporkan*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-building mr-2"></i> Laporkan
    </a>
    <a href="{{ url('/admin/fasilitas') }}"
       class="block p-3 rounded
              {{ Request::is('admin/fasilitas*') ? 'bg-primary text-white' : 'hover:bg-gray-100 text-gray-500' }}">
      <i class="fa-solid fa-chair mr-2"></i> Data Fasilitas
    </a>
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
