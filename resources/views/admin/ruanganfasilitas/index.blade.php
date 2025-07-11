@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <div class="bg-white p-6 rounded shadow space-y-4 text-sm">
        <!-- Filter & Pencarian -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex gap-3 w-full md:w-auto">
                <!-- Filter Lokasi -->
                <div class="flex items-center gap-2">
                    <label for="filterLokasi" class="text-sm font-medium text-slate-700">Filter :</label>
                    <div class="relative group">
                        <button id="dropdown-button"
                            class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                            <span class="mr-2" id="selected-option">Pilih Ruangan</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="dropdown-menu"
                            class="hidden absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1 z-50">
                            <!-- Search input -->
                            <input id="search-input"
                                class="block w-full px-4 py-2 text-gray-800 border rounded-md  border-gray-300 focus:outline-none"
                                type="text" placeholder="Search ruangan" autocomplete="off">
                            <!-- Dropdown content goes here -->
                            <option selected disabled value=""
                                class="block px-4 py-2 bg-gray-100 cursor-pointer rounded-md">Pilih Ruangan</option>
                            @foreach ($ruangan as $item)
                                <option value="{{ $item->ruangan_id }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">
                                    {{ $item->ruangan_nama }} - Lantai {{ $item->lantai }}
                                </option>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Tambah -->
            <div class="flex gap-2">
                <button onclick="openModal('addModal')" class="btn-primary">
                    Tambah Data
                </button>
                <a href="{{ route('admin.ruanganfasilitas.export_excel') }}"
                    class="h-10 px-4 text-white bg-green-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                    Export Excel
                </a>
                <a href="{{ route('admin.ruanganfasilitas.export_pdf') }}"
                    class="h-10 px-4 text-white bg-red-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                    Export PDF
                </a>
            </div>
        </div>

        <!-- TABEL -->
        <div class="overflow-auto rounded">
            <table id="tabelData" class="w-full text-left  border border-slate-200 rounded"
                style="border-collapse: separate; border-spacing: 0;">
                <thead class="bg-slate-100 text-slate-700 font-medium">
                    <tr>
                        <th class="p-3 w-10">No</th>
                        <th class="p-3 w-10">Id</th>
                        <th class="p-3 w-32">Nama Ruangan</th>
                        <th class="p-3 w-32">Fasilitas</th>
                        <th class="p-3 w-32">Lantai</th>
                        <th class="p-3 w-28">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal Lihat Fasilitas -->
    <div id="fasilitasModal" class="fixed inset-0 z-50 bg-black/40 hidden justify-center items-center">
        <div class="bg-white w-full max-w-md p-6 rounded shadow space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-slate-700">Fasilitas Ruangan</h2>
                <button onclick="closeFasilitasModal()" class="text-slate-500 hover:text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="fasilitasContent" class="text-sm text-slate-600 space-y-2">
            </div>
        </div>
    </div>

    @include('admin.ruanganfasilitas.tambah')
    @include('admin.ruanganfasilitas.detail')
    @include('admin.ruanganfasilitas.edit')
    @include('admin.ruanganfasilitas.hapus')


    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new TomSelect('#select-fasilitas', {
                plugins: ['remove_button'],
            });
        });
    </script>
    <script>
        document.getElementById('select-fasilitas').addEventListener('change', () => {
            let dataArr = [];
            for (let i = 0; i < document.getElementById('select-fasilitas').options.length; i++) {
                if (document.getElementById('select-fasilitas').options[i].selected) {
                    dataArr.push(document.getElementById('select-fasilitas').options[i].value);
                }
            }
        });
        document.getElementById('btnTambahRuanganFasilitas').addEventListener('click', () => {
            const ruanganId = document.getElementById('addRole').value;
            let dataArr = [];
            for (let i = 0; i < document.getElementById('select-fasilitas').options.length; i++) {
                if (document.getElementById('select-fasilitas').options[i].selected) {
                    dataArr.push(document.getElementById('select-fasilitas').options[i].value);
                }
            }
            $.ajax({
                url: '{{ url('/api/kelola-fasilitas-ruang/create') }}',
                type: 'POST',
                data: {
                    ruangan_id: ruanganId,
                    fasilitas_id: dataArr
                },
                success: function(response) {
                    closeModal('addModal');
                    showSuccess('Data berhasil ditambahkan!');
                    table.ajax.reload();
                },
                error: function(xhr, status, error) {
                    showError('Data gagal ditambahkan!');
                }
            });
        });
    </script>
    <script>
        var table;
        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const searchInput = document.getElementById('search-input');
        const itemRuanganFilter = dropdownMenu.querySelectorAll('option');
        const selectedOption = document.getElementById('selected-option');
        let isOpen = false;

        function toggleDropdown() {
            isOpen = !isOpen;
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
            dropdownMenu.classList.toggle('hidden', !isOpen);
        }

        dropdownButton.addEventListener('click', toggleDropdown);

        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            itemRuanganFilter.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        });

        $(document).ready(function() {
            table = $('#tabelData').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                ajax: {
                    url: '{{ url('/api/kelola-fasilitas-ruang') }}',
                    type: 'POST',
                    data: function(d) {
                        d.ruangan_id = $('#selected-option').val();
                        d.search = $('#search-input').val();
                    },
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
                        name: 'fasilitas_ruang_id'
                    },
                    {
                        data: 'ruangan.ruangan_nama',
                        name: 'ruangan_nama'
                    },
                    {
                        data: 'fasilitas.fasilitas_nama',
                        name: 'fasilitas_nama'
                    },
                    {
                        data: 'ruangan.lantai',
                        name: 'ruangan_lantai'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                            <div class="flex gap-2">
                                <button onclick="openDetail(${data.fasilitas_id})" title="Lihat" class="text-gray-600 hover:text-blue-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="openEdit(${data.fasilitas_id})" title="Edit" class="text-gray-600 hover:text-yellow-600">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button onclick="openDelete(${data.fasilitas_id})" title="Hapus" class="text-gray-600 hover:text-red-600">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>`;
                        }
                    }
                ]
            });

            $('#addFasilitas').select2({
                placeholder: "Pilih Fasilitas",
                width: '100%',
                allowClear: true
            });
        });

        itemRuanganFilter.forEach(item => {
            item.addEventListener('click', () => {
                selectedOption.textContent = item.textContent;
                selectedOption.value = item.value;
                toggleDropdown();
                table.ajax.reload();
            });
        });

        // Modal handler
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openDetail() {
            openModal('detailModal');
        }

        function openEdit() {
            openModal('editModal');
        }

        function openDelete() {
            openModal('deleteModal');
        }

        // SweetAlert functions (srcf-style notification)
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

        function showDelete(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }
    </script>
@endsection
