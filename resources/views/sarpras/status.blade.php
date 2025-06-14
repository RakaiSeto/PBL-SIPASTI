@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">
            <!-- Filter Fasilitas -->
            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="filterFasilitas" class="text-sm text-slate-700">Fasilitas</label>
                <select id="filterFasilitas"
                    class="border border-slate-300 rounded px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="AC">AC</option>
                    <option value="Proyektor">Proyektor</option>
                    <option value="Kipas Angin">Kipas Angin</option>
                    <option value="Lampu">Lampu</option>
                </select>

                <input class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
                    placeholder="Cari..." />
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-auto">
            <table class="w-full table-auto text-sm text-left" id="tableStatusPerbaikan">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        <th class="p-3">No</th>
                        <th class="p-3">Ruang</th>
                        <th class="p-3">Fasilitas</th>
                        <th class="p-3">Teknisi</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal -->
        <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded shadow-lg w-[90%] max-w-2xl overflow-y-auto max-h-[90vh]">
                <!-- Header -->
                <div class="relative mb-4">
                    <h2 class="text-2xl font-bold">Detail Laporan Sarpras</h2>
                    <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500"
                        onclick="closeModal()">✕</button>
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
                                <h4 class="text-sm text-gray-500 font-medium">Teknisi</h4>
                                <p class="teknisi text-gray-800 text-base font-semibold">-</p>
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

                    <!-- Riwayat Status -->
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

                <div class="flex justify-end gap-3 border-t pt-4" id="modalActions">
                    <!-- Tombol aksi akan dimuat via JS -->
                </div>
            </div>
        </div>

    </div>

    </div>

    <script>
        var table = null;

        // Filter Fasilitas dan Cari
        const fasilitasFilter = document.getElementById('filterFasilitas');
        const inputCari = document.querySelector('input[placeholder="Cari..."]');

        fasilitasFilter.addEventListener('change', filterData);
        inputCari.addEventListener('input', filterData);

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function filterData() {
            const filterFasilitas = fasilitasFilter.value.toLowerCase();
            const keyword = inputCari.value.toLowerCase();

            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const fasilitas = row.children[1].textContent.toLowerCase();
                const rowText = row.textContent.toLowerCase();

                const matchFasilitas = !filterFasilitas || fasilitas.includes(filterFasilitas);
                const matchKeyword = rowText.includes(keyword);

                row.style.display = (matchFasilitas && matchKeyword) ? '' : 'none';
            });
        }

        
        function openDetail(id) {
            fetch(`/sarpras/laporan/detail/${id}`, {
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
                        document.querySelector('.user_id').textContent = data.user_nama ?? '-';
                        document.querySelector('.ruang').textContent = data.ruangan_nama ?
                            data.ruangan_nama + ' - lantai ' + data.ruangan_lantai :
                            '-';
                        document.querySelector('.fasilitas').textContent = data.fasilitas_nama ??
                            '-';
                        document.querySelector('.teknisi').textContent = data.teknisi_nama ?? '-';
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

        $(document).ready(function () {
            table = $('#tableStatusPerbaikan').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '/sarpras/laporan/list-status-perbaikan',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: 'done'
                    },
                    dataSrc: function (json) {
                        return json.data;
                    },
                    error: function (xhr, error, thrown) {
                        console.log(xhr.responseText);
                    }
                },
                columns: [{
                    data: null,
                    name: 'no',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false,
                },
                {
                    data: 'fasilitas_nama',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'ruangan_nama',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'teknisi_nama',
                    orderable: false,
                    searchable: false
                },
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
                        } else if (row.status == 'kerjakan') {
                            return '<span class="bg-yellow-500/20 text-yellow-900 text-xs px-2 py-1 rounded font-bold">Dikerjakan</span>';
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
                        return `<button onclick="openDetail(${data})" class="bg-primary text-white rounded py-2 px-4 hover:bg-blue-700 gap-x-4">
                                            <i class="fas fa-eye"></i> Detail</button>`;
                    }
                }
                ]
            });
        });

        // Modal Logic
        const modal = document.getElementById('detailModal');
        const openModalButtons = document.querySelectorAll('.open-modal');
        const modalActions = document.getElementById('modalActions');

        function closeModal() {
            modal.classList.add('hidden');
            modalActions.innerHTML = ''; // Clear actions when closing
        }

        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Populate modal fields
                document.querySelector('.user_id').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('.ruang').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('.fasilitas').textContent = button.getAttribute('data-fasilitas');
                document.querySelector('.deskripsi').textContent =
                    'No description'; // Replace with actual data if available
                document.querySelector('.tanggal').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('.status').textContent = button.getAttribute('data-status');
                document.querySelector('#detail-photo').src =
                    '/assets/image/placeholder.jpg'; // Replace with actual image if available
                document.querySelector('#statusBaru').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('#statusProses').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('#statusSelesai').textContent = button.getAttribute(
                    'data-status') === 'Selesai dikerjakan' ? 'Completed' : '-';

                // Clear previous actions
                modalActions.innerHTML = '';

                // Add Selesai button if status is "Selesai dikerjakan"
                if (button.getAttribute('data-status') === 'Selesai dikerjakan') {
                    const selesaiButton = document.createElement('button');
                    selesaiButton.className =
                        'bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600';
                    selesaiButton.textContent = 'Selesai';
                    selesaiButton.addEventListener('click', () => {
                        alert(
                            'Laporan telah ditandai sebagai selesai!'); // Replace with actual logic
                    });
                    modalActions.appendChild(selesaiButton);
                }

                modal.classList.remove('hidden');
            });
        });

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
@endsection