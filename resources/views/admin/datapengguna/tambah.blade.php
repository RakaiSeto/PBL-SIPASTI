<form id="addForm">
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <h2 class="text-2xl font-semibold mb-4">Tambah Pengguna</h2>
            <div class="space-y-4 text-slate-900">
                <div class="form-group">
                    <label for="addNama" class="block mb-1 font-medium">Nama Lengkap</label>
                    <input id="addNama" name="fullname" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama lengkap" required>
                    <small id="error-fullname" class="error-text text-red-600"></small>
                </div>
                <div class="form-group">
                    <label for="addUsername" class="block mb-1 font-medium">Username</label>
                    <input id="addUsername" name="username" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan username" required>
                    <small id="error-username" class="error-text text-red-600"></small>
                </div>
                <div class="form-group">
                    <label for="addEmail" class="block mb-1 font-medium">Email</label>
                    <input id="addEmail" name="email" type="email" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan email" required>
                    <small id="error-email" class="error-text text-red-600"></small>
                </div>
                <div class="form-group">
                    <label for="addTelp" class="block mb-1 font-medium">Telp</label>
                    <input id="addTelp" name="no_telp" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan no telp" required>
                    <small id="error-no_telp" class="error-text text-red-600"></small>
                </div>
                <div class="form-group">
                    <label for="addRole" class="block mb-1 font-medium">Role</label>
                    <select id="addRole" name="role" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="sarpras">Sarpras</option>
                        <option value="civitas">Civitas</option>
                        <option value="teknisi">Teknisi</option>
                    </select>
                    <small id="error-role" class="error-text text-red-600"></small>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
            <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">×</button>
        </div>
    </div>
</form>
