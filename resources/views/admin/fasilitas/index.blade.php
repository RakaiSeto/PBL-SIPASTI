@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">
    <!-- Filter & Pencarian -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex gap-3 w-full md:w-auto">
            <!-- Filter Jenis -->
            <div class="flex items-center gap-2">
                <label for="filterJenis" class="text-sm font-medium text-slate-700">Filter :</label>
                <select
                    id="filterJenis"
                    onchange="filterTable()"
                    class="h-10 text-sm border border-slate-300 rounded px-3 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Semua Jenis</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Jaringan">Jaringan </option>
                    <option value="Perlengkapan Kelas">Perlengkapan Kelas</option>

                </select>
            </div>

            <!-- Input Cari -->
            <div class="flex items-center gap-2">
                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari nama fasilitas..."
                    onkeyup="filterTable()"
                    class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3 focus:ring-blue-500 focus:border-blue-500"
                />
            </div>
        </div>

        <!-- Tombol Tambah -->
        <button
            onclick="document.getElementById('myModal').classList.remove('hidden')"
            class="h-10 px-4 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition"
        >
            Tambah Fasilitas
        </button>
    </div>

    <!-- Tabel Fasilitas -->
    <div class="overflow-auto border border-slate-200 rounded">
        <table class="w-full table-fixed text-sm text-left">
            <thead class="bg-slate-100 text-slate-700">
                <tr>
                    <th class="p-3 w-32">ID Fasilitas</th>
                    <th class="p-3 w-60">Nama Fasilitas</th>
                    <th class="p-3 w-40">Jenis</th>
                    <th class="p-3 w-32">Status</th>
                    <th class="p-3 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="fasilitasTable">
                <!-- Contoh Data -->
                <tr class="border-t hover:bg-slate-50">
                    <td class="p-3 font-semibold text-slate-800">F001</td>
                    <td class="p-3">Proyektor Epson</td>
                    <td class="p-3">Elektronik</td>
                    <td class="p-3">Tersedia</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <button class="text-gray-600 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr class="border-t hover:bg-slate-50">
                    <td class="p-3 font-semibold text-slate-800">F002</td>
                    <td class="p-3">Kursi Kuliah</td>
                    <td class="p-3">Furniture</td>
                    <td class="p-3">Rusak</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <button class="text-gray-600 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

                <!-- Baris Tidak Ada Data -->
                <tr id="noDataRow" class="hidden">
                    <td colspan="5" class="text-center text-slate-500 py-4">Tidak ada data yang sesuai.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Script Filter -->
<script>
    function filterTable() {
        const searchValue = document.getElementById("searchInput").value.toLowerCase();
        const jenisValue = document.getElementById("filterJenis").value.toLowerCase();
        const rows = document.querySelectorAll("#fasilitasTable tr");
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.id === "noDataRow") return;

            const nama = row.children[1].textContent.toLowerCase();
            const jenis = row.children[2].textContent.toLowerCase();

            const matchNama = nama.includes(searchValue);
            const matchJenis = !jenisValue || jenis === jenisValue;

            if (matchNama && matchJenis) {
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
