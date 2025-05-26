<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Edit Fasilitas</h2>
        <form id="editForm">
            <input type="hidden" id="editFasilitasId">
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="editNama" class="block mb-1 font-medium">Nama Fasilitas</label>
                    <input id="editNama" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama fasilitas" required>
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