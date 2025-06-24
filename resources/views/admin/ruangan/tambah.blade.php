<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Ruangan</h2>
        <form id="addtambahRuangan" >
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="addidrole" class="block mb-1 font-medium">Role Ruangan</label>
                    <select id="addidrole" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        @foreach ($roleRuangan as $item)
                            <option value="{{ $item->ruangan_role_id }}">{{ $item->ruangan_role_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="addnamaruangan" class="block mb-1 font-medium">Nama Ruangan</label>
                    <input id="addnamaruangan" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan Nama Ruangan" required>
                </div>
                <div>
                    <label for="addlantai" class="block mb-1 font-medium">Lantai</label>
                    <select id="addlantai" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled selected>Pilih Lantai</option>
                        <option value="5">Lantai 5</option>
                        <option value="6">Lantai 6</option>
                        <option value="7">Lantai 7</option>
                        <option value="8">Lantai 8</option>
                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" id="submitAddForm" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>