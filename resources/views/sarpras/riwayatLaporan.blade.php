@extends('layouts.app')

@section('content')
    <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #kategorisasiTable th,
        #kategorisasiTable td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="bg-white p-4 rounded shadow space-y-4 text-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3 flex-wrap">
                <label for="filterFasilitas" class="font-medium text-slate-700">Filter Fasilitas:</label>
                <select id="filterFasilitas" onchange="filterTable()"
                    class="border border-slate-300 h-10 rounded text-sm px-3 pr-8">
                    <option value="">Semua Fasilitas</option>
                    <option value="1">AC</option>
                    <option value="2">Proyektor</option>
                    <option value="3">Kipas Angin</option>
                    <option value="4">Lampu</option>
                </select>

                <input type="text" id="searchInput" placeholder="Cari Deskripsi..." onkeyup="filterTable()"
                    class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
            </div>

            <div class="flex items-center gap-2">
                <label for="tampilData" class="text-slate-700">Tampilkan:</label>
                <select id="tampilData" onchange="filterTable()" class="border border-slate-300 rounded px-2 py-1 text-sm">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-auto">
            <table id="kategorisasiTable" class="w-full text-left table-fixed border border-slate-200 rounded"
                style="border-collapse: collapse;">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="p-3 w-10">No</th>
                        <th class="p-3 w-32">Ruang</th>
                        <th class="p-3 w-32">Fasilitas</th>
                        <th class="p-3 w-28">Tanggal</th>
                        <th class="p-3 w-28">Status</th>
                        <th class="p-3 w-28">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal Detail -->
        <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded shadow-lg w-[90%] max-w-2xl overflow-y-auto max-h-[90vh]">
                <!-- Header -->
                <div class="relative mb-4">
                    <h2 class="text-2xl font-bold">Detail Laporan Sarpras</h2>
                    <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500"
                        onclick="closeModal('detailModal')">✕</button>
                </div>

                <!-- Informasi Laporan -->
                <div class="space-y-6 mb-6">
                    <!-- Info Utama -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                        <!-- Foto -->
                        <div>
                            <h4 class="text-sm text-gray-500 font-medium mb-1">Foto Fasilitas</h4>
                            <div class="rounded overflow-hidden shadow border">
                                <img id="detail-photo" src="/assets/image/placeholder.jpg" alt="Foto Fasilitas"
                                    class="w-full h-auto object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Status (optional section, bisa diisi dinamis pakai JS juga) -->
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium mb-2">Riwayat Status</h4>
                        <div class="bg-gray-50 p-4 rounded border">
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-flag text-gray-500 w-4"></i>
                                    <span><strong>Baru:</strong> <span id="statusBaru">-</span></span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-spinner text-yellow-500 w-4"></i>
                                    <span><strong>Diproses:</strong> <span id="statusProses">-</span></span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-600 w-4"></i>
                                    <span><strong>Selesai:</strong> <span id="statusSelesai">-</span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex justify-end gap-3 border-t pt-4" id="modalActions">
                    <!-- Tombol aksi akan dimuat via JS -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // MODAL HANDLING
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openDetail(id) {
            fetch(`/sarpras/laporan/detail/${id}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
                            data.fasilitas_ruang.ruangan.ruangan_nama + ' - lantai ' + data.fasilitas_ruang.ruangan
                            .lantai :
                            '-';
                        document.querySelector('.fasilitas').textContent = data.fasilitas_ruang.fasilitas
                            .fasilitas_nama ??
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
                        img.src = '/assets/image/AC_RUSAK.jpg';


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

        // SUBMIT PENILAIAN
        function submitPenilaian() {
            const form = document.getElementById('penilaianForm');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            // Logika pengiriman data penilaian ke server (belum diimplementasikan)
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: 'Penilaian berhasil disimpan',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                closeModal('detailModal');
                $('#kategorisasiTable').DataTable().ajax.reload();
            });
        }

        // NOTIFIKASI
        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: message,
                timer: 3000,
                showConfirmButton: true
            });
        }

        // DATA TABLE INITIALIZATION
        $(document).ready(function() {
            const table = $('#kategorisasiTable').DataTable({
                searching: false,
                lengthChange: false,
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: {
                    type: "POST",
                    url: '{{ route('sarpras.laporan.list') }}',
                    data: function(d) {
                        d.fasilitas = $('#filterFasilitas').val();
                        d.search = $('#searchInput').val();
                        d.status = 'completed,rejected'; // Filter untuk Selesai dan Ditolak
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    error: function(xhr) {
                        showError('Gagal mengambil data laporan');
                    }
                },
                columns: [{
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'ruangan_nama',
                        name: 'ruangan_nama',
                        defaultContent: '-'
                    },
                    {
                        data: 'fasilitas_nama',
                        name: 'fasilitas_nama',
                        defaultContent: '-'
                    },
                    {
                        data: 'lapor_datetime',
                        name: 'lapor_datetime',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                        }
                    },
                    {
                        data: null,
                        name: 'status',
                        render: function(data, type, row) {
                            if (row.status == 'completed') {
                                return '<span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">Selesai</span>';
                            } else if (row.status == 'rejected') {
                                return '<span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded uppercase font-bold">Ditolak</span>';
                            } else if (row.status == 'processed') {
                                return '<span class="bg-yellow-500/20 text-yellow-900 text-xs px-2 py-1 rounded uppercase font-bold">Diproses</span>';
                            }
                            return '-';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <div class="flex gap-2" >
                                    <button onclick="openDetail(${data.laporan_id})" title="Detail"
                                        class="flex items-center gap-1 px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                        </div>
                                `;
                        }
                    }
                ]
            });

            window.filterTable = function() {
                table.ajax.reload();
            };

            $('#tampilData').on('change', function() {
                table.page.len($(this).val()).draw();
            });
        });
    </script>
@endsection
