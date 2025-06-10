@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="bg-white p-4 rounded shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left" id="tugasTable">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="p-3">Fasilitas</th>
                        <th class="p-3">Ruangan</th>
                        <th class="p-3">Tanggal Selesai</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
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
        let currentId = null;
        var table = null;
        function searchTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#tugasTable tbody tr");

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }

        function kerjakan() {
            $.ajax(`/teknisi/tugas/kerjakan/${currentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).done(response => {
                if (response.success) {
                    showSuccess(response.message);
                    closeModal('detailModal');
                    table.ajax.reload();
                } else {
                    showError(response.message);
                }
            }).fail(error => {
                console.error('Gagal kerjakan:', error);
                showError('Gagal kerjakan laporan');
            });
        }

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        $(document).ready(function () {

            table = $('#tugasTable').DataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/teknisi/tugas/list',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataSrc: function (json) {
                            return json.data;
                        },
                        error: function (xhr, error, thrown) {
                            console.log(xhr.responseText);
                        }
                    },
                    columns: [
                        {
                            data: null,
                            name: 'no',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            orderable: false,
                        },
                        { data: 'fasilitas_nama', orderable: false, searchable: false },
                        { data: 'ruangan_nama', orderable: false, searchable: false },
                        { data: 'lapor_datetime', orderable: false, searchable: false },
                        {
                            data: null,
                            name: 'status',
                            render: function (data, type, row) {
                                if (row.status == 'rejected') {
                                    return '<span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded font-bold">Ditolak</span>';
                                } else if (row.status == 'completed') {
                                    return '<span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded font-bold">Selesai</span>';
                                } else if (row.status == 'processed') {
                                    return '<span class="bg-blue-500/20 text-blue-900 text-xs px-2 py-1 rounded font-bold">Diproses</span>';
                                } else {
                                    return '<span class="bg-yellow-500/20 text-yellow-900 text-xs px-2 py-1 rounded font-bold">Menunggu Verifikasi</span>';
                                }
                            },
                            orderable: false,
                        },
                        {
                            data: 'laporan_id',
                            orderable: false,
                            searchable: false,
                            render: function (data) {
                                return `<button onclick="openDetail(${data})" class="bg-blue-500 text-white px-4 py-2 rounded">Detail</button>`;
                            }
                        }
                    ]
                }
            );
        });

        function openDetail(id) {
            currentId = id;
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

                        // Tombol aksi
                        let actions = `
                            <div class="flex justify-between w-full items-center">
                                <button onclick="closeModal('detailModal')" class="flex items-center gap-2 bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 transition">
                                        <i class="fas fa-times"></i> Tutup</button>
                                <div class="space-x-2">
                                    ${data.is_verified && !data.is_done
                                ? `<button onclick="kerjakan(${id})" class="flex items-center gap-2 bg-yellow-600 text-white py-2 px-4 rounded hover:bg-yellow-700 transition">
                                            <i class="fas fa-check"></i>Kerjakan</button>`
                                : ''}
                                </div>
                            </div>
                            `;

                        document.getElementById('modalActions').innerHTML = actions;


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