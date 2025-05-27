
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
    <h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>

    <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diubah!'); ">
      <div class="space-y-2 text-slate-800">
        <div>
          <label class="block mb-1 font-medium text-sm">Nama Lengkap</label>
          <input type="text" class="w-full border-gray-200 text-sm  rounded" placeholder="Masukkan Nama Lengkap" required>
        </div>
        <div>
          <label class="block mb-1 font-medium text-sm">Username</label>
          <input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan Username">
        </div>
        <div>
          <label class="block mb-1 font-medium text-sm">Email</label>
          <input type="email" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan Email" required>
        </div>
        <div>
          <label class="block mb-1 font-medium text-sm">Role</label>
          <select class="w-full border-gray-200 px-2 py-2 text-sm rounded" required>
            <option value="">Pilih Role</option>
            <option value="Admin">Admin</option>
            <option value="Sarpras">Sarpras</option>
            <option value="Civitas">Civitas</option>
            <option value="Teknisi">Teknisi</option>
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
