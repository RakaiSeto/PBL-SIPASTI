@extends('layouts.app')

@section('content')
<!-- jQuery (required by DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
.dataTables_length {
    margin: 1rem;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white p-6 rounded shadow space-y-4">

    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="text-sm font-medium text-slate-700">Filter :</label>
            <select id="filterRole" onchange="filterTable()" class="border border-slate-300 text-sm h-10 rounded px-3 pr-8">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="sarpras">Sarpras</option>
                <option value="civitas">Civitas</option>
                <option value="teknisi">Teknisi</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Nama Lengkap..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>

        <div class="flex gap-2">
    <a href="{{ route('admin.datapengguna.export_pdf') }}"
   class="h-10 px-4 text-sm text-white bg-red-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
  Export PDF
</a>

    <button onclick="openModal('addModal')" class="h-10 px-4 text-sm text-white bg-primary rounded hover:opacity-90 transition">
      Tambah data
    </button>
  </div>
    </div>

    <!-- TABEL -->
    <div class="overflow-auto rounded border border-slate-50">
        <table id="userTable" class="w-full text-sm text-left table-fixed">
            <thead class="bg-slate-100 text-slate-700 font-medium">
                <tr>
                    <th class="p-3 w-10">No</th>
                    <th class="p-3 w-40">Nama Lengkap</th>
                    <th class="p-3 w-32">Username</th>
                    <th class="p-3 w-32">Role</th>
                    <th class="p-3 w-32">Email</th>
                    <th class="p-3 w-28">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Pengguna</h2>
        <form id="addForm" >
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="addNama" class="block mb-1 font-medium">Nama Lengkap</label>
                    <input id="addNama" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama lengkap" required>
                </div>
                <div>
                    <label for="addUsername" class="block mb-1 font-medium">Username</label>
                    <input id="addUsername" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan username" required>
                </div>
                <div>
                    <label for="addEmail" class="block mb-1 font-medium">Email</label>
                    <input id="addEmail" type="email" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan email" required>
                </div>
                <div>
                    <label for="addRole" class="block mb-1 font-medium">Role</label>
                    <select id="addRole" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="sarpras">Sarpras</option>
                        <option value="civitas">Civitas</option>
                        <option value="teknisi">Teknisi</option>
                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" id="submitAddForm" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- MODAL DETAIL -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden transition-opacity duration-300">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 flex flex-col justify-between">

        <!-- Header -->
        <div class="relative mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detail Laporan</h2>
            <button class="absolute right-0 top-0 text-gray-500 hover:text-red-500 text-xl font-semibold transition duration-200" onclick="closeModal('detailModal')">×</button>
        </div>

        <!-- Informasi Laporan -->
        <div class="flex-1">
            <div class="grid grid-cols-1 md:grid-cols-[auto,1fr] gap-4">
                <div class="w-48 aspect-[3/4] overflow-hidden rounded">
                    <img src="{{ asset('assets/image/10.jpg') }}" alt="Foto" class="w-full h-full object-cover">
                </div>
                <div class="space-y-3">
                    <div>
                        <h4 class="text-base font-medium text-gray-500 ">Nama Lengkap</h4>
                        <p class="text-lg text-gray-800 fullname" >Agung Fradiansyah</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Username</h4>
                        <p class="text-lg text-gray-800 username">agungAdmin</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Role</h4>
                        <p class="text-lg text-gray-800 role">Admin</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                        <p class="text-lg text-gray-800 email">agung@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>
        <form id="editForm">

        {{-- <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diubah!');"> --}}
            <input type="hidden" id="editUserId">
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="editNama" class="block mb-1 font-medium">Nama Lengkap</label>
                    <input id="editNama" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama lengkap" required>
                </div>
                <div>
                    <label for="editUsername" class="block mb-1 font-medium">Username</label>
                    <input id="editUsername" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan username" required>
                </div>
                <div>
                    <label for="editEmail" class="block mb-1 font-medium">Email</label>
                    <input id="editEmail" type="email" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan email" required>
                </div>
                <div>
                    <label for="editRole" class="block mb-1 font-medium">Role</label>
                    <select id="editRole" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="sarpras">Sarpras</option>
                        <option value="civitas">Civitas</option>
                        <option value="teknisi">Teknisi</option>
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
        <input type="hidden" id="deleteUserId">
        <h2 class="text-xl font-semibold text-slate-800 mb-4">Konfirmasi Hapus</h2>
        <p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus pengguna berikut ini?</p>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
        <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
        </div>
    </div>
</div>

@include('component.popsukses')
@include('component.pophapus')
<!-- SCRIPT -->
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
                document.querySelector('.role').textContent = data.role.role_name;
                document.querySelector('.email').textContent = data.email;
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
        lengthChange: true,
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

    const data = {
        fullname,
        username,
        email,
        role_id: roleMapping[role],
        password: '12345678',
        no_telp: '0000000000'
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
