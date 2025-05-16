@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-sm text-gray-500">Tugas Baru</h3>
                <p class="text-lg font-bold">2</p>
            </div>
            <div class="bg-primary text-white p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M12 11v6m3-3H9" />
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-sm text-gray-500">Tugas Selesai</h3>
                <p class="text-lg font-bold">50</p>
            </div>
            <div class="bg-primary text-white p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
    <a href="/teknisi/tugas" class="block bg-white p-4 rounded shadow hover:bg-gray-100 transition">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-sm text-gray-500">Tugas Dikerjakan</h3>
                <p class="text-lg font-bold">15</p>
            </div>
            <div class="bg-primary text-white p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
        </div>
    </a>
</div>
<div class="grid lg:grid-cols-2 gap-4 mb-4">
    <div class="w-full p-4 md:p-5 min-h-[300px] flex flex-col bg-white border border-gray-200 rounded shadow">
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div class="mb-4">
                <h2 class="text-sm text-gray-500">Selesai Diperbaiki</h2>
            </div>
        </div>
        <div id="hs-multiple-bar-charts" class="flex-grow"></div>
    </div>
    <div class="relative flex flex-col w-full h-full text-gray-800 bg-white shadow-md rounded-lg bg-clip-border overflow-auto p-4">
        <h3 class="text-sm text-gray-500 mb-3 font-semibold">Sedang Dikerjakan</h3>
        <table class="w-full text-left table-auto min-w-max border-collapse">
            <thead>
                <tr>
                    <th class="p-3 border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">ID Laporan</th>
                    <th class="p-3 border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">Nama Fasilitas</th>
                    <th class="p-3 border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-slate-50 border-b border-slate-200">
                    <td class="p-3 text-sm font-semibold text-slate-800">LF010</td>
                    <td class="p-3 text-sm text-slate-600">Lift</td>
                    <td class="p-3">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('LF010')">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50 border-b border-slate-200">
                    <td class="p-3 text-sm font-semibold text-slate-800">LF011</td>
                    <td class="p-3 text-sm text-slate-600">Kursi</td>
                    <td class="p-3">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('LF011')">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50 border-b border-slate-200">
                    <td class="p-3 text-sm font-semibold text-slate-800">LF012</td>
                    <td class="p-3 text-sm text-slate-600">AC</td>
                    <td class="p-3">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('LF012')">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 border-b border-slate-200">
                    <td class="p-3 text-sm font-semibold text-slate-800">LF013</td>
                    <td class="p-3 text-sm text-slate-600">Stopkontak</td>
                    <td class="p-3">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs flex items-center gap-2" onclick="openDetailModal('LF013')">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="detailModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl w-full max-w-md p-6 relative shadow-lg ring-1 ring-gray-200 max-h-[90vh] overflow-y-auto">
        <button onclick="tutupDetailModal()" class="absolute top-2 right-2 text-gray-400 hover:text-black text-xl">
            &times;
        </button>
        <h2 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2">
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
    const incomeCtx = document.createElement("canvas");
    document.getElementById("hs-multiple-bar-charts").appendChild(incomeCtx);

    new Chart(incomeCtx, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [{
                label: "Selesai Diperbaiki",
                data: [17, 25, 30, 22, 18, 15],
                backgroundColor: "#1652B7",
                borderRadius: 5,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: { beginAtZero: true },
            },
        },
    });

    const laporanData = {
        'LF010': {
            ruangan: 'RT002',
            fasilitas: 'Lift',
            deskripsi: 'Lift macet di lantai 3',
            kategori: 'Transportasi Dalam Gedung',
            foto: "{{ asset('assets/image/6.jpg') }}",
            riwayat: [
                { status: 'Masuk', tanggal: '06-05-2025', icon: 'fas fa-flag', color: 'text-gray-500' },
                { status: 'Diproses', tanggal: '06-05-2025', icon: 'fas fa-spinner', color: 'text-yellow-500' },
            ]
        },
        'LF011': {
            ruangan: 'RT003',
            fasilitas: 'Kursi',
            deskripsi: 'Kursi Rusak',
            kategori: 'Penerangan',
            foto: "{{ asset('assets/image/6.jpg') }}",
            riwayat: [
                { status: 'Masuk', tanggal: '07-05-2025', icon: 'fas fa-flag', color: 'text-gray-500' },
                { status: 'Diproses', tanggal: '08-05-2025', icon: 'fas fa-spinner', color: 'text-yellow-500' },
            ]
        },
        'LF012': {
            ruangan: 'RT004',
            fasilitas: 'AC',
            deskripsi: 'AC bocor parah',
            kategori: 'Pendingin Ruangan',
            foto: "{{ asset('assets/image/6.jpg') }}",
            riwayat: [
                { status: 'Masuk', tanggal: '08-05-2025', icon: 'fas fa-flag', color: 'text-gray-500' },
                { status: 'Diproses', tanggal: '08-05-2025', icon: 'fas fa-spinner', color: 'text-yellow-500' },
            ]
        },
        'LF013': {
            ruangan: 'RT005',
            fasilitas: 'Stopkontak',
            deskripsi: 'Stopkontak longgar',
            kategori: 'Kelistrikan',
            foto: "{{ asset('assets/image/6.jpg') }}",
            riwayat: [
                { status: 'Masuk', tanggal: '06-05-2025', icon: 'fas fa-flag', color: 'text-gray-500' },
                { status: 'Diproses', tanggal: '07-05-2025', icon: 'fas fa-spinner', color: 'text-yellow-500' }
            ]
        }
    };

    function openDetailModal(id) {
        const data = laporanData[id];
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
