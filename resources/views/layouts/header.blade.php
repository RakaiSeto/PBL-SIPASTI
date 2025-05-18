<header class="md:sticky md:top-0 z-40 flex justify-between items-center bg-white px-6 py-4 shadow">
    <button id="toggleSidebar" class="md:hidden text-2xl">☰</button>
    <h2 class="text-2xl font-semibold">{{ Auth::user()->role->role_nama }}</h2>

    <!-- Profil & Dropdown -->
    @include('component.profile')

  </header>

  {{-- <!-- Script Sidebar -->
<script>
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
</script> --}}



