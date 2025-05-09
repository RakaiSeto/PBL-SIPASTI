<header class="flex justify-between items-center bg-white px-6 py-4 shadow relative">
    <button id="toggleSidebar" class="md:hidden text-2xl">☰</button>
    <h2 class="text-2xl font-semibold">Admin</h2>

    <!-- Profil & Dropdown -->
    <div class="relative">
      <button id="profileToggle" class="flex items-center focus:outline-none">
        <span class="mr-2 font-medium">Nama Pengguna</span>
        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-10 h-10 rounded-full border" alt="Profile" />
      </button>

      <!-- Dropdown menu -->
      <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-md py-2 z-50 hidden">
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ganti Profil</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ganti Password</a>
        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
      </div>
    </div>
  </header>
  <script>
    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    profileToggle.addEventListener("click", function (e) {
      e.stopPropagation();
      profileMenu.classList.toggle("hidden");
    });

    document.addEventListener("click", function () {
      profileMenu.classList.add("hidden");
    });
  </script>
