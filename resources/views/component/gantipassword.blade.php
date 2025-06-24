<!-- Modal Ganti Password -->
<div id="modalPassword" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-lg p-6 shadow-lg relative">
        <!-- Tombol Tutup -->
        <button onclick="closeModalPassword()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg">&times;</button>

        <h2 class="text-xl font-semibold mb-4">Ganti Password</h2>

        <form action="/ganti-password" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                <input type="password" name="old_password" placeholder="Masukkan password lama"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="new_password" placeholder="Masukkan password baru"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

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
