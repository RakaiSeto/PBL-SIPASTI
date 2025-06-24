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
            <input type="text" id="searchInput" placeholder="Cari Role Ruangan..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>
        <div class="flex gap-2">
            <button onclick="openModal('addModal')" class="h-10 px-4 text-white bg-primary rounded hover:opacity-90 transition">
                Tambah data
            </button>

            <a href="{{ route('admin.roleruangan.export_excel') }}"
                class="h-10 px-4 text-white bg-green-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                Export Excel
            </a>

            <a href="{{ route('admin.roleruangan.export_pdf') }}"
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
                    <th class="p-3 w-32">Nama Role Ruangan</th>
                    <th class="p-3 w-28">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('admin.roleruangan.tambah')
@include('admin.roleruangan.edit')
@include('admin.roleruangan.detail')
@include('admin.roleruangan.hapus')

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
        fetch(`/api/kelola-ruangan-role/${id}`)
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                const data = response.data;
                openModal('detailModal');
                document.querySelector('.ruangan_role_id').textContent = data.ruangan_role_id;
                document.querySelector('.ruangan_role_nama').textContent = data.ruangan_role_nama;
            } else {
                alert("Data tidak ditemukan");
            }
        })
        .catch(error => {
            console.error("Gagal ambil data:", error);
        });
    }

    function openEdit(id) {
        fetch(`/api/kelola-ruangan-role/${id}`)
        .then(res => res.json())
        .then(result => {
            const data = result.data;
            document.getElementById('editRuanganRoleId').value = id;
            document.getElementById('editNama').value = data.ruangan_role_nama;
            openModal('editModal');
        })
        .catch(error => {
            console.error('Gagal ambil data:', error);
            alert('Gagal mengambil data role ruangan.');
        });
    }   

    function openDelete(id) {
        document.getElementById('deleteRuanganRoleId').value = id;
        openModal('deleteModal');
    }
</script>

<!-- data tabel -->
<script>
$(document).ready(function () {
    const table = $('#userTable').DataTable({
        searching: false,
        lengthChange: false,
        processing: true,
        serverSide: true,
        ajax: {
            type: "POST",
            url: '{{ url("/api/kelola-ruangan-role") }}',
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
            { data: 'ruangan_role_nama', name: 'nama'},
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                        <div class="flex gap-2">
                            <button onclick="openDetail(${data.ruangan_role_id})" title="Lihat" class="text-gray-600 hover:text-blue-600">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="openEdit(${data.ruangan_role_id})" title="Edit" class="text-gray-600 hover:text-yellow-600">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button onclick="openDelete(${data.ruangan_role_id})" title="Hapus" class="text-gray-600 hover:text-red-600">
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

<script>

    //CREATE//
    document.getElementById('addModal').addEventListener('submit', async function (e) {
        e.preventDefault();
        const ruangan_role_nama = document.getElementById('addNama').value;

        const data = {
            ruangan_role_nama,
        };

        try {
            const response = await fetch('/api/kelola-ruangan-role/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                closeModal('addModal');
                showSuccess('Data berhasil ditambahkan!');
                document.getElementById('addForm').reset(); // Kosongkan form
                $('#userTable').DataTable().ajax.reload();
            } else {
                showError('Gagal menambahkan data: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            showError('Terjadi kesalahan saat mengirim data');
        }
    });

    //UPDATE//
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const id = document.getElementById('editRuanganRoleId').value;
        const data = {
            ruangan_role_nama: document.getElementById('editNama').value,
        };

        fetch(`/api/kelola-ruangan-role/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                closeModal('editModal');
                showSuccess('Data berhasil diubah!');
                $('#userTable').DataTable().ajax.reload();
            } else {
                showError('Gagal update: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Gagal update:', error);
            showError('Terjadi kesalahan saat update');
        });
    });

    //DELETE//
    function confirmDelete() {
        const id = document.getElementById('deleteRuanganRoleId').value;

        fetch(`/api/kelola-ruangan-role/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                closeModal('deleteModal');
                showDelete('Data berhasil dihapus!');
                $('#userTable').DataTable().ajax.reload();
            } else {
                showError('Gagal menghapus data: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Error delete:', error);
            showError('Terjadi kesalahan saat menghapus data');
        });
    }
</script>
@endsection