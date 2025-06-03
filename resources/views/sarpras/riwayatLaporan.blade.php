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
        <div id="detailModal"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50 transition-opacity duration-300">
            <div class="bg-white rounded-xl p-6 w-[95%] max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl flex flex-col">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Penilaian SPK</h2>
                    <button class="text-gray-500 hover:text-red-500 transition" onclick="closeModal('detailModal')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Konten 2 Kolom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-grow">
                    <!-- Kiri: Info Kerusakan -->
                    <div class="space-y-4">
                        <img id="detail-photo" src="{{ asset('assets/image/placeholder.jpg') }}" alt="Foto Kerusakan"
                            class="rounded border w-full object-cover h-60 shadow-sm">
                        <div>
                            <p class="text-sm text-gray-500">Nama Fasilitas</p>
                            <p class="fasilitas text-gray-800 font-medium">-</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Keterangan</p>
                            <p class="deskripsi text-gray-800 font-medium">-</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Laporan</p>
                            <p class="tanggal text-gray-800 font-medium">-</p>
                        </div>
                    </div>

                    <!-- Kanan: Form Penilaian -->
                    <form id="penilaianForm" class="space-y-4 text-sm">
                        <div class="grid grid-cols-1 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Kerusakan</label>
                                <select name="kerusakan"
                                    class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                                    required>
                                    <option value="1">Sangat ringan (1)</option>
                                    <option value="2">Ringan (2)</option>
                                    <option value="3">Sedang (3)</option>
                                    <option value="4">Berat (4)</option>
                                    <option value="5">Sangat berat (5)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Dampak</label>
                                <select name="dampak"
                                    class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                                    required>
                                    <option value="1">Sangat rendah (1)</option>
                                    <option value="2">Rendah (2)</option>
                                    <option value="3">Sedang (3)</option>
                                    <option value="4">Tinggi (4)</option>
                                    <option value="5">Sangat tinggi (5)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Frekuensi</label>
                                <select name="frekuensi"
                                    class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                                    required>
                                    <option value="1">Sangat jarang (1)</option>
                                    <option value="2">Jarang (2)</option>
                                    <option value="3">Sering (3)</option>
                                    <option value="4">Sangat sering (4)</option>
                                    <option value="5">Selalu digunakan (5)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Jumlah Pelapor</label>
                                <select name="pelapor"
                                    class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                                    required>
                                    <option value="1">
                                        < 5 (1)</option>
                                    <option value="2">5-10 (2)</option>
                                    <option value="3">11-20 (3)</option>
                                    <option value="4">21-50 (4)</option>
                                    <option value="5">> 50 (5)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Waktu Kerusakan</label>
                                <select name="waktu_kerusakan"
                                    class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                                    required>
                                    <option value="1">
                                        < 1 hari (1)</option>
                                    <option value="2">1-2 hari (2)</option>
                                    <option value="3">3-5 hari (3)</option>
                                    <option value="4">6-14 hari (4)</option>
                                    <option value="5">> 14 hari (5)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Waktu Perbaikan</label>
                                <select name="waktu_perbaikan"
                                    class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                                    required>
                                    <option value="1">
                                        < 24 jam (1)</option>
                                    <option value="2">1-2 hari (2)</option>
                                    <option value="3">3-5 hari (3)</option>
                                    <option value="4">1 minggu (4)</option>
                                    <option value="5">> 1 minggu (5)</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer: Tombol -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                    <button type="button" onclick="closeModal('detailModal')"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" form="penilaianForm" onclick="submitPenilaian()"
                        class="px-6 py-2 bg-primary text-white rounded transition">Beri Nilai</button>
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
            fetch(`/sarpras/laporan/${id}`, {
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
                        document.querySelector('.fasilitas').textContent = data.fasilitas_ruang_id ?? '-';
                        document.querySelector('.deskripsi').textContent = data.deskripsi_laporan ?? '-';
                        document.querySelector('.tanggal').textContent = data.lapor_datetime ?
                            new Date(data.lapor_datetime).toLocaleDateString('id-ID') : '-';
                        document.getElementById('detail-photo').src = data.lapor_foto_url ??
                            '{{ asset('assets/image/placeholder.jpg') }}';
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
                            if (row.is_done && !row.is_verified) {
                                return '<span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded uppercase font-bold">Ditolak</span>';
                            } else if (row.is_done) {
                                return '<span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">Selesai</span>';
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
                            <button onclick="openDetail(${data.laporan_id})"
                                class="bg-primary text-white rounded py-2 px-4 hover:bg-blue-700">Beri Nilai</button>
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
