
<!--modalhapus-->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
    <h2 class="text-xl font-semibold text-slate-800 mb-4">Konfirmasi Hapus</h2>
    <p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus pengguna berikut ini?</p>

    <div class="text-sm text-slate-700 space-y-2 mb-5">
      <div><span class="font-medium">Nama Lengkap:</span> <span id="delNama"></span></div>
      <div><span class="font-medium">Username:</span> <span id="delUsername"></span></div>
      <div><span class="font-medium">Role:</span> <span id="delRole"></span></div>
      <div><span class="font-medium">Email:</span> <span id="delEmail"></span></div>
    </div>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
            <button type="button" onclick="closeModal('deleteModal'); showDelete('deleteSuccess');" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
        </div>
        <button onclick="closeModal('deleteModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>
