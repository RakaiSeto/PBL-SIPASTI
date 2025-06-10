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
        <h3 class="text-sm text-gray-500 mb-3 font-semibold">Tugas Perbaikan</h3>
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
                    <td class="p-3 text-sm font-semibold text-slate-800">T001</td>
                    <td class="p-3 text-sm text-slate-600">Lift</td>
                    <td class="p-3">
                        <button class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded" onclick="openDetail('T001')">
                                <i class="fas fa-eye"></i> Detail
                        </button>   
                    </td>
                </tr>

                <tr class="hover:bg-slate-50 border-b border-slate-200">
                    <td class="p-3 text-sm font-semibold text-slate-800">T002</td>
                    <td class="p-3 text-sm text-slate-600">Kursi</td>
                    <td class="p-3">
                        <button class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded" onclick="openDetail('T002')">
                                <i class="fas fa-eye"></i> Detail
                        </button> 
                    </td>
                </tr>

                <tr class="hover:bg-slate-50 border-b border-slate-200">
                    <td class="p-3 text-sm font-semibold text-slate-800">T003</td>
                    <td class="p-3 text-sm text-slate-600">AC</td>
                    <td class="p-3">
                        <button class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded" onclick="openDetail('T003')">
                                <i class="fas fa-eye"></i> Detail
                        </button> 
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 border-b border-slate-200">
                    <td class="p-3 text-sm font-semibold text-slate-800">T004</td>
                    <td class="p-3 text-sm text-slate-600">Stopkontak</td>
                    <td class="p-3">
                        <button class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded" onclick="openDetail('T003')">
                                <i class="fas fa-eye"></i> Detail
                        </button> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded shadow-lg w-[90%] max-w-2xl overflow-y-auto max-h-[90vh]">

    <!-- Header -->
    <div class="relative mb-4">
      <h2 class="text-2xl font-bold">Detail Laporan Teknisi</h2>
      <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500" onclick="closeModal('detailModal')">✕</button>
    </div>

    <!-- Informasi Laporan -->
    <div class="space-y-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kolom kiri -->
        <div class="space-y-2">
                <div>
                    <h4 class="text-sm text-gray-500 font-medium">Pelapor</h4>
                    <p class="user_id text-gray-800 text-base font-semibold">-</p>
                </div>
                <div>
                    <h4 class="text-sm text-gray-500 font-medium">Ruangan</h4>
                    <p class="ruang text-gray-800 text-base font-semibold">-</p>
                </div>
                <div>
                    <h4 class="text-sm text-gray-500 font-medium">Fasilitas</h4>
                    <p class="fasilitas text-gray-800 text-base font-semibold">-</p>
                </div>
                <div>
                    <h4 class="text-sm text-gray-500 font-medium mb-1">Deskripsi</h4>
                    <p class="deskripsi text-gray-800">-</p>
                </div>
                <div>
                    <h4 class="text-sm text-gray-500 font-medium mb-1">Tanggal</h4>
                    <p class="tanggal text-gray-800">-</p>
                </div>
                <div>
                    <h4 class="text-sm text-gray-500 font-medium mb-1">Status</h4>
                    <p class="status text-gray-800">-</p>
                </div>
        </div>

        <!-- Kolom kanan - Foto -->
        <div>
          <p class="text-sm text-gray-500 mb-1">Foto Fasilitas</p>
          <div class="border rounded overflow-hidden shadow">
            <img id="detail-photo" src="/assets/image/placeholder.jpg" alt="Foto Fasilitas" class="w-full h-auto object-cover">
          </div>
        </div>
      </div>

      <!-- Riwayat Status -->
      <div>
        <h4 class="text-sm text-gray-500 font-medium mb-2">Riwayat Status</h4>
        <ul class="bg-gray-50 p-4 rounded border space-y-2 text-sm text-gray-700">
          <li><i class="fas fa-flag w-4 inline-block"></i> <strong>Baru:</strong> <span id="statusBaru">-</span></li>
          <li><i class="fas fa-spinner text-yellow-500 w-4 inline-block"></i> <strong>Diproses:</strong> <span id="statusProses">-</span></li>
          <li><i class="fas fa-check-circle text-green-600 w-4 inline-block"></i> <strong>Selesai:</strong> <span id="statusSelesai">-</span></li>
        </ul>
      </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-end gap-3 border-t pt-4" id="modalActions">
      <!-- Tombol aksi akan dimuat dinamis lewat JS -->
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

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openDetail(id) {
        // Data dummy
        const dummyData = {
            'T001': {
                user_id: 'Admin1',
                fasilitas_ruang: {
                    ruangan: {
                        ruangan_nama: 'Kelas A',
                        lantai: 1
                    },
                    fasilitas: {
                        fasilitas_nama: 'AC Ruang Kelas A'
                    }
                },
                deskripsi_laporan: 'AC tidak dingin.',
                lapor_datetime: '2025-05-11T08:00:00',
                is_verified: true,
                is_done: false,
                verifikasi_datetime: '2025-05-12T09:00:00',
                selesai_datetime: null,
                lapor_foto_url: '/assets/image/ac.jpg'
            },
            'T002': {
                user_id: 'Admin2',
                fasilitas_ruang: {
                    ruangan: {
                        ruangan_nama: 'Ruang B',
                        lantai: 2
                    },
                    fasilitas: {
                        fasilitas_nama: 'Lampu Ruang B'
                    }
                },
                deskripsi_laporan: 'Lampu berkedip.',
                lapor_datetime: '2025-05-12T10:00:00',
                is_verified: true,
                is_done: false,
                verifikasi_datetime: '2025-05-13T10:00:00',
                selesai_datetime: null,
                lapor_foto_url: '/assets/image/lamp.jpg'
            },
            'T003': {
                user_id: 'Admin3',
                fasilitas_ruang: {
                    ruangan: {
                        ruangan_nama: 'Ruang C',
                        lantai: 3
                    },
                    fasilitas: {
                        fasilitas_nama: 'Pintu Ruang C'
                    }
                },
                deskripsi_laporan: 'Engsel pintu rusak.',
                lapor_datetime: '2025-05-13T11:00:00',
                is_verified: true,
                is_done: false,
                verifikasi_datetime: '2025-05-12T09:00:00',
                selesai_datetime: null,
                lapor_foto_url: '/assets/image/pintu.jpg'
            }
        };

        const data = dummyData[id];

        if (!data) return alert("Data tidak ditemukan!");

        document.querySelector('.user_id').textContent = data.user_id ?? '-';
        document.querySelector('.ruang').textContent = data.fasilitas_ruang?.ruangan?.ruangan_nama + ' - lantai ' + data.fasilitas_ruang?.ruangan?.lantai ?? '-';
        document.querySelector('.fasilitas').textContent = data.fasilitas_ruang?.fasilitas?.fasilitas_nama ?? '-';
        document.querySelector('.deskripsi').textContent = data.deskripsi_laporan ?? '-';
        document.querySelector('.tanggal').textContent = data.lapor_datetime ? new Date(data.lapor_datetime).toLocaleDateString('id-ID') : '-';
        document.querySelector('.status').textContent =
            data.is_done && !data.is_verified ? 'Ditolak' :
            data.is_done ? 'Selesai' :
            data.is_verified ? 'Diproses' : 'Menunggu Verifikasi';

        document.getElementById('statusBaru').textContent = data.lapor_datetime ?? '-';
        document.getElementById('statusProses').textContent = data.verifikasi_datetime ?? '-';
        document.getElementById('statusSelesai').textContent = data.selesai_datetime ?? '-';

        document.getElementById('detail-photo').src = data.lapor_foto_url ?? '/assets/image/placeholder.jpg';

        // Tombol aksi
        let actions = `
            <div class="flex justify-between w-full items-center">
                <button onclick="closeModal('detailModal')" class="flex items-center gap-2 bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 transition">
                        <i class="fas fa-times"></i> Tutup</button>
                <div class="space-x-2">
                    ${data.is_verified && !data.is_done
                        ? `<button onclick="alert('Selesaikan laporan ${id}')" class="flex items-center gap-2 bg-yellow-600 text-white py-2 px-4 rounded hover:bg-yellow-700 transition">
                            <i class="fas fa-check"></i>Kerjakan</button>`
                        : ''}
                </div>
            </div>
            `;

            document.getElementById('modalActions').innerHTML = actions;


        openModal('detailModal');
    }
</script>
@endsection
