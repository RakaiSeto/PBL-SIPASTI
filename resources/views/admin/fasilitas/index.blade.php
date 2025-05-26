@extends('layouts.app')

@section('content')
<!-- jQuery (required by DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white p-6 rounded shadow space-y-4 text-sm">

    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="text-sm font-medium text-slate-700">Filter :</label>
            <select id="filterRole" onchange="filterTable()" class="border border-slate-300 text-sm h-10 rounded px-3 pr-8">
                <option value="">Semua Kategori</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Furniture">Furniture</option>
                <option value="Jaringan">Jaringan</option>
                <option value="Perlengkapan Kelas">Perlengkapan Kelas</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Fasilitas..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>
        <div class="flex gap-2">
            <button onclick="openModal('addModal')" class="h-10 px-4 text-white bg-primary rounded hover:opacity-90 transition">
                Tambah data
            </button>

            <a href="{{ route('admin.fasilitas.export_excel') }}"
                class="h-10 px-4 text-white bg-green-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                Export Excel
            </a>

            <a href="{{ route('admin.fasilitas.export_pdf') }}"
                class="h-10 px-4 text-white bg-red-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                Export PDF
            </a>
        </div>
    </div>

    <!-- TABEL -->
    <div class="overflow-auto rounded">
        <table id="userTable" class="w-full text-left  border border-slate-200 rounded" style="border-collapse: separate; border-spacing: 0;">
            <thead class="bg-slate-100 text-slate-700 font-medium">
                <tr >
                    <th class="p-3 w-10">No</th>
                    <th class="p-3 w-32">Nama Fasilitas</th>
                    <th class="p-3 w-28">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- //////MODAL//////// -->

{{-- <!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Fasilitas</h2>
        <form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Fasilitas berhasil ditambahkan!');">
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="addId" class="block mb-1 font-medium">ID Fasilitas</label>
                    <input id="addId" type="text" class="w-full border-gray-200 px-3 py-2 rounded" placeholder="Masukkan ID fasilitas" required>
                </div>
                <div>
                    <label for="addNama" class="block mb-1 font-medium">Nama Fasilitas</label>
                    <input id="addNama" type="text" class="w-full border-gray-200 px-3 py-2 rounded" placeholder="Masukkan nama fasilitas" required>
                </div>
                <div>
                    <label for="addKategori" class="block mb-1 font-medium">Kategori</label>
                    <select id="addKategori" class="w-full border-gray-200 px-3 py-2 rounded" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>
        <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Edit Fasilitas</h2>
        <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Fasilitas berhasil diubah!');">
            <div class="space-y-2 text-slate-800">
                <div>
                    <label class="block mb-1 font-medium text-sm">ID Fasilitas</label>
                    <input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan ID fasilitas" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm">Nama Fasilitas</label>
                    <input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan nama fasilitas">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm">Kategori</label>
                    <select class="w-full border-gray-200 px-2 py-2 text-sm rounded" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('editModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- MODAL HAPUS -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-xl font-semibold text-slate-800 mb-4">Konfirmasi Hapus</h2>
        <p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus pengguna berikut ini?</p>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
            <button type="button" onclick="closeModal('deleteModal'); showDelete('deleteSuccess');" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
        </div>
        <button onclick="closeModal('deleteModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div> --}}

<!-- ///////////////////////////// -->

@include('admin.fasilitas.tambah')
@include('admin.fasilitas.edit')
@include('admin.fasilitas.detail')
@include('admin.fasilitas.hapus')

<!-- Detail, Delete, Edit -->
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openDetail(id) {
        console.log("ID yang dikirim:", id);
        fetch(`/api/kelola-fasilitas/${id}`)
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                const data = response.data;
                openModal('detailModal');
                document.querySelector('.fasilitas_nama').textContent = data.fasilitas_nama;
            } else {
                alert("Data tidak ditemukan");
            }
        })
        .catch(error => {
            console.error("Gagal ambil data:", error);
        });
    }

    function openEdit(id) {
        fetch(`/api/kelola-fasilitas/${id}`)
        .then(res => res.json())
        .then(result => {
            const data = result.data;
            document.getElementById('editFasilitasId').value = fasilitas_id;
            document.getElementById('editNama').value = data.fasilitas_nama;
            openModal('editModal');
        })
        .catch(error => {
            console.error('Gagal ambil data:', error);
            alert('Gagal mengambil data fasilitas.');
        });
    }   

    function openDelete(id) {
        document.getElementById('deleteFasilitasId').value = fasilitas_id;
        openModal('deleteModal');
    }
</script>

<!-- Search, Filter -->
<script>
$(document).ready(function () {
    const table = $('#userTable').DataTable({
        searching: false,
        lengthChange: false,
        processing: true,
        serverSide: true,
        ajax: {
            type: "POST",
            url: '{{ url("/api/kelola-fasilitas") }}',
            data: function (d) {
                d.role = $('#filterRole').val();
                d.search = { value: $('#searchInput').val(), regex: false };
            },
        },
        columns: [
            {
                data: null,
                name: 'no',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'fasilitas_nama', name: 'nama'},
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data) {
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

    $('#filterRole, #searchInput').on('change keyup', function () {
        table.ajax.reload();
    });
});
</script>

<!-- Message -->
<script>
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
