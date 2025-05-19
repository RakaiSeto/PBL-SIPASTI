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
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('T001')">
                                <i class="fas fa-info-circle"></i> Detail
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
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('T001')">
                                <i class="fas fa-info-circle"></i> Detail
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
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('T001')">
                                <i class="fas fa-info-circle"></i> Detail
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

<div id="detailModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl w-full max-w-md p-6 relative shadow-lg ring-1 ring-gray-200 max-h-[90vh] overflow-y-auto">
        <button onclick="tutupDetailModal()" class="absolute top-2 right-2 text-gray-400 hover:text-black text-xl">
            &times;
        </button>
        <h2 class="text-xl font-bold text-black-700 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt"></i> Detail Laporan
        </h2>
        <div class="space-y-4 text-sm">
            <div class="bg-gray-50 p-3 rounded border">
                <p><span class="font-semibold text-gray-600">Ruangan:</span> <span id="detailRuangan" class="text-gray-800"></span></p>
                <p><span class="font-semibold text-gray-600">Fasilitas:</span> <span id="detailFasilitas" class="text-gray-800"></span></p>
                <p><span class="font-semibold text-gray-600">Deskripsi:</span> <span id="detailDeskripsi" class="text-gray-800"></span></p>
                <p><span class="font-semibold text-gray-600">Kategori:</span> <span id="detailKategori" class="text-gray-800"></span></p>
            </div>
            <div class="bg-gray-50 p-3 rounded border">
                <strong class="text-gray-600">Foto:</strong><br>
                <img id="detailFoto" src="" alt="Foto Fasilitas" class="mt-2 rounded-lg border w-full">
            </div>
            <div class="bg-gray-50 p-3 rounded border">
                <strong class="text-gray-600 block mb-2">Riwayat Status:</strong>
                <ul id="riwayatStatus" class="space-y-2"></ul>
            </div>
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

    const tugasDetailData = {
        'T001': {
            ruangan: 'Ruang Kelas A',
            fasilitas: 'AC',
            deskripsi: 'AC tidak menyala dan mengeluarkan suara keras.',
            kategori: 'Elektronik',
            foto: "{{ asset('assets/image/6.jpg') }}",
            riwayat: [
                { status: 'Masuk', tanggal: '06-05-2025', icon: 'fas fa-flag', color: 'text-gray-500' },
                { status: 'Diproses', tanggal: '06-05-2025', icon: 'fas fa-spinner', color: 'text-yellow-500' },
            ]
        },
        'T002': {
            ruangan: 'Ruang B',
            fasilitas: 'Lampu',
            deskripsi: 'Lampu sering mati nyala.',
            kategori: 'Listrik',
            foto: "{{ asset('assets/image/6.jpg') }}",
            riwayat: [
                { status: 'Masuk', tanggal: '06-05-2025', icon: 'fas fa-flag', color: 'text-gray-500' },
            ]
        },
        'T003': {
            ruangan: 'Ruang C',
            fasilitas: 'Pintu',
            deskripsi: 'Engsel pintu longgar.',
            kategori: 'Bangunan',
            foto: "{{ asset('assets/image/6.jpg') }}",
            riwayat: [
                { status: 'Masuk', tanggal: '06-05-2025', icon: 'fas fa-flag', color: 'text-gray-500' },
                { status: 'Diproses', tanggal: '06-05-2025', icon: 'fas fa-spinner', color: 'text-yellow-500' },
                { status: 'Selesai', tanggal: '07-05-2025', icon: 'fas fa-check-circle', color: 'text-green-600' },
            ]
        }
    };

    function openDetailModal(id) {
        const data = tugasDetailData[id];
        if (!data) return alert('Data tidak ditemukan');

        document.getElementById('detailRuangan').textContent = data.ruangan;
        document.getElementById('detailFasilitas').textContent = data.fasilitas;
        document.getElementById('detailDeskripsi').textContent = data.deskripsi;
        document.getElementById('detailKategori').textContent = data.kategori;
        document.getElementById('detailFoto').src = data.foto;

        const riwayatList = document.getElementById('riwayatStatus');
        riwayatList.innerHTML = '';
        data.riwayat.forEach(item => {
            const li = document.createElement('li');
            li.className = 'flex items-center gap-2';
            li.innerHTML = `<i class="${item.icon} ${item.color} w-4"></i> <span><strong>${item.status}:</strong> ${item.tanggal}</span>`;
            riwayatList.appendChild(li);
        });

        document.getElementById('detailModal').classList.remove('hidden');
    }

    function tutupDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endsection