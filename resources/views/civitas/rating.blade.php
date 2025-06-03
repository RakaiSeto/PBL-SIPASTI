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
            <!-- Input Cari -->
            <input id="searchInput" class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
                placeholder="Cari Deskripsi..." onkeyup="filterTable()" />

            <!-- Dropdown Tampilkan Data -->
            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="tampilData" class="text-sm text-slate-700">Tampilkan</label>
                <select id="tampilData" onchange="filterTable()"
                    class="border border-slate-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
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

    <!-- Modal Feedback -->
    <div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-lg w-[90%] max-w-lg">
            <!-- Header -->
            <div class="relative mb-4">
                <h2 class="text-2xl font-bold">Umpan Balik</h2>
                <p class="text-sm text-gray-600">Berikan penilaian untuk laporan yang sudah selesai.</p>
                <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500" onclick="tutupModal()">✕</button>
            </div>

            <!-- Form -->
            <form id="feedbackForm" class="space-y-4" onsubmit="kirimUmpanBalik(event)">
                <input type="hidden" id="laporan_id" name="laporan_id">
                <!-- Dropdown Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating (1–5)</label>
                    <select id="rating" name="rating"
                        class="w-full border border-gray-300 bg-white rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Pilih rating</option>
                        <option value="1">★☆☆☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="4">★★★★☆</option>
                        <option value="5">★★★★★</option>
                    </select>
                </div>

                <!-- Komentar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                    <textarea id="komentar" name="komentar" rows="3" placeholder="Tuliskan komentar Anda..."
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required></textarea>
                </div>

                <!-- Tombol Kirim -->
                <div class="text-right">
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Umpan
                        Balik</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentLaporanId = null;

        function bukaModal(laporanId) {
            currentLaporanId = laporanId;
            document.getElementById('laporan_id').value = laporanId;
            document.getElementById('feedbackModal').classList.remove('hidden');
        }

        function tutupModal() {
            document.getElementById('feedbackModal').classList.add('hidden');
            document.getElementById('feedbackForm').reset();
            currentLaporanId = null;
        }

        function kirimUmpanBalik(event) {
            event.preventDefault();

            const laporanId = document.getElementById('laporan_id').value;
            const rating = document.getElementById('rating').value;
            const komentar = document.getElementById('komentar').value;

            if (!laporanId || !rating || !komentar.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan isi semua kolom.',
                    timer: 3000,
                    showConfirmButton: true
                });
                return;
            }

            fetch('{{ route('civitas.rating.submit') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        laporan_id: laporanId,
                        rating: rating,
                        komentar: komentar
                    })
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 3000,
                            showConfirmButton: true
                        });
                        tutupModal();
                        $('#laporanTable').DataTable().ajax.reload();
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
                    console.error('Gagal mengirim umpan balik:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Terjadi kesalahan saat mengirim umpan balik.',
                        timer: 3000,
                        showConfirmButton: true
                    });
                });
        }

        $(document).ready(function() {
            const table = $('#laporanTable').DataTable({
                searching: false,
                lengthChange: false,
                processing: true,
                serverSide: true,
                pageLength: parseInt($('#tampilData').val()),
                ajax: {
                    type: 'POST',
                    url: '{{ route('civitas.rating.list') }}',
                    data: function(d) {
                        d.search = {
                            value: $('#searchInput').val()
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTables error:', error, thrown);
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Gagal mengambil data laporan: ' + (xhr.responseJSON?.error ||
                                'Unknown error'),
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
                        data: 'fasilitas_ruang_id',
                        name: 'fasilitas_ruang_id',
                        defaultContent: '-'
                    },
                    {
                        data: 'fasilitas_ruang_id',
                        name: 'fasilitas_ruang_id',
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
                            return '<span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">Selesai</span>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            if (data.review_pelapor !== null) {
                                return '<span class="text-gray-500 text-xs px-2 py-1 rounded uppercase font-bold">Sudah Dinilai</span>';
                            }
                            return `
                                <button onclick="bukaModal(${data.laporan_id})"
                                    class="bg-primary text-white rounded py-2 px-4 hover:bg-blue-600">
                                    Beri Feedback
                                </button>
                            `;
                        }
                    }
                ]
            });

            // Update page length when tampilData changes
            $('#tampilData').on('change', function() {
                table.page.len(parseInt(this.value)).draw();
            });

            // Filter table on search
            window.filterTable = function() {
                table.ajax.reload();
            };
        });
    </script>
@endsection
