@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">
    <!-- Filter & Pencarian -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex gap-3 w-full md:w-auto">
            <!-- Filter Lokasi -->
            <div class="flex items-center gap-2">
                <label for="filterLokasi" class="text-sm font-medium text-slate-700">Filter :</label>
                <select
                    id="filterLokasi"
                    onchange="filterTable()"
                    class="h-10 text-sm border border-slate-300 rounded px-3 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Semua Lantai</option>
                    <option value="Lantai 5">Lantai 5</option>
                    <option value="Lantai 6">Lantai 6</option>
                    <option value="Lantai 7">Lantai 7</option>
                    <option value="Lantai 8">Lantai 8</option>
                </select>
            </div>

            <!-- Input Cari -->
            <div class="flex items-center gap-2">
                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari nama ruangan..."
                    onkeyup="filterTable()"
                    class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3 focus:ring-blue-500 focus:border-blue-500"
                />
            </div>
        </div>

        <!-- Tombol Tambah -->
        <button
            onclick="openModal('addModal')"
            class="h-10 px-4 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition"
        >
            Tambah Ruangan
        </button>
    </div>

    <!-- Tabel Ruangan -->
    <div class="overflow-auto border border-slate-200 rounded">
        <table class="w-full table-fixed text-sm text-left">
            <thead class="bg-slate-100 text-slate-700">
                <tr>
                    <th class="p-3 w-32">No</th>
                    <th class="p-3 w-32">Kode Ruangan</th>
                    <th class="p-3 w-60">Nama Ruangan</th>
                    <th class="p-3 w-40">Lokasi</th>
                    <th class="p-3 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="roomTable">
                <tr class="border-t hover:bg-slate-50">
                    <td class="p-3">1</td>
                    <td class="p-3 font-semibold text-slate-800">R001</td>
                    <td class="p-3">Ruang Teori</td>
                    <td class="p-3">Lantai 5</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <button onclick="openModal('detailModal')" class="text-gray-600 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button onclick="openModal('editModal')" class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button onclick="openModal('deleteModal')" class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr id="noDataRow" class="hidden">
                    <td colspan="5" class="text-center text-slate-500 py-4">Tidak ada data yang sesuai.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md animate-fadeIn">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-slate-800">Detail Ruangan</h2>
            <button onclick="closeModal('detailModal')" class="text-slate-400 hover:text-red-500 text-xl">&times;</button>
        </div>
        <div class="space-y-3 text-sm text-slate-700">
            <div><strong>ID Ruangan:</strong> R001</div>
            <div><strong>Nama Ruangan:</strong> Ruang Teori</div>
            <div><strong>Lokasi:</strong> Lantai 5</div>
        </div>
        <div class="mt-6 text-right">
            <button onclick="closeModal('detailModal')" class="px-4 py-2 text-sm bg-slate-200 hover:bg-slate-300 rounded">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md animate-fadeIn">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Edit Fasilitas</h2>
        <form onsubmit="event.preventDefault(); showSuccess('editSuccess');">
            <div class="space-y-4">
                <div>
                    <label for="editId" class="block text-sm font-medium text-slate-700 mb-1">Kode Ruangan</label>
                    <input
                        type="text"
                        id="editId"
                        class="w-full px-3 py-2 border border-slate-300 rounded"
                        required
                    >
                </div>

                <div>
                    <label for="editNama" class="block text-sm font-medium text-slate-700 mb-1">Nama Ruangan</label>
                    <input
                        type="text"
                        id="editNama"
                        class="w-full px-3 py-2 border border-slate-300 rounded"
                    >
                </div>

                <div>
                    <label for="editJenis" class="block text-sm font-medium text-slate-700 mb-1">Lokasi</label>
                    <select
                        id="editJenis"
                        class="w-full px-3 py-2 border border-slate-300 rounded"
                        required
                    >
                        <option value="" disabled selected>Pilih Lokasi</option>
                        <option value="Lantai 5">Lantai 5</option>
                        <option value="Lantai 6">Lantai 6</option>
                        <option value="Lantai 7">Lantai 7</option>
                        <option value="Lantai 8">Lantai 8</option>
                    </select>
                </div>
            </div>
            <div class="mt-5 text-right">
                <button
                    type="button"
                    onclick="closeModal('editModal')"
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded mr-2"
                >Batal</button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded"
                >Simpan</button>
            </div>
        </form>
    </div>
