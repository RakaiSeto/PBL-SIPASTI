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
                    <option value="Lantai 1">Lantai 1</option>
                    <option value="Lantai 2">Lantai 2</option>
                    <option value="Lantai 3">Lantai 3</option>
                    <option value="Lantai 4">Lantai 4</option>
                    <option value="Lantai 5">Lantai 5</option>
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
                    <th class="p-3 w-32">ID Ruangan</th>
                    <th class="p-3 w-60">Nama Ruangan</th>
                    <th class="p-3 w-40">Lokasi</th>
                    <th class="p-3 w-40 text-center">Fasilitas</th>
                    <th class="p-3 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="roomTable">
                <!-- Data Ruangan -->
                <tr class="border-t hover:bg-slate-50" data-id="R001" data-nama="Ruang Teori" data-lokasi="Lantai 5">
                    <td class="p-3 font-semibold text-slate-800">R001</td>
                    <td class="p-3">Ruang Teori</td>
                    <td class="p-3">Lantai 5</td>
                    <td class="p-3 text-center">
                        <button onclick="openFasilitasModal('R001')" class="text-green-600 hover:text-green-800" title="Lihat Fasilitas">
                            <i class="fas fa-cubes"></i>
                        </button>
                    </td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <button onclick="openDetailModal(this)" class="text-gray-600 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button onclick="openEditModal(this)" class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button onclick="openDeleteModal(this)" class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

                <tr class="border-t hover:bg-slate-50" data-id="R002" data-nama="Lab Komputer" data-lokasi="Lantai 3">
                    <td class="p-3 font-semibold text-slate-800">R002</td>
                    <td class="p-3">Lab Komputer</td>
                    <td class="p-3">Lantai 3</td>
                    <td class="p-3 text-center">
                        <button onclick="openFasilitasModal('R002')" class="text-green-600 hover:text-green-800" title="Lihat Fasilitas">
                            <i class="fas fa-cubes"></i>
                        </button>
                    </td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <button onclick="openDetailModal(this)" class="text-gray-600 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button onclick="openEditModal(this)" class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button onclick="openDeleteModal(this)" class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
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

<!-- Modal Lihat Fasilitas -->
<div id="fasilitasModal" class="fixed inset-0 z-50 bg-black/40 hidden justify-center items-center">
    <div class="bg-white w-full max-w-md p-6 rounded shadow space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-slate-700">Fasilitas Ruangan</h2>
            <button onclick="closeFasilitasModal()" class="text-slate-500 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="fasilitasContent" class="text-sm text-slate-600 space-y-2">
            <!-- Konten fasilitas diisi via JS -->
        </div>
    </div>
</div>

