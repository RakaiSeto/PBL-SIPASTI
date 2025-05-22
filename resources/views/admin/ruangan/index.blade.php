@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">

    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="text-sm font-medium text-slate-700">Filter :</label>
            <select id="filterRole" onchange="filterTable()" class="border border-slate-300 text-sm h-10 rounded px-3 pr-8">
                <option value="">Semua Lantai</option>
                <option value="Lantai 5">Lantai 5</option>
                <option value="Lantai 6">Lantai 6</option>
                <option value="Lantai 7">Lantai 7</option>
                <option value="Lantai 8">Lantai 8</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Ruangan..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>

        <button onclick="openModal('addModal')" class="h-10 px-4 text-sm text-white bg-primary rounded hover:opacity-90 transition">
            Tambah Ruangan
        </button>
    </div>

    <!-- TABEL -->
    <div class="overflow-auto rounded border border-slate-200">
        <table class="w-full text-sm text-left table-fixed">
            <thead class="bg-slate-100 text-slate-700 font-medium">
                <tr>
                    <th class="p-3 w-10">No</th>
                    <th class="p-3 w-40">Kode Ruangan</th>
                    <th class="p-3 w-32">Nama Ruangan</th>
                    <th class="p-3 w-32">Lokasi</th>
                    <th class="p-3 w-28">Aksi</th>
                </tr>
            </thead>
            <tbody id="roomTable">
                <tr class="hover:bg-slate-50 border-t border-slate-200">
                    <td class="p-3">1</td>
                    <td class="p-3">RTO1</td>
                    <td class="p-3">Ruang Teori</td>
                    <td class="p-3">Lantai 5</td>
                    <td class="p-3">
                        <div class="flex items-center gap-2">
                            <button onclick="openEdit()" class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button onclick="openDelete()" class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
               <tr id="noDataRow" class="hidden border-t border-slate-200">
    <td class="p-3 text-center text-slate-500" colspan="5">
        Tidak ada data kategori yang sesuai.
    </td>
</tr>


            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Ruangan</h2>
        <form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Data berhasil ditambahkan!');">
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="addkode" class="block mb-1 font-medium">Kode Ruangan</label>
                    <input id="addkode" type="text" class="w-full border-gray-200 px-3 py-2 rounded" placeholder="Masukkan kode ruangan" required>
                </div>
                <div>
                    <label for="addnama" class="block mb-1 font-medium">Nama Ruangan</label>
                    <input id="addnama" type="text" class="w-full border-gray-200 px-3 py-2 rounded" placeholder="Masukkan nama ruangan" required>
                </div>
                <div>
                    <label for="addLokasi" class="block mb-1 font-medium">Lokasi</label>
                    <select id="addLokasi" class="w-full border-gray-200 px-3 py-2 rounded" required>
                        <option value="">Pilih Lokasi</option>
                        <option value="Lantai 5">Lantai 5</option>
                        <option value="Lantai 6">Lantai 6</option>
                        <option value="Lantai 7">Lantai 7</option>
                        <option value="Lantai 8">Lantai 8</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>
        <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diubah!');">
            <div class="space-y-2 text-slate-800">
                <div>
                    <label class="block mb-1 font-medium text-sm">Kode Ruangan</label>
                    <input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan kode ruangan" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm">Nama Ruangan</label>
                    <input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan nama ruangan">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm">Lokasi</label>
                    <select class="w-full border-gray-200 px-2 py-2 text-sm rounded" required>
                        <option value="">Pilih Lantai</option>
                        <option value="Lantai 5">Lantai 5</option>
                        <option value="Lantai 6">Lantai 6</option>
                        <option value="Lantai 7">Lantai 7</option>
                        <option value="Lantai 8">Lantai 8</option>
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

<!-- MODAL HAPUS -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-xl font-semibold text-slate-800 mb-4">Konfirmasi Hapus</h2>
        <p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus pengguna berikut ini?</p>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
            <button type="button" onclick="closeModal('deleteModal'); showDelete('deleteSuccess');" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
        </div>
        <button onclick="closeModal('deleteModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

@include('component.popsukses')
@include('component.pophapus')

<!-- SCRIPT -->
<script>
function filterTable() {
    const searchValue = document.getElementById("searchInput").value.toLowerCase();
    const locationFilter = document.getElementById("filterRole").value.toLowerCase();
    const rows = document.querySelectorAll("#roomTable tr");
    let visibleCount = 0;

    rows.forEach(row => {
        if (row.id === "noDataRow") return;

        const kode = row.children[1].textContent.toLowerCase();
        const nama = row.children[2].textContent.toLowerCase();
        const lokasi = row.children[3].textContent.toLowerCase();

        const matchSearch = kode.includes(searchValue) || nama.includes(searchValue);
        const matchLocation = !locationFilter || lokasi === locationFilter;

        if (matchSearch && matchLocation) {
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

function openEdit() {
    openModal('editModal');
}

function openDelete() {
    openModal('deleteModal');
}
</script>
@endsection
