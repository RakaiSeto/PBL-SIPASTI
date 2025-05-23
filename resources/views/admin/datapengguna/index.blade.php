@extends('layouts.app')

@section('content')
<!-- jQuery (required by DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous">

<!-- SweetAlert2 for notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.dataTables_length {
    margin: 1rem;
}
</style>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white p-6 rounded shadow space-y-4">
    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="text-sm font-medium text-slate-700">Filter:</label>
            <select id="filterRole" class="border border-slate-300 text-sm h-10 rounded px-3 pr-8">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="sarpras">Sarpras</option>
                <option value="civitas">Civitas</option>
                <option value="teknisi">Teknisi</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Nama Lengkap..." class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.datapengguna.export_pdf') }}" class="h-10 px-4 text-sm text-white bg-red-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                Export PDF
            </a>
            <button onclick="openModal('addModal')" class="h-10 px-4 text-sm text-white bg-blue-800 rounded hover:opacity-90 transition">
                Tambah Data
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
        <form id="addForm">
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
                <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">×</button>
    </div>
</div>

<!-- MODAL DETAIL -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden transition-opacity duration-300">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 flex flex-col justify-between">
        <div class="relative mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detail Pengguna</h2>
            <button class="absolute right-0 top-0 text-gray-500 hover:text-red-500 text-xl font-semibold transition duration-200" onclick="closeModal('detailModal')">×</button>
        </div>

        <div class="flex-1">
            <div class="grid grid-cols-1 md:grid-cols-[auto,1fr] gap-4">
                <div class="w-48 aspect-[3/4] overflow-hidden rounded">
                    <img src="{{ asset('assets/image/10.jpg') }}" alt="Foto" class="w-full h-full object-cover">
                </div>
                <div class="space-y-3">
                    <div>
                        <h4 class="text-base font-medium text-gray-500">Nama Lengkap</h4>
                        <p class="text-lg text-gray-800 fullname">-</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Username</h4>
                        <p class="text-lg text-gray-800 username">-</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Role</h4>
                        <p class="text-lg text-gray-800 role">-</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                        <p class="text-lg text-gray-800 email">-</p>
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

        <button onclick="closeModal('editModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">×</button>
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

<!-- SCRIPT -->
<script>
// CSRF Token Setup
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
if (!csrfToken) {
    console.error('CSRF token tidak ditemukan. Pastikan <meta name="csrf-token"> ada di layouts.app');
}

// DataTable instance
let table;

// Notification Functions using SweetAlert2
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

// MODAL HANDLING
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('hidden');
    } else {
        console.error(`Modal dengan ID ${id} tidak ditemukan`);
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('hidden');
    } else {
        console.error(`Modal dengan ID ${id} tidak ditemukan`);
    }
}

