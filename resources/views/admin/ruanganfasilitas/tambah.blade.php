<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Ruang dan Fasilitas</h2>
        <form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Data berhasil ditambahkan!');">
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="addRole" class="block mb-1 font-medium">Ruangan</label>
                    <select id="addRole" class="w-full border-gray-200 px-3 py-2 rounded" required>
                        <option value="" selected disabled>Pilih Ruangan</option>
                        @foreach ($ruangan as $item)
                            <option value="{{ $item->ruangan_id }}">{{ $item->ruangan_nama }} - Lantai
                                {{ $item->lantai }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- resources/views/your-view.blade.php --}}

            <div class="space-y-2 text-slate-900">
                <label for="select-fasilitas" class="block mb-1 font-medium">Fasilitas</label>
                {{-- We will target this ID with JavaScript --}}
                <select id="select-fasilitas" name="fasilitas[]" multiple placeholder="Pilih Fasilitas..."
                    autocomplete="off">
                    {{-- The "Pilih Ruangan" is now a placeholder, not an option --}}
                    @foreach ($fasilitas as $item)
                        <option value="{{ $item->fasilitas_id }}">{{ $item->fasilitas_nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="button" class="btn-primary" id="btnTambahRuanganFasilitas">Simpan</button>
            </div>
        </form>
        <button onclick="closeModal('addModal')"
            class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>
