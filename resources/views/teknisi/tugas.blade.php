@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4">
        <div class="relative w-full md:w-3/4 lg:w-1/4">
            <input
                type="text"
                placeholder="Cari data..."
                class="w-full pr-12 pl-4 py-2 text-sm border border-slate-200 rounded-md focus:ring-2 focus:ring-blue-500"
                id="searchInput"
                onkeyup="searchTable()"
            />
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 absolute right-3 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M18 10a8 8 0 10-8 8 8 8 0 008-8z" />
            </svg>
        </div>
    </div>    

    <div class="overflow-x-auto">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left" id="tugasTable">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="p-3">ID Tugas</th>
                        <th class="p-3">Fasilitas</th>
                        <th class="p-3">Prioritas</th>
                        <th class="p-3">Tanggal Tugas</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-semibold">T001</td>
                        <td class="p-3">AC Ruang Kelas A</td>
                        <td class="p-3">
                            <span class="text-red-600 font-semibold">Tinggi 
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </span>
                        </td>
                        <td class="p-3">2025-05-11</td>
                        <td class="p-3 flex gap-2">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openTerimaModal()">
                                <i class="fas fa-check-circle"></i> Terima
                            </button>
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openPerbaruiModal()">
                                <i class="fas fa-edit"></i> Perbarui
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-semibold">T002</td>
                        <td class="p-3">Lampu Ruang B</td>
                        <td class="p-3">
                            <span class="text-orange-600 font-semibold">Sedang</span>
                        </td>
                        <td class="p-3">2025-05-12</td>
                        <td class="p-3 flex gap-2">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openTerimaModal()">
                                <i class="fas fa-check-circle"></i> Terima
                            </button>
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openPerbaruiModal()">
                                <i class="fas fa-edit"></i> Perbarui
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-semibold">T003</td>
                        <td class="p-3">Pintu Ruang C</td>
                        <td class="p-3">
                            <span class="text-green-600 font-semibold">Rendah</span>
                        </td>
                        <td class="p-3">2025-05-13</td>
                        <td class="p-3 flex gap-2">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openTerimaModal()">
                                <i class="fas fa-check-circle"></i> Terima
                            </button>
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openPerbaruiModal()">
                                <i class="fas fa-edit"></i> Perbarui
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end items-center mt-4 text-sm">
        <div class="flex space-x-1">
            <button class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">1</button>
            <button class="px-3 py-1 rounded bg-white border hover:bg-gray-100">2</button>
            <button class="px-3 py-1 rounded bg-white border hover:bg-gray-100">3</button>
            <button class="px-3 py-1 rounded bg-white border hover:bg-gray-100">Selanjutnya</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Terima -->
<div id="terimaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded shadow-lg w-128">
        <h3 class="text-lg font-semibold mb-4 text-center">Konfirmasi Terima Tugas</h3>
        <p>Apakah Anda yakin ingin menerima tugas ini?</p>
        <div class="mt-4 flex justify-center gap-4">
            <button class="px-4 py-2 bg-green-500 text-white rounded" onclick="terimaTugas()">Terima</button>
            <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded" onclick="closeModal('terimaModal')">Batal</button>
        </div>
    </div>
</div>

<!-- Modal Perbarui Status -->
<div id="perbaruiModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded shadow-lg w-96">
        <h3 class="text-lg font-semibold mb-4">Perbarui Status Tugas</h3>
        <div class="mb-4">
            <label for="status" class="block">Status</label>
            <select id="status" class="w-full border border-slate-300 rounded px-4 py-2 text-sm">
                <option value="on-progress">Sedang Dikerjakan</option>
                <option value="completed">Selesai</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="catatan" class="block">Catatan</label>
            <textarea id="catatan" class="w-full border border-slate-300 rounded px-4 py-2 text-sm" placeholder="Tambahkan catatan..."></textarea>
        </div>
        <div class="mt-4 flex justify-center gap-4">
            <button class="px-4 py-2 bg-yellow-500 text-white rounded" onclick="perbaruiStatus()">Perbarui Status</button>
            <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded" onclick="closeModal('perbaruiModal')">Batal</button>
        </div>
    </div>
</div>

<script>
    function searchTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll("#tugasTable tbody tr");

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }

    function openTerimaModal() {
        document.getElementById('terimaModal').classList.remove('hidden');
    }

    function openPerbaruiModal() {
        document.getElementById('perbaruiModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function terimaTugas() {
        alert('Tugas telah diterima!');
        closeModal('terimaModal');
    }

    function perbaruiStatus() {
        const status = document.getElementById('status').value;
        const catatan = document.getElementById('catatan').value;
        alert(`Status telah diperbarui menjadi: ${status}\nCatatan: ${catatan}`);
        closeModal('perbaruiModal');
    }
</script>

@endsection