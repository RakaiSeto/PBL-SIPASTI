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
        <table class="min-w-full table-auto text-sm text-left" id="tugasTable">
            <thead class="bg-slate-100">
                <tr>
                    <th class="p-3">ID Tugas</th>
                    <th class="p-3">Fasilitas</th>
                    <th class="p-3">Tanggal Selesai</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <!-- Data contoh -->
                <tr class="hover:bg-slate-50">
                    <td class="p-3 font-semibold">T001</td>
                    <td class="p-3">AC Ruang Kelas A</td>
                    <td class="p-3">2025-05-11</td>
                    <td class="p-3 flex gap-2">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('T001')">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50">
                    <td class="p-3 font-semibold">T002</td>
                    <td class="p-3">Lampu Ruang B</td>
                    <td class="p-3">2025-05-12</td>
                    <td class="p-3 flex gap-2">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('T002')">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50">
                    <td class="p-3 font-semibold">T003</td>
                    <td class="p-3">Pintu Ruang C</td>
                    <td class="p-3">2025-05-13</td>
                    <td class="p-3 flex gap-2">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('T003')">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
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

<!-- Modal Detail Tugas -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded shadow-lg w-96">
        <h3 class="text-lg font-semibold mb-4">Detail Tugas</h3>
        <div class="mb-4">
            <p><strong>Deskripsi Tugas:</strong> <span class="modal-description"></span></p>
            <p><strong>Fasilitas:</strong> <span class="modal-fasilitas"></span></p>
        </div>
        <div class="mb-4">
            <strong>Riwayat Status:</strong>
            <ul class="modal-history list-disc pl-5">
                <!-- History will be inserted here dynamically -->
            </ul>
        </div>
        <div class="mt-4 flex justify-center gap-4">
            <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded" onclick="closeModal('detailModal')">Tutup</button>
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

    function openDetailModal(id) {
        const modalContent = document.getElementById('detailModal');
        console.log(`Opening modal for task: ${id}`); // Debugging

        let taskDetails = {};

        if (id === 'T001') {
            taskDetails = {
                description: 'Memperbaiki AC Ruang Kelas A',
                fasilitas: 'AC Ruang Kelas A',
                history: [
                    { status: 'Waktu Diterima', time: '2025-05-10 08:00' },
                    { status: 'Waktu Dikerjakan', time: '2025-05-11 09:30' },
                    { status: 'Waktu Selesai', time: '2025-05-11 15:00' }
                ]
            };
        } else if (id === 'T002') {
            taskDetails = {
                description: 'Memperbaiki Lampu Ruang B',
                fasilitas: 'Lampu Ruang B',
                history: [
                    { status: 'Waktu Diterima', time: '2025-05-11 08:00' },
                    { status: 'Waktu Dikerjakan', time: '2025-05-12 09:30' },
                    { status: 'Waktu Selesai', time: '2025-05-12 14:00' }
                ]
            };
        } else if (id === 'T003') {
            taskDetails = {
                description: 'Memperbaiki Pintu Ruang C',
                fasilitas: 'Pintu Ruang C',
                history: [
                    { status: 'Waktu Diterima', time: '2025-05-12 08:00' },
                    { status: 'Waktu Dikerjakan', time: '2025-05-13 09:30' },
                    { status: 'Waktu Selesai', time: '2025-05-13 16:00' }
                ]
            };
        }

        modalContent.querySelector('.modal-description').innerHTML = taskDetails.description;
        modalContent.querySelector('.modal-fasilitas').innerHTML = taskDetails.fasilitas;

        // Update history
        const historyList = modalContent.querySelector('.modal-history');
        historyList.innerHTML = '';
        taskDetails.history.forEach(item => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `<strong>${item.status}:</strong> ${item.time}`;
            historyList.appendChild(listItem);
        });

        // Show modal
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>

@endsection
