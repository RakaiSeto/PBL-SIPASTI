<header class="flex justify-between items-center bg-white px-6 py-4 shadow relative">
    <button id="toggleSidebar" class="md:hidden text-2xl">☰</button>
    <h2 class="text-2xl font-semibold">{{ Auth::user()->role->role_nama }}</h2>

    <!-- Profil & Dropdown -->
    @include('component.profile')

  </header>




