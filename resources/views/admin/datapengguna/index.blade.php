@extends('layouts.app')

@section('content')
<!-- jQuery (required by DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>



</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white p-6 rounded shadow space-y-4">

    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="font-medium text-slate-700">Filter :</label>
            <select id="filterRole" onchange="filterTable()" class="border border-slate-300 h-10 rounded px-3 pr-8">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="sarpras">Sarpras</option>
                <option value="civitas">Civitas</option>
                <option value="teknisi">Teknisi</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Nama Lengkap..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10   border border-slate-300 rounded px-3">
        </div>

        <div class="flex gap-2">
    <a href="{{ route('admin.datapengguna.export_pdf') }}"
   class="h-10 px-4   text-white bg-red-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
  Export PDF
</a>

    <button onclick="openModal('addModal')" class="h-10 px-4 text-white bg-primary rounded hover:opacity-90 transition">
      Tambah data
    </button>
  </div>
    </div>

    <!-- TABEL -->
    <div class="overflow-auto rounded">
        <table id="userTable" class="w-full text-left  border border-slate-200 rounded" style="border-collapse: separate; border-spacing: 0;">
            <thead class="bg-slate-100 text-slate-700 font-medium">
                <tr >
                    <th class="p-3 w-10"  >No</th>
                    <th class="p-3 w-40"  >Nama Lengkap</th>
                    <th class="p-3 w-32"  >Username</th>
                    <th class="p-3 w-32"  >Role</th>
                    <th class="p-3 w-32"  >Email</th>
                    <th class="p-3 w-32"  >telp</th>
                    <th class="p-3 w-28"  >Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

</div>

@include('admin.datapengguna.tambah')
@include('admin.datapengguna.edit')
@include('admin.datapengguna.detail')
@include('admin.datapengguna.hapus')

<script>

// MODAL HANDLING
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function openDetail(id) {
    console.log("ID yang dikirim:", id);
    fetch(`/api/kelola-pengguna/${id}`)
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                const data = response.data;
                openModal('detailModal');
                document.querySelector('.fullname').textContent = data.fullname;
                document.querySelector('.username').textContent = data.username;
                document.querySelector('.role').textContent = data.role ? data.role.role_nama : '-';
                document.querySelector('.email').textContent = data.email;
                document.querySelector('.no_telp').textContent = data.no_telp;
            } else {
                alert("Data tidak ditemukan");
            }
        })
        .catch(error => {
            console.error("Gagal ambil data:", error);
        });
}

function openEdit(id) {
    fetch(`/api/kelola-pengguna/${id}`)
        .then(res => res.json())
        .then(result => {
            const data = result.data;
            document.getElementById('editUserId').value = id;
            document.getElementById('editNama').value = data.fullname;
            document.getElementById('editUsername').value = data.username;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editRole').value = roleMapping[data.role_id];
            openModal('editModal');
        })
        .catch(error => {
            console.error('Gagal ambil data:', error);
            alert('Gagal mengambil data pengguna.');
        });
}

function openDelete(id) {
    document.getElementById('deleteUserId').value = id;
    openModal('deleteModal');
}


</script>

<script>
// DATA TABLE INITIALIZATION
$(document).ready(function () {
    const table = $('#userTable').DataTable({
        searching: false,
        lengthChange: false,
        processing: true,
        serverSide: true,
        ajax: {
            type: "POST",
            url: '{{ url("/api/kelola-pengguna") }}',
            data: function (d) {
                d.role = $('#filterRole').val();
                d.search = $('#searchInput').val();
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
            { data: 'fullname', name: 'name', searchable: true },
            { data: 'username', name: 'username' },
            { data: 'role.role_nama', name: 'role.role_nama', defaultContent: '-' },
            { data: 'email', name: 'email' },
            { data: 'no_telp', name: 'no_telp' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                        <div class="flex gap-2">
                            <button onclick="openDetail(${data.user_id})" title="Lihat" class="text-gray-600 hover:text-blue-600">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="openEdit(${data.user_id})" title="Edit" class="text-gray-600 hover:text-yellow-600">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button onclick="openDelete(${data.user_id})" title="Hapus" class="text-gray-600 hover:text-red-600">
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
// TAMBAH DATA
const roleMapping = { admin: 1, sarpras: 2, civitas: 3, teknisi: 4 };

document.getElementById('addForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const fullname = document.getElementById('addNama').value;
    const username = document.getElementById('addUsername').value;
    const email = document.getElementById('addEmail').value;
    const role = document.getElementById('addRole').value;
    const no_telp = document.getElementById('addTelp').value;

    const data = {
        fullname,
        username,
        email,
        role_id: roleMapping[role],
        password: '12345678',
        no_telp: '000000000'
    };

    try {
        const response = await fetch('/api/kelola-pengguna/create', {
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

// EDIT DATA
const reverseRoleMapping = { admin: 1, sarpras: 2, civitas: 3, teknisi: 4 };

document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('editUserId').value;
    const data = {
        fullname: document.getElementById('editNama').value,
        username: document.getElementById('editUsername').value,
        email: document.getElementById('editEmail').value,
        role_id: reverseRoleMapping[document.getElementById('editRole').value],
        no_telp: '0000000000'
    };

    fetch(`/api/kelola-pengguna/${id}`, {
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

// DELETE DATA
function confirmDelete() {
    const id = document.getElementById('deleteUserId').value;

    fetch(`/api/kelola-pengguna/${id}`, {
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
