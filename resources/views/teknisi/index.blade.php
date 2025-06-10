@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Tugas Baru</h3>
                    <p class="text-lg font-bold">{{ $tugasBaru }}</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
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
                    <p class="text-lg font-bold">{{ $tugasSelesai }}</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
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
                    <p class="text-lg font-bold">{{ $tugasDikerjakan }}</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
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
        <div
            class="relative flex flex-col w-full h-full text-gray-800 bg-white shadow-md rounded-lg bg-clip-border overflow-auto p-4">
            <h3 class="text-sm text-gray-500 mb-3 font-semibold">Tugas Perbaikan</h3>
            <table class="w-full text-left table-auto min-w-max border-collapse">
                <thead>
                    <tr>
                        <th class="p-3 border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">ID Laporan
                        </th>
                        <th class="p-3 border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">Nama
                            Fasilitas</th>
                        <th class="p-3 border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($last3tugas as $tugas)
                        <tr class="hover:bg-slate-50 border-b border-slate-200">
                            <td class="p-3 text-sm font-semibold text-slate-800">{{ $tugas->laporan_id }}</td>
                            <td class="p-3 text-sm text-slate-600">{{ $tugas->fasilitas_ruang->fasilitas->fasilitas_nama }} -
                                {{ $tugas->fasilitas_ruang->ruangan->ruangan_nama }}
                            </td>
                            <td class="p-3">
                                <button
                                    class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded"
                                    onclick="openDetail('{{ $tugas->laporan_id }}')">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
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
                <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500"
                    onclick="closeModal('detailModal')">✕</button>
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
                            <img id="detail-photo" src="/assets/image/placeholder.jpg" alt="Foto Fasilitas"
                                class="w-full h-auto object-cover">
                        </div>
                    </div>
                </div>

                <!-- Riwayat Status -->
                <div>
                    <h4 class="text-sm text-gray-500 font-medium mb-2">Riwayat Status</h4>
                    <ul class="bg-gray-50 p-4 rounded border space-y-2 text-sm text-gray-700">
                        <li><i class="fas fa-flag w-4 inline-block"></i> <strong>Baru:</strong> <span
                                id="statusBaru">-</span></li>
                        <li><i class="fas fa-spinner text-yellow-500 w-4 inline-block"></i> <strong>Diproses:</strong> <span
                                id="statusProses">-</span></li>
                        <li><i class="fas fa-check-circle text-green-600 w-4 inline-block"></i> <strong>Selesai:</strong>
                            <span id="statusSelesai">-</span>
                        </li>
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
                labels: [@foreach ($bulanLaporan as $bulan) "{{ $bulan }}", @endforeach],
                datasets: [{
                    label: "Selesai Diperbaiki",
                    data: [@foreach ($jumlahLaporanSelesai as $jumlah) {{ $jumlah }}, @endforeach],
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
            fetch(`/teknisi/detail/${id}`, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        const data = response.data;
                        openModal('detailModal');
                        document.querySelector('.user_id').textContent = data.user.fullname ?? '-';
                        document.querySelector('.ruang').textContent = data.fasilitas_ruang.ruangan.ruangan_nama ?
                            data.fasilitas_ruang.ruangan.ruangan_nama + ' - lantai ' + data.fasilitas_ruang.ruangan.lantai :
                            '-';
                        document.querySelector('.fasilitas').textContent = data.fasilitas_ruang.fasilitas.fasilitas_nama ??
                            '-';
                        document.querySelector('.deskripsi').textContent = data.deskripsi_laporan ?? '-';
                        document.querySelector('.tanggal').textContent = data.lapor_datetime ?
                            new Date(data.lapor_datetime).toLocaleDateString('id-ID') :
                            '-';
                        document.querySelector('.status').textContent = data.is_done && !data.is_verified ?
                            'Ditolak' :
                            data.is_done ?
                                'Selesai' :
                                data.is_verified ?
                                    'Diproses' :
                                    'Menunggu Verifikasi';

                        document.getElementById('statusBaru').textContent = data.lapor_datetime ?? '-';
                        document.getElementById('statusProses').textContent = data.verifikasi_datetime ?? '-';
                        document.getElementById('statusSelesai').textContent = data.selesai_datetime ?? '-';

                        // Ganti foto laporan
                        const img = document.getElementById('detail-photo');
                        img.src = data.lapor_foto_url ?? '/assets/profile/default.jpg';

                        document.getElementById('modalActions').innerHTML = `
                                        <button onclick="closeModal('detailModal')"
                                            class="flex items-center gap-2 bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 transition">
                                            <i class="fas fa-times"></i> Tutup
                                        </button>`
                    } else {
                        showError(response.message);
                    }
                })
                .catch(error => {
                    console.error('Gagal ambil data:', error);
                    showError('Gagal mengambil detail laporan');
                });
        }
    </script>
@endsection