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
                        <th class="p-3">Tanggal Dibuat</th>
                        <th class="p-3">Tanggal Selesai</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- MODAL: DETAIL LAPORAN + FEEDBACK -->
    <div id="modalLihatFeedback" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg w-full max-w-3xl shadow-lg p-6 relative overflow-y-auto max-h-[95vh]">
            <!-- Header -->
            <div class="relative mb-4">
                <h2 class="text-2xl font-bold">Detail Laporan & Umpan Balik</h2>
                <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500 text-xl"
                    onclick="tutupModalFeedback()">✕</button>
            </div>

            <!-- Informasi Laporan -->
            <div class="space-y-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Info Utama -->
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
                    </div>

                    <!-- Foto -->
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium mb-1">Foto Fasilitas</h4>
                        <div class="rounded overflow-hidden shadow border">
                            <img id="detail-photo" src="{{ asset('assets/profile/dafault2.jpg') }}" alt="Foto Fasilitas"
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

                <!-- Umpan Balik -->
                <div class="border-t pt-4">
                    <h3 class="text-lg font-semibold mb-3">Umpan Balik</h3>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Rating:</label>
                        <div id="lihatRating" class="text-yellow-500 text-lg">⭐️⭐️⭐️⭐️⭐️</div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Komentar:</label>
                        <p id="lihatKomentar" class="text-gray-800 mt-1">-</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Tutup -->
            <div class="flex justify-end">
                <button onclick="tutupModalFeedback()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Tutup
                </button>
            </div>
        </div>
    </div>



    <!-- Modal Feedback -->
    <div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg w-full max-w-3xl shadow-lg p-6 relative overflow-y-auto max-h-[95vh]">
            <!-- Header -->
            <div class="relative mb-4">
                <h2 class="text-2xl font-bold">Umpan Balik</h2>
                <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500" onclick="tutupModal()">✕</button>
            </div>

            <!-- Informasi Laporan -->
            <div class="space-y-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Info Utama -->
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
                    </div>

                    <!-- Foto -->
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium mb-1">Foto Fasilitas</h4>
                        <div class="rounded overflow-hidden shadow border">
                            <img id="detail-photo" src="{{ asset('assets/profile/dafault2.jpg') }}" alt="Foto Fasilitas"
                                class="w-full max-h-60 object-cover">
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

            // Ambil data laporan dari server
            fetch(`/civitas/rating/detail/${laporanId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(response => {
                    if (!response.success) {
                        throw new Error(response.message || 'Gagal ambil data');
                    }

                    const data = response.data;

                    // Isi detail laporan di modal
                    document.querySelector('#feedbackModal .pelapor').textContent = data.user_fullname || '-';
                    document.querySelector('#feedbackModal .ruang').textContent = data.ruangan_nama || '-';
                    document.querySelector('#feedbackModal .fasilitas').textContent = data.fasilitas_nama || '-';
                    document.querySelector('#feedbackModal .deskripsi').textContent = data.deskripsi_laporan || '-';
                    document.querySelector('#feedbackModal #detail-photo').src = data.lapor_foto_url ||
                        '{{ asset('assets/profile/dafault2.jpg') }}';

                    // Isi riwayat status
                    const riwayatStatus = document.querySelector('#feedbackModal #riwayatStatus');
                    riwayatStatus.innerHTML = '';
                    data.riwayat.forEach(item => {
                        riwayatStatus.innerHTML += `
                <li class="flex items-center gap-2">
                    <i class="fas ${item.icon} w-4"></i>
                    <span><strong>${item.status}:</strong> ${item.tanggal}</span>
                </li>`;
                    });

                    // Tampilkan modal setelah data terisi
                    document.getElementById('feedbackModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Gagal ambil data laporan:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message || 'Terjadi kesalahan saat mengambil data laporan',
                        timer: 3000,
                        showConfirmButton: true
                    });
                });
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
                        data: 'selesai_datetime',
                        name: 'selesai_datetime',
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
                                return `
                <button onclick="lihatFeedback(${data.laporan_id})"
                    class="bg-gray-500 text-white rounded py-2 px-4 hover:bg-gray-600">
                    Lihat Umpan Balik
                </button>
            `;
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

        function lihatFeedback(laporanId) {
            fetch(`/civitas/rating/detail/${laporanId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(response => {
                    if (!response.success) {
                        throw new Error(response.message || 'Gagal ambil data');
                    }

                    const data = response.data;

                    // Show modal
                    document.getElementById('modalLihatFeedback').classList.remove('hidden');

                    // DETAIL LAPORAN
                    document.querySelector('.pelapor').textContent = data.user_fullname;
                    document.querySelector('.ruang').textContent = data.ruangan_nama;
                    document.querySelector('.fasilitas').textContent = data.fasilitas_nama;
                    document.querySelector('.deskripsi').textContent = data.deskripsi_laporan;
                    document.getElementById('detail-photo').src = data.lapor_foto_url;

                    // RIWAYAT STATUS
                    const riwayatStatus = document.getElementById('riwayatStatus');
                    riwayatStatus.innerHTML = '';
                    data.riwayat.forEach(item => {
                        riwayatStatus.innerHTML += `
                <li class="flex items-center gap-2">
                    <i class="fas ${item.icon} w-4"></i>
                    <span><strong>${item.status}:</strong> ${item.tanggal}</span>
                </li>`;
                    });

                    // FEEDBACK
                    document.getElementById('lihatRating').innerText = data.rating;
                    document.getElementById('lihatKomentar').innerText = data.komentar;
                })
                .catch(error => {
                    console.error('Gagal ambil data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message || 'Terjadi kesalahan',
                        timer: 3000,
                        showConfirmButton: true
                    });
                });
        }


        function tutupModalFeedback() {
            document.getElementById('modalLihatFeedback').classList.add('hidden');
        }
    </script>
@endsection