<!-- Modal Tambah Ruangan -->
<div id="addModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md animate-fadeIn">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Tambah Ruangan</h2>
        <form onsubmit="event.preventDefault(); showSuccess('addSuccess');">
            <div class="space-y-3">
                <input 
                    type="text" 
                    placeholder="ID Ruangan" 
                    class="w-full px-3 py-2 border border-slate-300 rounded" 
                    required
                >
                <input 
                    type="text" 
                    placeholder="Nama Ruangan" 
                    class="w-full px-3 py-2 border border-slate-300 rounded"
                >
                <select 
                    class="w-full px-3 py-2 border border-slate-300 rounded" 
                    required
                >
                    <option value="" disabled selected>Pilih Lantai</option>
                    <option value="Lantai 5">Lantai 5</option>
                    <option value="Lantai 6">Lantai 6</option>
                    <option value="Lantai 7">Lantai 7</option>
                    <option value="Lantai 8">Lantai 8</option>
                </select>
            </div>
            <div class="mt-4 text-right">
                <button 
                    type="button" 
                    onclick="closeModal('addModal')" 
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded mr-2"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded"
                >
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Ruangan -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md animate-fadeIn">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-slate-800">Detail Ruangan</h2>
            <button onclick="closeModal('detailModal')" class="text-slate-500 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="detailContent" class="text-sm text-slate-700 space-y-2">
            <!-- Konten detail diisi via JS -->
        </div>
        <div class="mt-4 text-right">
            <button onclick="closeModal('detailModal')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Edit Ruangan -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md animate-fadeIn">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Edit Ruangan</h2>
        <form id="editForm" onsubmit="event.preventDefault(); showSuccess('editSuccess');">
            <input type="hidden" id="editId" />
            <div class="space-y-3">
                <input 
                    id="editIdInput"
                    type="text" 
                    placeholder="ID Ruangan" 
                    class="w-full px-3 py-2 border border-slate-300 rounded" 
                    required
                    readonly
                >
                <input 
                    id="editNamaInput"
                    type="text" 
                    placeholder="Nama Ruangan" 
                    class="w-full px-3 py-2 border border-slate-300 rounded"
                    required
                >
                <select 
                    id="editLokasiSelect"
                    class="w-full px-3 py-2 border border-slate-300 rounded" 
                    required
                >
                    <option value="" disabled>Pilih Lantai</option>
                    <option value="Lantai 5">Lantai 5</option>
                    <option value="Lantai 6">Lantai 6</option>
                    <option value="Lantai 7">Lantai 7</option>
                    <option value="Lantai 8">Lantai 8</option>
                </select>
            </div>
            <div class="mt-4 text-right">
                <button 
                    type="button" 
                    onclick="closeModal('editModal')" 
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded mr-2"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-yellow-600 text-white hover:bg-yellow-700 rounded"
                >
                    Simpan
                </button>
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
<div id="editSuccess" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-30 pointer-events-none hidden">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-sm text-center animate-fadeIn pointer-events-auto">
        <h2 class="text-green-600 text-lg font-bold mb-1">Berhasil!</h2>
        <p class="text-sm text-slate-700">Perubahan ruangan berhasil disimpan.</p>
    </div>
</div>

<script>
    // Data dummy fasilitas 
    const fasilitasData = {
        R001: ['Proyektor', 'Whiteboard', 'AC'],
        R002: ['PC Lab', 'Internet', 'AC'],
    };


    function filterTable() {
        const searchValue = document.getElementById("searchInput").value.toLowerCase();
        const lokasiValue = document.getElementById("filterLokasi").value.toLowerCase();
        const rows = document.querySelectorAll("#roomTable tr");
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.id === "noDataRow") return;
            const nama = row.children[1].textContent.toLowerCase();
            const lokasi = row.children[2].textContent.toLowerCase();
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

    function openFasilitasModal(idRuangan) {
        const modal = document.getElementById("fasilitasModal");
        const content = document.getElementById("fasilitasContent");

        const fasilitas = fasilitasData[idRuangan] || [];

        content.innerHTML = fasilitas.length > 0
            ? `<ul class="list-disc ml-5">${fasilitas.map(item => `<li>${item}</li>`).join('')}</ul>`
            : `<p class="text-center text-slate-500">Tidak ada fasilitas tercatat.</p>`;

        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    function closeFasilitasModal() {
        const modal = document.getElementById("fasilitasModal");
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }

    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function showSuccess(id) {
        closeModal('addModal');
        closeModal('editModal');
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 2000);
    }

    // Buka modal detail dan isi data
    function openDetailModal(button) {
        const row = button.closest('tr');
        const id = row.getAttribute('data-id');
        const nama = row.getAttribute('data-nama');
        const lokasi = row.getAttribute('data-lokasi');
        const detailContent = document.getElementById('detailContent');

        detailContent.innerHTML = `
            <p><strong>ID Ruangan:</strong> ${id}</p>
            <p><strong>Nama Ruangan:</strong> ${nama}</p>
            <p><strong>Lokasi:</strong> ${lokasi}</p>
        `;

        openModal('detailModal');
    }

    // Buka modal edit dan isi form
    function openEditModal(button) {
        const row = button.closest('tr');
        const id = row.getAttribute('data-id');
        const nama = row.getAttribute('data-nama');
        const lokasi = row.getAttribute('data-lokasi');

        document.getElementById('editIdInput').value = id;
        document.getElementById('editNamaInput').value = nama;
        document.getElementById('editLokasiSelect').value = lokasi;

        openModal('editModal');
    }


</script>
@endsection
