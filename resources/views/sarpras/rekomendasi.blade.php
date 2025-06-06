@extends('layouts.app')

@section('content')

    <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="bg-white p-4 rounded shadow">
        {{-- <h1 class="text-xl font-bold mb-4">Laporan Terverifikasi</h1> --}}

        <!-- Tab Menu -->
        <div class="flex border-b border-slate-300 mb-4"><button id="tab-saw"
                class="px-4 py-2 -mb-px border-b-2 border-transparent text-slate-500 hover:text-primary hover:border-primary transition-colors duration-200"
                onclick="showTab('saw')">SAW</button>
            <button id="tab-moora"
                class="px-4 py-2 -mb-px border-b-2 border-transparent text-slate-500 hover:text-primary hover:border-primary transition-colors duration-200"
                onclick="showTab('moora')">MOORA</button>
        </div>



        <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">

            <!-- Filter Berdasarkan Fasilitas -->
            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="filterFasilitas" class="text-sm text-slate-700">Fasilitas</label>
                <select id="filterFasilitas"
                    class="border border-slate-300 rounded px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="AC">AC</option>
                    <option value="Proyektor">Proyektor</option>
                    <option value="Kipas Angin">Kipas Angin</option>
                    <option value="Lampu">Lampu</option>
                    <!-- Tambahkan opsi lain sesuai daftar fasilitas -->
                </select>

                <!-- Input Cari di kiri -->
                <input class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
                    placeholder="Cari..." />
            </div>


            <!-- Dropdown Tampilkan data di kanan -->
            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="tampilData" class="text-sm text-slate-700">Tampilkan</label>
                <select id="tampilData"
                    class="border border-slate-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

        </div>

        <!-- Tab SAW -->
        <div id="content-saw" class="">
            <div class="overflow-auto">
                <table id="table-saw" class="w-full table-auto text-sm text-left border border-gray-200">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">No</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">Fasilitas</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C1 (Kerusakan)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C2 (Dampak)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C3 (Frekuensi)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C4 (Laporan)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C5 (Waktu Kerusakan)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C6 (Waktu Perbaikan)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">Skor DSS - Keterangan</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Tab MOORA -->
        <div id="content-moora" class="hidden">
            <div class="overflow-auto">
                <table id="table-moora" class="w-full table-auto text-sm text-left border border-gray-200">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">No</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">Fasilitas</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C1 (Kerusakan)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C2 (Dampak)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C3 (Frekuensi)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C4 (Laporan)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C5 (Waktu Kerusakan)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">C6 (Waktu Perbaikan)</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">Skor DSS - Keterangan</th>
                            <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-teknisi" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Pilih Teknisi</h2>
            <select id="teknisi-select-modal" class="w-full border border-gray-300 rounded px-3 py-2 mb-4">
                <option value="">-- Pilih Teknisi --</option>
                <option value="1">Teknisi A</option>
                <option value="2">Teknisi B</option>
                <option value="3">Teknisi C</option>
            </select>
            <div class="flex justify-end gap-2">
                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                    onclick="closeModal()">Batal</button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    onclick="kirimTeknisi()">Kirim</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            showTab('saw');

            var tableSaw = $('#table-saw').DataTable({
                ajax: {
                    url: "/api/saw",
                    dataSrc: 'rank',
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ordering: false,
                    info: false,
                },
                columns: [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'name' },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[0] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[1] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[2] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[3] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[4] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[5] : ''; } },
                    { data: null },
                    { data: null },
                ],
                columnDefs: [
                    { targets: '_all', className: 'whitespace-nowrap' },
                    {
                        targets: 8,
                        render: function (data, type, row) {
                            const value = row.value.toFixed(3);
                            return `${value}`;
                        }
                    },
                    {
                        targets: 9,
                        render: function (data, type, row) {
                            return `
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded"
                                            onclick="openModal('${row.id || ''}')">
                                            Tugaskan Teknisi
                                        </button>
                                    `;
                        }
                    }
                ]
            });

            var tableMoora = $('#table-moora').DataTable({
                ajax: {
                    url: "/api/moora",
                    dataSrc: 'rank',
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ordering: false,
                    info: false,
                },
                columns: [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'name' },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[0] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[1] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[2] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[3] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[4] : ''; } },
                    { data: null, render: function (data, type, row) { return row.alternatif && Array.isArray(row.alternatif) ? row.alternatif[5] : ''; } },
                    { data: null },
                    { data: null },
                ],
                columnDefs: [
                    { targets: '_all', className: 'whitespace-nowrap' },
                    {
                        targets: 8,
                        render: function (data, type, row) {
                            const value = row.value.toFixed(3);
                            return `${value}`;
                        }
                    },
                    {
                        targets: 9,
                        render: function (data, type, row) {
                            return `
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded"
                                                onclick="openModal('${row.id || ''}')">
                                                Tugaskan Teknisi
                                            </button>
                                        `;
                        }
                    }
                ]
            });
        });

        function showTab(tab) {
            const sawTabBtn = document.getElementById('tab-saw');
            const mooraTabBtn = document.getElementById('tab-moora');
            const sawContent = document.getElementById('content-saw');
            const mooraContent = document.getElementById('content-moora');

            if (tab === 'saw') {
                sawContent.classList.remove('hidden');
                mooraContent.classList.add('hidden');
                sawTabBtn.classList.add('border-blue-600', 'text-blue-600');
                sawTabBtn.classList.remove('border-transparent', 'text-gray-600');
                mooraTabBtn.classList.remove('border-blue-600', 'text-blue-600');
                mooraTabBtn.classList.add('border-transparent', 'text-gray-600');
            } else {
                mooraContent.classList.remove('hidden');
                sawContent.classList.add('hidden');
                mooraTabBtn.classList.add('border-blue-600', 'text-blue-600');
                mooraTabBtn.classList.remove('border-transparent', 'text-gray-600');
                sawTabBtn.classList.remove('border-blue-600', 'text-blue-600');
                sawTabBtn.classList.add('border-transparent', 'text-gray-600');
            }
        }

        function tugaskanTeknisi(id) {
            let selectId = `teknisi-select-${id}`;
            let select = document.getElementById(selectId);
            if (!select) {
                alert('Dropdown teknisi tidak ditemukan.');
                return;
            }
            const teknisi = select.value;
            if (!teknisi) {
                alert('Silakan pilih teknisi terlebih dahulu.');
                return;
            }

            alert('Berhasil menugaskan teknisi');
            // TODO: Kirim data ke backend via AJAX atau submit form
            // Setelah itu bisa reset pilihan dropdown:
            select.value = '';
        }

        //nu
        let currentItemId = null;

        function openModal(itemId) {
            currentItemId = itemId; // simpan ID yang sedang diproses (misalnya ID pelaporan)
            document.getElementById("modal-teknisi").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("modal-teknisi").classList.add("hidden");
            currentItemId = null;
        }

        function kirimTeknisi() {
            const teknisiId = document.getElementById("teknisi-select-modal").value;

            if (!teknisiId) {
                alert("Silakan pilih teknisi terlebih dahulu.");
                return;
            }

            // Kirim data ke backend di sini, contoh (simulasi):
            console.log("Menugaskan teknisi ID:", teknisiId, "untuk item ID:", currentItemId);

            // Setelah sukses, tutup modal
            closeModal();
        }
    </script>
@endsection