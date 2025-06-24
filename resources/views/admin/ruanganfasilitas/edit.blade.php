<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Edit Ruang dan Fasilitas</h2>

        <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diubah!');">
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="editRuangan" class="block mb-1 font-medium">Ruangan</label>
                    <select id="editRuangan" class="w-full border-gray-200 px-3 py-2 rounded" required>
                        <option value="" selected disabled>Pilih Ruangan</option>
                        @foreach ($ruangan as $item)
                            <option value="{{ $item->ruangan_id }}">{{ $item->ruangan_nama }} - Lantai
                                {{ $item->lantai }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-2 text-slate-900 mt-4">
                <label for="editFasilitas" class="block mb-1 font-medium">Fasilitas</label>
                <select id="editFasilitas" name="fasilitas[]" multiple placeholder="Pilih Fasilitas..."
                    autocomplete="off" class="w-full border-gray-200 rounded">
                    @foreach ($fasilitas as $item)
                        <option value="{{ $item->fasilitas_id }}">{{ $item->fasilitas_nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('editModal')"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="button" class="btn-primary" id="btnEditRuanganFasilitas">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('editModal')"
            class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>
