
<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Ruang dan Fasilitas</h2>
        <form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Data berhasil ditambahkan!');">
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="addRole" class="block mb-1 font-medium">Role</label>
                    <select id="addRole" class="w-full border-gray-200 px-3 py-2 rounded" required >
                    <option value="" >Pilih Role</option>
                    <option value="Admin" class="text-slate-700">Admin</option>
                    <option value="Sarpras" class="text-slate-700">Sarpras</option>
                    <option value="Civitas" class="text-slate-700">Civitas</option>
                    <option value="Teknisi" class="text-slate-700">Teknisi</option>
                </select>
                </div>
            </div>
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="addFasilitas" class="block mb-1 font-medium">Fasilitas</label>
                    <select id="addFasilitas" class="select2 w-full border-gray-200 px-3 py-2 rounded" multiple="multiple" required>
                        <option value="AC">AC</option>
                        <option value="Proyektor">Proyektor</option>
                        <option value="Whiteboard">Whiteboard</option>
                        <option value="Kursi">Kursi</option>
                        <option value="Meja">Meja</option>
                        <option value="PC">PC</option>
                        <option value="LAN">LAN</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
        <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>
