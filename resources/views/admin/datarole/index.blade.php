@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">

    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="text-sm font-medium text-slate-700">Filter :</label>
            <select id="filterRole" onchange="filterTable()" class="border border-slate-300 text-sm h-10 rounded px-3 pr-8">
                <option value="">Semua Role</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Furniture">Furniture</option>
                <option value="Jaringan">Jaringan</option>
                <option value="Perlengkapan Kelas">Perlengkapan Kelas</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Role..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>

        {{-- <button onclick="openModal('addModal')" class="h-10 px-4 text-sm text-white bg-primary rounded hover:opacity-90 transition">
            Tambah Role
        </button> --}}

        <div class="flex gap-2">
             <a href="{{ route('admin.datapengguna.export_pdf') }}"
   class="h-10 px-4 text-sm text-white bg-green-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
  Export PDF
</a>

    <a href="{{ route('admin.datapengguna.export_pdf') }}"
   class="h-10 px-4 text-sm text-white bg-red-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
  Export PDF
</a>

    <button onclick="openModal('addModal')" class="h-10 px-4 text-sm text-white bg-primary rounded hover:opacity-90 transition">
            Tambah Role
        </button>
  </div>
    </div>

    <!-- TABEL -->
    <div class="overflow-auto rounded border border-slate-200">
        <table class="w-full text-sm text-left table-fixed">
            <thead class="bg-slate-100 text-slate-700 font-medium">
                <tr>
                   <th class="p-3 w-10">No</th>
                    <th class="p-3 w-40">ID Role</th>
                    <th class="p-3 w-32">Nama Role</th>
                    <th class="p-3 w-28">Aksi</th>
                </tr>
            </thead>
            <tbody id="facilityTable">
    <tr class="hover:bg-slate-50 border-t border-slate-200">
        <td class="p-3 ">1</td>
        <td class="p-3">F001</td>
        <td class="p-3">Ac</td>
        <td class="p-3">
            <div class="flex items-center gap-2">
                <button onclick="openEdit()" class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                <button onclick="openDelete()" class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>
        </td>
    </tr>
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
        <h2 class="text-2xl font-semibold mb-4">Tambah Role</h2>
        <form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Role berhasil ditambahkan!');">
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="addId" class="block mb-1 font-medium">ID Role</label>
                    <input id="addId" type="text" class="w-full border-gray-200 px-3 py-2 rounded" placeholder="Masukkan ID Role" required>
                </div>
                <div>
                    <label for="addNama" class="block mb-1 font-medium">Nama Role</label>
                    <input id="addNama" type="text" class="w-full border-gray-200 px-3 py-2 rounded" placeholder="Masukkan nama Role" required>
                </div>
                <div>
                    <label for="addKategori" class="block mb-1 font-medium">Kategori</label>
                    <select id="addKategori" class="w-full border-gray-200 px-3 py-2 rounded" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Lainnya">Lainnya</option>
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
        <h2 class="text-2xl font-semibold mb-4">Edit Role</h2>
        <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Role berhasil diubah!');">
            <div class="space-y-2 text-slate-800">
                <div>
                    <label class="block mb-1 font-medium text-sm">ID Role</label>
                    <input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan ID Role" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm">Nama Role</label>
                    <input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan nama Role">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm">Kategori</label>
                    <select class="w-full border-gray-200 px-2 py-2 text-sm rounded" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Lainnya">Lainnya</option>
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
    const selectedCategory = document.getElementById("filterRole").value.toLowerCase();
    const rows = document.querySelectorAll("#facilityTable tr");
    let visibleCount = 0;

    rows.forEach(row => {
        if (row.id === "noDataRow") return;

        const id = row.children[1].textContent.toLowerCase();
        const nama = row.children[2].textContent.toLowerCase();
        const kategori = row.children[3].textContent.toLowerCase();

        const matchSearch = id.includes(searchValue) || nama.includes(searchValue) || kategori.includes(searchValue);
        const matchCategory = !selectedCategory || kategori === selectedCategory;

        if (matchSearch && matchCategory) {
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
