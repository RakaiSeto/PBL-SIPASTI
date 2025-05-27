<div class="relative">
    </button>
        <button id="profileToggle" class="flex items-center focus:outline-none">
        <span class="mr-2 font-medium">
            {{ Auth::user()->fullname }} / <span class="text-gray-500">{{ Auth::user()->role->role_nama }}</span>
        </span>
        <img src="{{ Auth::user()->profile_picture ? asset('storage/profile/' . Auth::user()->profile_picture) : asset('storage/profile/default.png') }}"
            class="w-12 h-12 rounded-full border" alt="Profile" />
    </button>
@if (session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif


    <!-- Dropdown menu -->
    <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-md py-2 z-50 hidden">
            @php
                $role = Auth::user()->role->role_nama;
            @endphp
            @if ($role == 'Admin')
                <a href="/admin/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Dashboard
                </a>
            @elseif ($role == 'Sarpras')
                <a href="/sarpras" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Dashboard
                </a>
            @elseif ($role == 'Teknisi')
                <a href="/teknisi/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Dashboard
                </a>
            @elseif ($role == 'Civitas')
                <a href="/civitas" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Dashboard
                </a>
            @endif
        @if (!Request::is('/'))
            <button onclick="openModalProfile()" class="block px-4 w-full text-left py-2 text-sm text-gray-700 hover:bg-gray-100">
                Ganti Profil
            </button>
            <button onclick="openModalPassword()" class="block px-4 w-full text-left py-2 text-sm text-gray-700 hover:bg-gray-100">
                Ganti Password
            </button>
        @endif
        <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
    </div>
</div>
<!-- Modal Ganti Password -->

<div id="modalPassword" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-lg p-6 shadow-lg relative">
        <!-- Tombol Tutup -->
        <button onclick="closeModalPassword()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg">&times;</button>

        <h2 class="text-xl font-semibold mb-4">Ganti Password</h2>

        <form action="{{ route('profile.changePassword') }}" method="POST">
    @csrf

            <!-- Password Lama -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                <input type="password" name="old_password" placeholder="Masukkan password lama"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Password Baru -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="new_password" placeholder="Masukkan password baru"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" placeholder="Ulangi password baru"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModalPassword()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openModalPassword() {
        document.getElementById('modalPassword').classList.remove('hidden');
        document.getElementById('modalPassword').classList.add('flex');
    }

    function closeModalPassword() {
        document.getElementById('modalPassword').classList.remove('flex');
        document.getElementById('modalPassword').classList.add('hidden');
    }
</script>

<div id="modalProfile" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeModalProfile(event)">
    <div class="bg-white w-full max-w-lg rounded-lg p-6 shadow-lg relative">
        <!-- Tombol Tutup -->
        <button onclick="closeModalProfile()"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg">&times;</button>

        <h2 class="text-xl font-semibold mb-4">Ganti Profil</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST') {{-- bisa juga pakai PUT jika kamu pakai route resource --}}

    <div class="flex justify-center mb-4">
        <img src="{{ Auth::user()->profile_picture ? asset('storage/profile/' . Auth::user()->profile_picture) : asset('storage/profile/default.png') }}" alt="Foto Profil"
            class="w-24 h-24 rounded-full object-cover ring-2 ring-blue-500">
    </div>

    <!-- Nama -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="fullname" value="{{ Auth::user()->fullname }}"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- Email (readonly) -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" value="{{ Auth::user()->email }}" readonly
            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
    </div>

    <!-- Foto Profil -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
        <input type="file" name="profile_picture"
            class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-end gap-2">
        <button type="button" onclick="closeModalProfile()"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
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

    function openModalProfile() {
        document.getElementById('modalProfile').classList.remove('hidden');
        document.getElementById('modalProfile').classList.add('flex');
    }

    function closeModalProfile() {
        document.getElementById('modalProfile').classList.remove('flex');
        document.getElementById('modalProfile').classList.add('hidden');
    }

    function openModalPassword() {
        document.getElementById('modalPassword').classList.remove('hidden');
        document.getElementById('modalPassword').classList.add('flex');
    }

    function closeModalPassword() {
        document.getElementById('modalPassword').classList.remove('flex');
        document.getElementById('modalPassword').classList.add('hidden');
    }

</script>
