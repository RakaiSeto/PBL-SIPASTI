@extends('layouts.app')

@section('content')
    <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #laporanTable th,
        #laporanTable td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #laporanTable .dt-buttons {
            margin-bottom: 10px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">
            <!-- Filter dan Pencarian -->
            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="filterStatus" class="text-sm text-slate-700">Fasilitas</label>
                <select id="filterStatus" onchange="filterTable()"
                    class="border border-slate-300 rounded px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
                    <option value="">Semua</option>
                    <option value="1">Menunggu Verifikasi</option>
                    <option value="2">Diproses</option>
                    <option value="3">Diterima</option>
                    <option value="4">Ditolak</option>
                </select>

                <input id="searchInput"
                    class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
                    placeholder="Cari Fasilitas..." onkeyup="filterTable()" />
            </div>

            <!-- Dropdown Tampilkan Data -->
            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="tampilData" class="text-sm text-slate-700">Tampilkan</label>
                <select id="tampilData" onchange="filterTable()"
                    class="border border-slate-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table id="laporanTable" class="w-full table-auto text-sm text-left">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        <th class="p-3">No</th>
                        <th class="p-3">Ruang</th>
                        <th class="p-3">Fasilitas</th>
                        <th class="p-3">Tanggal</th>
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
                <h2 class="text-2xl font-bold">Detail Laporan</h2>
                <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500"
                    onclick="tutupDetailModal()">✕</button>
            </div>

            <!-- Informasi Laporan -->
            <div class="space-y-6 mb-6">
                <!-- Info Utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <div>
                            <h4 class="text-sm text-gray-500 font-medium">Pelapor</h4>
                            <p class="pelapor text-gray-800 text-base">-</p>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-500 font-medium">Ruangan</h4>
                            <p class="ruang text-gray-800 text-base">-</p>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-500 font-medium">Fasilitas</h4>
                            <p class="fasilitas text-gray-800 text-base">-</p>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-500 font-medium mb-1">Deskripsi</h4>
                            <p class="deskripsi text-gray-800 text-base">-</p>
                        </div>
                        {{-- <div>
                            <h4 class="text-sm text-gray-500 font-medium mb-1">Kategori</h4>
                            <p class="kategori text-gray-800">-</p>
                        </div> --}}
                    </div>

                    <!-- Foto -->
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium mb-1">Foto Fasilitas</h4>
                        <div class="rounded overflow-hidden shadow border">
                            <img id="detail-photo" src="{{ asset('assets/profile/default.jpg') }}" alt="Foto Fasilitas"
                                class="w-full h-auto object-cover">
                        </div>
                    </div>
                </div>

                <!-- Riwayat Status -->
                <div>
                    <h4 class="text-sm text-gray-500 font-medium mb-2">Riwayat Status</h4>
                    <div class="bg-gray-50 p-4 rounded border">
                        <ul class="space-y-2 text-sm text-gray-700" id="riwayatStatus">
                            <!-- Riwayat akan dimuat di sini -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tombol Tutup -->
            <div class="flex justify-end gap-3 border-t pt-4">
                <button onclick="tutupDetailModal()"
                    class="flex items-center gap-2 bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 transition">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // MODAL HANDLING
        function bukaDetailModal(id) {
            fetch(`/civitas/status-laporan/${id}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        const data = response.data;
                        document.getElementById('detailModal').classList.remove('hidden');

                        // Isi data yang sudah di-join
                        document.querySelector('.pelapor').textContent = data.user_fullname ?? '-';
                        document.querySelector('.ruang').textContent = data.ruangan_nama ?? '-';
                        document.querySelector('.fasilitas').textContent = data.fasilitas_nama ?? '-';
                        document.querySelector('.deskripsi').textContent = data.deskripsi_laporan ?? '-';

                        // Ganti foto
                        const img = document.getElementById('detail-photo');
                        img.src = data.lapor_foto_url ?? "{{ asset('assets/profile/default.jpg') }}";

                        // Riwayat Status
                        const riwayatStatus = document.getElementById('riwayatStatus');
                        let riwayatHtml = `
                <li class="flex items-center gap-2">
                    <i class="fas fa-flag text-gray-500 w-4"></i>
                    <span><strong>Baru:</strong>
                        ${data.lapor_datetime ?
                        new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
                .format(new Date(data.lapor_datetime)) : '-'}
                        </span>
                </li>
            `;
                        if (data.is_verified || data.is_done) {
                            riwayatHtml += `
                    <li class="flex items-center gap-2">
                        <i class="fas fa-spinner text-yellow-500 w-4"></i>
                        <span><strong>Diproses:</strong>
                            ${data.verifikasi_datetime ?
                                new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
                                    .format(new Date(data.verifikasi_datetime)) : '-'}
                        </span>
                    </li>
                `;
                        }
                        if (data.is_done) {
                            const status = data.is_verified ? 'Selesai' : 'Ditolak';
                            const icon = data.is_verified ? 'fa-check-circle text-green-600' :
                                'fa-times-circle text-red-600';
                            riwayatHtml += `

                    <li class="flex items-center gap-2">
                        <i class="fas ${icon} w-4"></i>
                        <span><strong>${status}:</strong> ${data.lapor_datetime ? new Date(data.lapor_datetime).toLocaleDateString('id-ID') : '-'}</span>
                    </li>
                `;
                        }
                        riwayatStatus.innerHTML = riwayatHtml;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: response.message,
                            timer: 3000,
                            showConfirmButton: true
                        });
                    }
                })
                .catch(error => {
                    console.error('Gagal ambil data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Gagal mengambil detail laporan',
                        timer: 3000,
                        showConfirmButton: true
                    });
                });
        }


        function tutupDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // DATA TABLE INITIALIZATION
        $(document).ready(function() {
            const table = $('#laporanTable').DataTable({
                searching: false,
                lengthChange: false,
                processing: true,
                serverSide: true,
                pageLength: parseInt($('#tampilData').val()),
                ajax: {
                    type: "POST",
                    url: '{{ route('civitas.status-laporan.list') }}',
                    data: function(d) {
                        d.status = $('#filterStatus').val(); // gunakan nama 'status'
                        d.search = $('#searchInput').val();
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Gagal mengambil data laporan',
                            timer: 3000,
                            showConfirmButton: true
                        });
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
                            if (row.is_done && !row.is_verified) {
                                return '<span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded uppercase font-bold">Ditolak</span>';
                            } else if (row.is_done) {
                                return '<span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">Selesai</span>';
                            } else if (row.is_verified) {
                                return '<span class="bg-blue-500/20 text-blue-900 text-xs px-2 py-1 rounded uppercase font-bold">Diproses</span>';
                            } else {
                                return '<span class="bg-yellow-500/20 text-yellow-900 text-xs px-2 py-1 rounded uppercase font-bold">Menunggu Verifikasi</span>';
                            }
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <div class="flex gap-2">
                                    <button onclick="bukaDetailModal(${data.laporan_id})" title="Detail"
                                        class="bg-primary text-white rounded py-2 px-4 hover:bg-blue-700 gap-x-4">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });

            // Update page length when tampilData changes
            $('#tampilData').on('change', function() {
                table.page.len(parseInt(this.value)).draw();
            });

            // Filter table
            window.filterTable = function() {
                table.ajax.reload();
            };
        });
    </script>
@endsection
