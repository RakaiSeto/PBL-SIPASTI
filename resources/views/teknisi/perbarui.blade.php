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
                            <button class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded" onclick="openDetail('T001')">
                                <i class="fas fa-eye"></i> Detail
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
                            <button class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded" onclick="openDetail('T002')">
                                <i class="fas fa-eye"></i> Detail
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
                            <button class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded" onclick="openDetail('T003')">
                                <i class="fas fa-eye"></i> Detail
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
    function searchTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll("#tugasTable tbody tr");

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }

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
                        ? `<button onclick="alert('Selesaikan laporan ${id}')" class="flex items-center gap-2 bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition">
                            <i class="fas fa-check"></i>Selesai</button>`
                        : ''}
                </div>
            </div>
            `;

            document.getElementById('modalActions').innerHTML = actions;


        openModal('detailModal');
    }
</script>

@endsection