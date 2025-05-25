<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>
        <form id="editForm">

        {{-- <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diubah!');"> --}}
            <input type="hidden" id="editUserId">
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="editNama" class="block mb-1 font-medium">Nama Lengkap</label>
                    <input id="editNama" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama lengkap" required>
                </div>
                <div>
                    <label for="editUsername" class="block mb-1 font-medium">Username</label>
                    <input id="editUsername" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan username" required>
                </div>
                <div>
                    <label for="editEmail" class="block mb-1 font-medium">Email</label>
                    <input id="editEmail" type="email" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan email" required>
                </div>
                <div>
                    <label for="editRole" class="block mb-1 font-medium">Role</label>
                    <select id="editRole" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="sarpras">Sarpras</option>
                        <option value="civitas">Civitas</option>
                        <option value="teknisi">Teknisi</option>
                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('editModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>
