<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="relative">
    <div class="relative flex items-center space-x-3">
        <span class="font-semibold text-gray-800 select-none">
            {{ Auth::user()->fullname }} / <span
                class="text-gray-500 font-normal">{{ Auth::user()->role->role_nama }}</span>
        </span>

        <button id="profileToggle" type="button"
            class="w-10 h-10 rounded-full overflow-hidden ring-2 ring-blue-500 focus:outline-none">
            <img src="{{ Auth::user()->profile_picture ? asset('assets/profile/' . Auth::user()->profile_picture) : asset('assets/profile/default.png') }}"
                alt="Foto Profil" class="w-full h-full object-cover">
        </button>
    </div>



    <div id="profileMenu"
        class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg py-2 z-50 hidden transform transition-all duration-200 ease-in-out">
        @php
            $role = Auth::user()->role->role_nama;
        @endphp
        @if ($role == 'Admin')
            <a href="/admin/dashboard"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150">
                Dashboard
            </a>
        @elseif ($role == 'Sarpras')
            <a href="/sarpras"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150">
                Dashboard
            </a>
        @elseif ($role == 'Teknisi')
            <a href="/teknisi/dashboard"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150">
                Dashboard
            </a>
        @elseif ($role == 'Civitas')
            <a href="/civitas"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150">
                Dashboard
            </a>
        @endif
        @if (!Request::is('/'))
            <button onclick="openModalProfile()"
                class="block px-4 w-full text-left py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150">
                Ganti Profil
            </button>
            <button onclick="openModalPassword()"
                class="block px-4 w-full text-left py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150">
                Ganti Password
            </button>
        @endif
        <a href="/logout"
            class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition duration-150">Logout</a>
    </div>
</div>

<!-- Modal Ganti Password -->
<div id="modalPassword" class="fixed inset-0 bg-black bg-opacity-30 hidden items-center justify-center z-50">
    <div
        class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl relative transform transition-all duration-300 ease-in-out">
        <button onclick="closeModalPassword()"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">×</button>

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ganti Password</h2>

        <form action="{{ route('profile.changePassword') }}" method="POST">
            @csrf
            <!-- Password Lama -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                <input type="password" name="old_password" placeholder="Masukkan password lama"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    required>
            </div>

            <!-- Password Baru -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="new_password" placeholder="Masukkan password baru"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    required>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" placeholder="Ulangi password baru"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    required>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModalPassword()"
                    class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-150">Batal</button>
                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ganti Profil -->
<div id="modalProfile" class="fixed inset-0 bg-black bg-opacity-30 hidden items-center justify-center z-50"
    onclick="closeModalProfile(event)">
    <div
        class="bg-white w-full max-w-md rounded-xl p-6 shadow-xl relative transform transition-all duration-300 ease-in-out">
        <button onclick="closeModalProfile()"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">×</button>

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ganti Profil</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="flex justify-center mb-6">
                <img src="{{ Auth::user()->profile_picture ? asset('assets/profile/' . Auth::user()->profile_picture) : asset('assets/profile/default.png') }}"
                    alt="Foto Profil" class="w-28 h-28 rounded-full object-cover ring-2 ring-blue-500">
            </div>


            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" name="fullname" value="{{ Auth::user()->fullname }}"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    required>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" value="{{ Auth::user()->email }}" readonly
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 cursor-not-allowed">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Telp</label>
                <input type="text" name="no_telp" value="{{ Auth::user()->no_telp }}"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    required>
            </div>

            <!-- Foto Profil -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                <input type="file" name="profile_picture" class="w-full border border-gray-200 rounded-lg px-4 py-3">
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModalProfile()"
                    class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-150">Batal</button>
                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const profileToggle = document.getElementById("profileToggle");
    const profileMenu = document.getElementById("profileMenu");

    profileToggle.addEventListener("click", function(e) {
        e.stopPropagation();
        profileMenu.classList.toggle("hidden");
        profileMenu.classList.toggle("scale-95", profileMenu.classList.contains("hidden"));
    });

    document.addEventListener("click", function() {
        profileMenu.classList.add("hidden");
        profileMenu.classList.add("scale-95");
    });

    function openModalProfile() {
        document.getElementById('modalProfile').classList.remove('hidden');
        document.getElementById('modalProfile').classList.add('flex');
    }

    function closeModalProfile(event) {
        if (event.target.id === 'modalProfile' || event.target.tagName === 'BUTTON') {
            document.getElementById('modalProfile').classList.remove('flex');
            document.getElementById('modalProfile').classList.add('hidden');
        }
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
<script>
    function showSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: message,
            timer: 3000,
            showConfirmButton: true
        });
    }

    function showDelete(message) {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>

<!-- Panggil fungsi jika ada session -->
<script>
    @if (session('success'))
        showSuccess("{{ session('success') }}");
    @endif

    @if (session('error'))
        showError("{{ session('error') }}");
    @endif
</script>