</div>




<!-- Modal Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold text-red-600 mb-4">Konfirmasi Hapus</h2>
        <p class="text-sm text-slate-600">Apakah Anda yakin ingin menghapus ruangan ini?</p>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
            <button type="button" onclick="closeModal('deleteModal'); showSuccess('deleteSuccess');" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
        </div>
        <button onclick="closeModal('deleteModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- Modal Tambah -->
<div id="addModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md animate-fadeIn">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Tambah Fasilitas</h2>
        <form onsubmit="event.preventDefault(); showSuccess('addSuccess');">
            <div class="space-y-4">
                <div>
                    <label for="addId" class="block text-sm font-medium text-slate-700 mb-1">Kode Ruangan</label>
                    <input
                        type="text"
                        id="addId"
                        class="w-full px-3 py-2 border border-slate-300 rounded"
                        required
                    >
                </div>

                <div>
                    <label for="addNama" class="block text-sm font-medium text-slate-700 mb-1">Nama Ruangan</label>
                    <input
                        type="text"
                        id="addNama"
                        class="w-full px-3 py-2 border border-slate-300 rounded"
                        required
                    >
                </div>

                <div>
                    <label for="addJenis" class="block text-sm font-medium text-slate-700 mb-1">Lokasi</label>
                    <select
                        id="addJenis"
                        class="w-full px-3 py-2 border border-slate-300 rounded"
                        required
                    >
                        <option value="" disabled selected>Pilih Lokasi</option>
                        <option value="Lantai 5">Lantai 5</option>
                        <option value="Lantai 6">Lantai 6</option>
                        <option value="Lantai 7">Lantai 7</option>
                        <option value="Lantai 8">Lantai 8</option>
                    </select>
                </div>
            </div>
            <div class="mt-5 text-right">
                <button
                    type="button"
                    onclick="closeModal('addModal')"
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded mr-2"
                >Batal</button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded"
                >Tambah</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Sukses Tambah -->
<div id="addSuccess" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-30 pointer-events-none hidden">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-sm text-center animate-fadeIn pointer-events-auto">
        <h2 class="text-green-600 text-lg font-bold mb-1">Berhasil!</h2>
        <p class="text-sm text-slate-700">Ruangan berhasil ditambahkan.</p>
    </div>
</div>

<!-- Modal Sukses Edit -->
<div id="editSuccess" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-sm text-center animate-fadeIn">
        <h2 class="text-green-600 text-lg font-bold mb-1">Berhasil!</h2>
        <p class="text-sm text-slate-700">Data ruangan berhasil diperbarui.</p>
    </div>
</div>

<!-- Modal Sukses Hapus -->
<div id="deleteSuccess" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-sm text-center animate-fadeIn">
        <h2 class="text-green-600 text-lg font-bold mb-1">Berhasil!</h2>
        <p class="text-sm text-slate-700">Data ruangan berhasil dihapus.</p>
    </div>
</div>
<!-- Modal dan lainnya disesuaikan (sama seperti sebelumnya) -->

<script>
function filterTable() {
    const searchValue = document.getElementById("searchInput").value.toLowerCase();
    const lokasiValue = document.getElementById("filterLokasi").value.toLowerCase();
    const rows = document.querySelectorAll("#roomTable tr");
    let visibleCount = 0;

    rows.forEach(row => {
        if (row.id === "noDataRow") return;

        const kode = row.children[1]?.textContent?.toLowerCase() || '';
        const nama = row.children[2]?.textContent?.toLowerCase() || '';
        const lokasi = row.children[3]?.textContent?.toLowerCase() || '';

        const matchNama = nama.includes(searchValue);
        const matchLokasi = !lokasiValue || lokasi === lokasiValue;

        if (matchNama && matchLokasi) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById("noDataRow").classList.toggle("hidden", visibleCount > 0);
}

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function showSuccess(id) {
    closeModal('addModal');
    closeModal('editModal');
    closeModal('deleteModal');

    const successModal = document.getElementById(id);
    successModal.classList.remove('hidden');
    setTimeout(() => {
        successModal.classList.add('hidden');
    }, 2000);
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.3s ease forwards;
}
</style>
@endsection