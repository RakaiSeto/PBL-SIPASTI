
<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Role</h2>
        <form id="addForm">
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="addRoleNama" class="block mb-1 font-medium">Nama Role</label>
                    <input id="addRoleNama" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama role" required>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400  ">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700  ">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">×</button>
    </div>
</div>
