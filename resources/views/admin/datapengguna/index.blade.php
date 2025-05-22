@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">

    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="text-sm font-medium text-slate-700">Filter :</label>
            <select id="filterRole" onchange="filterTable()" class="border border-slate-300 text-sm h-10 rounded px-3 pr-8">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="sarpras">Sarpras</option>
                <option value="civitas">Civitas</option>
                <option value="teknisi">Teknisi</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Nama Lengkap..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>

        <button onclick="openModal('addModal')" class="h-10 px-4 text-sm text-white bg-primary rounded hover:opacity-90 transition">
            Tambah data
        </button>
    </div>

    <!-- TABEL -->
    <div class="overflow-auto rounded border border-slate-200">
        <table class="w-full text-sm text-left table-fixed">
            <thead class="bg-slate-100 text-slate-700 font-medium">
                <tr>
                    <th class="p-3 w-10">No</th>
                    <th class="p-3 w-40">Nama Lengkap</th>
                    <th class="p-3 w-32">Username</th>
                    <th class="p-3 w-32">Role</th>
                    <th class="p-3 w-32">Email</th>
                    <th class="p-3 w-28">Aksi</th>
                </tr>
            </thead>
            <tbody id="roomTable">
                <tr class="hover:bg-slate-50 border-t border-slate-200">
                    <td class="p-3 font-semibold text-slate-700">1</td>
                    <td class="p-3">Pebriiiiii</td>
                    <td class="p-3">peb</td>
                    <td class="p-3">Admin</td>
                    <td class="p-3">peb@gmail</td>
                    <td class="p-3">
                        <div class="flex items-center gap-2">
                            <button onclick="openDetail(this)" class="text-gray-600 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button onclick="openEdit()" class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button onclick="openDelete()" class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

                <tr id="noDataRow" class="hidden border-t border-slate-200">
                    <td class="p-3 text-center text-slate-500" colspan="6">
                        Tidak ada data yang sesuai.
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Pengguna</h2>
        <form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Data berhasil ditambahkan!');">
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="addNama" class="block mb-1 font-medium">Nama Lengkap</label>
                    <input id="addNama" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama lengkap" required>
                </div>
                <div>
                    <label for="addUsername" class="block mb-1 font-medium">Username</label>
                    <input id="addUsername" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan username" required>
                </div>
                <div>
                    <label for="addEmail" class="block mb-1 font-medium">Email</label>
                    <input id="addEmail" type="email" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan email" required>
                </div>
                <div>
                    <label for="addRole" class="block mb-1 font-medium">Role</label>
                    <select id="addRole" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="sarpras">Sarpras</option>
                        <option value="civitas">Civitas</option>
                        <option value="teknisi">Teknisi</option>
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

<!-- MODAL DETAIL -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden transition-opacity duration-300">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 flex flex-col justify-between">

        <!-- Header -->
        <div class="relative mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detail Laporan</h2>
            <button class="absolute right-0 top-0 text-gray-500 hover:text-red-500 text-xl font-semibold transition duration-200" onclick="closeModal('detailModal')">×</button>
        </div>

        <!-- Informasi Laporan -->
        <div class="flex-1">
            <div class="grid grid-cols-1 md:grid-cols-[auto,1fr] gap-4">
                <div class="w-48 aspect-[3/4] overflow-hidden rounded">
                    <img src="{{ asset('assets/image/10.jpg') }}" alt="Foto" class="w-full h-full object-cover">
                </div>
                <div class="space-y-3">
                    <div>
                        <h4 class="text-base font-medium text-gray-500">Nama Lengkap</h4>
                        <p class="text-lg text-gray-800">Agung Fradiansyah</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Username</h4>
                        <p class="text-lg text-gray-800">agungAdmin</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Role</h4>
                        <p class="text-lg text-gray-800">Admin</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                        <p class="text-lg text-gray-800">agung@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>
        <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diubah!');">
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="editNama" class="block mb-1 font-medium">Nama Lengkap</label>
                    <input id="editNama" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama lengkap" required>
                </div>
                <div>
                    <label for="editUsername" class="block mb-1 font-medium">Username</label>
                    <input id="editUsername" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan username" required>
                </div>
                <div>
                    <label for="editEmail" class="block mb-1 font-medium">Email</label>
                    <input id="editEmail" type="email" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan email" required>
                </div>
                <div>
                    <label for="editRole" class="block mb-1 font-medium">Role</label>
                    <select id="editRole" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="sarpras">Sarpras</option>
                        <option value="civitas">Civitas</option>
                        <option value="teknisi">Teknisi</option>
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
    const roleFilter = document.getElementById("filterRole").value.toLowerCase();
    const rows = document.querySelectorAll("#roomTable tr");
    let visibleCount = 0;

    rows.forEach(row => {
        if (row.id === "noDataRow") return;

        const namaLengkap = row.children[1].textContent.toLowerCase();
        const role = row.children[3].textContent.toLowerCase();

        const matchSearch = namaLengkap.includes(searchValue);
        const matchRole = !roleFilter || role === roleFilter;

        if (matchSearch && matchRole) {
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

function openDetail() {
    openModal('detailModal');
}

function openEdit() {
    openModal('editModal');
}

function openDelete() {
    openModal('deleteModal');
}
</script>
@endsection
