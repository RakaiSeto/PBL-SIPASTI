<div class="relative">
    <button id="profileToggle" class="flex items-center focus:outline-none">
        <span class="mr-2 font-medium">{{ Auth::user()->fullname }}</span>
        <img src="{{ Auth::user()->profile_picture ? asset('storage/profile/' . Auth::user()->profile_picture) : asset('storage/profile/default.png') }}"
            class="w-10 h-10 rounded-full border" alt="Profile" />
    </button>

    <!-- Dropdown menu -->
    <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-md py-2 z-50 hidden">
        @php
            $role = Auth::user()->role->role_nama;
        @endphp
        @if ($role == 'Admin')
            <a href="/admin/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Dashboard
            </a>
        @endif
        @if (!Request::is('/'))
            <button onclick="openModal()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Ganti Profil
            </button>
            <a href="#" onclick="openModal()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ganti
                Password</a>
        @endif
        <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
    </div>
</div>

<div id="modalProfile" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 onclick="
    closeModal(event)">
    <div class="bg-white w-full max-w-lg rounded-lg p-6 shadow-lg relative">
        <!-- Tombol Tutup -->
        <button onclick="closeModal()"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg">&times;</button>

        <h2 class="text-xl font-semibold mb-4">Ganti Profil</h2>

        <form>

            <div class="flex justify-center mb-4">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Foto Profil"
                    class="w-24 h-24 rounded-full object-cover ring-2 ring-blue-500">
            </div>
            <!-- Nama -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" placeholder="Nama lengkap"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" placeholder="email@example.com"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Foto Profil -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                <input type="file" class="w-full border border-gray-300 rounded px-3 py-2">
                {{-- <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Preview"
                    class="mt-2 w-20 h-20 rounded-full object-cover"> --}}
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

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

    function openModal() {
        document.getElementById('modalProfile').classList.remove('hidden');
        document.getElementById('modalProfile').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('modalProfile').classList.remove('flex');
        document.getElementById('modalProfile').classList.add('hidden');
    }

</script>