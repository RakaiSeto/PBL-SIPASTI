<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <input type="hidden" id="deleteRuanganRoleId">
        <h2 class="text-xl font-semibold text-slate-800 mb-4">Konfirmasi Hapus</h2>
        <p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus role ruangan berikut ini?</p>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
        <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
        </div>
    </div>
</div>