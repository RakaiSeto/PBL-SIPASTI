@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">
    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="text-sm font-medium text-slate-700">Filter Role:</label>
            <select id="filterRole" onchange="filterTable()" class="border border-slate-300 text-sm h-10 rounded px-3">
                <option value="">Semua Role</option>
                <option value="Admin">Admin</option>
                <option value="Sarpras">Sarpras</option>
                <option value="Civitas">Civitas</option>
                <option value="Teknisi">Teknisi</option>
            </select>
            <input
                type="text"
                id="searchInput"
                placeholder="Cari pengguna..."
                onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3"
            />
        </div>

        <button onclick="document.getElementById('myModal').classList.remove('hidden')"
            class="h-10 px-4 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Tambah Data
        </button>
    </div>

    <!-- Tabel -->
    <div class="overflow-auto rounded border border-slate-200">
        <table class="w-full text-sm text-left table-fixed">
            <thead class="bg-slate-100 text-slate-700 font-medium">
                <tr>
                    <th class="p-3 w-10">ID</th>
                    <th class="p-3 w-40">Nama Lengkap</th>
                    <th class="p-3 w-32">Username</th>
                    <th class="p-3 w-32">Role</th>
                    <th class="p-3 w-32">Email</th>
                    <th class="p-3 w-32">Password</th>
                    <th class="p-3 w-28">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <!-- Data baris -->
                <tr class="hover:bg-slate-50 border-t border-slate-200">
                    <td class="p-3 font-semibold text-slate-700">1</td>
                    <td class="p-3">pebriiiiii</td>
                    <td class="p-3">peb</td>
                    <td class="p-3">Admin</td>
                     <td class="p-3">peb@gmail</td>
                    <td class="p-3">Pebri123</td>
                    <td class="p-3">
                        <div class="flex items-center gap-2">
                            <button class="text-gray-600 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <!-- Tambahkan baris lain sesuai data -->
            </tbody>
            <tbody id="noDataRow" class="hidden">
                <tr>
                    <td colspan="6" class="text-center text-slate-500 py-4">Tidak ada data yang sesuai.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Script Filter -->
<script>
    function filterTable() {
        const searchValue = document.getElementById("searchInput").value.toLowerCase();
        const roleFilter = document.getElementById("filterRole").value;
        const rows = document.querySelectorAll("#userTable tr");
        let visibleCount = 0;

        rows.forEach(row => {
            const nama = row.children[1].textContent.toLowerCase();
            const username = row.children[2].textContent.toLowerCase();
            const role = row.children[3].textContent.trim().toLowerCase();

            const matchSearch = nama.includes(searchValue) || username.includes(searchValue);
            const matchRole = !roleFilter || role === roleFilter.toLowerCase();

            if (matchSearch && matchRole) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById("noDataRow").classList.toggle("hidden", visibleCount > 0);
    }
</script>
@endsection