function openDetail(id) {
    fetch(`/api/kelola-pengguna/${id}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
        return res.json();
    })
    .then(response => {
        if (response.success) {
            const data = response.data;
            openModal('detailModal');
            document.querySelector('.fullname').textContent = data.fullname || '-';
            document.querySelector('.username').textContent = data.username || '-';
            document.querySelector('.role').textContent = data.role?.role_nama || '-';
            document.querySelector('.email').textContent = data.email || '-';
        } else {
            showError('Data tidak ditemukan: ' + (response.message || 'Kesalahan tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Gagal ambil data:', error);
        showError('Terjadi kesalahan saat mengambil data: ' + error.message);
    });
}

function openEdit(id) {
    fetch(`/api/kelola-pengguna/${id}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
        return res.json();
    })
    .then(result => {
        if (result.success) {
            const data = result.data;
            const editUserId = document.getElementById('editUserId');
            const editNama = document.getElementById('editNama');
            const editUsername = document.getElementById('editUsername');
            const editEmail = document.getElementById('editEmail');
            const editRole = document.getElementById('editRole');
            if (editUserId && editNama && editUsername && editEmail && editRole) {
                editUserId.value = id;
                editNama.value = data.fullname || '';
                editUsername.value = data.username || '';
                editEmail.value = data.email || '';
                editRole.value = reverseRoleMapping[data.role_id] || '';
                openModal('editModal');
            } else {
                console.error('Elemen formulir edit tidak ditemukan');
            }
        } else {
            showError('Data tidak ditemukan: ' + (result.message || 'Kesalahan tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Gagal ambil data:', error);
        showError('Terjadi kesalahan saat mengambil data: ' + error.message);
    });
}

function openDelete(id) {
    const deleteUserId = document.getElementById('deleteUserId');
    if (deleteUserId) {
        deleteUserId.value = id;
        openModal('deleteModal');
    } else {
        console.error('Elemen deleteUserId tidak ditemukan');
    }
}

// DATA TABLE INITIALIZATION
$(document).ready(function () {
    try {
        table = $('#userTable').DataTable({
            searching: false,
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                type: "POST",
                url: '{{ url("/api/kelola-pengguna") }}',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: function (d) {
                    d.role = $('#filterRole').val();
                    d.search = $('#searchInput').val();
                },
                error: function (xhr, error, thrown) {
                    console.error('Gagal memuat DataTable:', error, thrown);
                    showError('Gagal memuat data tabel: ' + (xhr.statusText || 'Kesalahan tidak diketahui'));
                }
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
            if (table) {
                table.ajax.reload(null, false); // Refresh tanpa reset paging
            } else {
                console.error('DataTable belum diinisialisasi');
            }
        });
    } catch (error) {
        console.error('Gagal menginisialisasi DataTable:', error);
        showError('Gagal menginisialisasi tabel: ' + error.message);
    }
});

// Role Mapping
const roleMapping = { 'admin': 1, 'sarpras': 2, 'civitas': 3, 'teknisi': 4 };
const reverseRoleMapping = { 1: 'admin', 2: 'sarpras', 3: 'civitas', 4: 'teknisi' };

// TAMBAH DATA
document.getElementById('addForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const fullname = document.getElementById('addNama')?.value;
    const username = document.getElementById('addUsername')?.value;
    const email = document.getElementById('addEmail')?.value;
    const role = document.getElementById('addRole')?.value;

    if (!fullname || !username || !email || !role) {
        showError('Semua kolom harus diisi');
        return;
    }

    const data = {
        fullname,
        username,
        email,
        role_id: roleMapping[role],
        password: '12345678',
        no_telp: '0000000000'
    };

    fetch('/api/kelola-pengguna/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(res => {
        if (!res.ok && res.status !== 201) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('Respons bukan JSON valid: ' + text);
            }
        });
    })
    .then(result => {
        if (result.success) {
            closeModal('addModal');
            showSuccess('Data berhasil ditambahkan!');
            if (table) {
                table.ajax.reload(null, false); // Refresh DataTable tanpa reset paging
            } else {
                console.error('DataTable tidak tersedia untuk disegarkan');
                location.reload(); // Fallback ke reload halaman
            }
        } else {
            showError('Gagal menambahkan data: ' + (result.message || 'Kesalahan tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Error tambah data:', error);
        showError('Terjadi kesalahan saat mengirim data: ' + error.message);
        if (table) {
            table.ajax.reload(null, false); // Coba segarkan tabel untuk memeriksa apakah data tersimpan
        }
    });
});

// EDIT DATA
document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('editUserId')?.value;
    const fullname = document.getElementById('editNama')?.value;
    const username = document.getElementById('editUsername')?.value;
    const email = document.getElementById('editEmail')?.value;
    const role = document.getElementById('editRole')?.value;

    if (!id || !fullname || !username || !email || !role) {
        showError('Semua kolom harus diisi');
        return;
    }

    const data = {
        fullname,
        username,
        email,
        role_id: roleMapping[role],
        no_telp: '0000000000'
    };

    fetch(`/api/kelola-pengguna/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(res => {
        if (!res.ok && res.status !== 201) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('Respons bukan JSON valid: ' + text);
            }
        });
    })
    .then(result => {
        if (result.success) {
            closeModal('editModal');
            showSuccess('Data berhasil diubah!');
            if (table) {
                table.ajax.reload(null, false); // Refresh DataTable tanpa reset paging
            } else {
                console.error('DataTable tidak tersedia untuk disegarkan');
                location.reload(); // Fallback ke reload halaman
            }
        } else {
            showError('Gagal update: ' + (result.message || 'Kesalahan tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Error update data:', error);
        showError('Terjadi kesalahan saat update: ' + error.message);
        if (table) {
            table.ajax.reload(null, false); // Coba segarkan tabel untuk memeriksa apakah data tersimpan
        }
    });
});

// DELETE DATA
function confirmDelete() {
    const id = document.getElementById('deleteUserId')?.value;

    if (!id) {
        showError('ID pengguna tidak ditemukan');
        return;
    }

    fetch(`/api/kelola-pengguna/${id}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('Respons bukan JSON valid: ' + text);
            }
        });
    })
    .then(result => {
        if (result.success) {
            closeModal('deleteModal');
            showDelete('Data berhasil dihapus!');
            if (table) {
                table.ajax.reload(null, false); // Refresh DataTable tanpa reset paging
            } else {
                console.error('DataTable tidak tersedia untuk disegarkan');
                location.reload(); // Fallback ke reload halaman
            }
        } else {
            showError('Gagal menghapus data: ' + (result.message || 'Kesalahan tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Error hapus data:', error);
        showError('Terjadi kesalahan saat menghapus data: ' + error.message);
    });
}

// Remove unused deleteUser function
</script>

@endsection
