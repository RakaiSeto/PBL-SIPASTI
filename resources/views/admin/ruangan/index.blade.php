@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">
    <!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
            <label for="filterRole" class="text-sm font-medium text-slate-700">Filter :</label>
            <select id="filterRole" onchange="filterTable()" class="border border-slate-300 text-sm h-10 rounded px-3 pr-8">
                <option value="">Semua Lantai</option>
                <option value="Lantai 5">Lantai 5</option>
                <option value="Lantai 6">Lantai 6</option>
                <option value="Lantai 7">Lantai 7</option>
                <option value="Lantai 8">Lantai 8</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Ruangan..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>

        <button onclick="openModal('addModal')" class="h-10 px-4 text-sm text-white bg-primary rounded hover:opacity-90 transition">
            Tambah Ruangan
        </button>
    </div>

    <!-- TABEL -->
    <div class="overflow-auto rounded border border-slate-200 text-sm">
        <table id="ruanganTable" class="w-full text-sm text-left table-fixed">
            <thead class="bg-slate-100 text-slate-700 font-medium">
                <tr>
                    <th class="p-3 w-10">No</th>
                    <th class="p-3 w-40">ID Role Ruangan</th>
                    <th class="p-3 w-32">Nama Ruangan</th>
                    <th class="p-3 w-32">Lantai</th>
                    <th class="p-3 w-28">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Ruangan</h2>
        <form id="addtambahRuangan" >
            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="addidrole" class="block mb-1 font-medium">ID Role Ruangan</label>
                    <input id="addidrole" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan ID Role Ruangan" required>
                </div>
                <div>
                    <label for="addnamaruangan" class="block mb-1 font-medium">Nama Ruangan</label>
                    <input id="addnamaruangan" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan Nama Ruangan" required>
                </div>
                <div>
                    <label for="addlantai" class="block mb-1 font-medium">Lantai</label>
                    <select id="addlantai" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled selected>Pilih Lantai</option>
                        <option value="5">Lantai 5</option>
                        <option value="6">Lantai 6</option>
                        <option value="7">Lantai 7</option>
                        <option value="8">Lantai 8</option>
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

<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Edit Ruangan</h2>
        <form id="editFormRuangan">

            {{-- ID tersembunyi --}}
            <input type="hidden" id="editRuanganId">

            <div class="space-y-4 text-slate-900">
                <div>
                    <label for="editRuanganRoleId" class="block mb-1 font-medium">ID Role Ruangan</label>
                    <input id="editRuanganRoleId" name="ruangan_role_id" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan ID role ruangan" required>
                </div>

                <div>
                    <label for="editRuanganNama" class="block mb-1 font-medium">Nama Ruangan</label>
                    <input id="editRuanganNama" type="text" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Masukkan nama ruangan" required>
                </div>

                <div>
                    <label for="editLantai" class="block mb-1 font-medium">Lantai</label>
                    <select id="editLantai" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                        <option value="" disabled selected>Pilih Lantai</option>
                        <option value="5">Lantai 5</option>
                        <option value="6">Lantai 6</option>
                        <option value="7">Lantai 7</option>
                        <option value="8">Lantai 8</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>

        <button onclick="closeModal('editModal')"
            class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- MODAL HAPUS -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <input type="hidden" id="deleteRuanganId">
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

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}


function editModal(id) {
    fetch(`/api/kelola-ruangan/${id}`)
        .then(res => res.json())
        .then(result => {
            if (!result.success) {
                alert('Data ruangan tidak ditemukan');
                return;
            }
            const data = result.data;

            document.getElementById('editRuanganId').value = id;
            document.getElementById('editRuanganRoleId').value = data.ruangan_role_id;
            document.getElementById('editRuanganNama').value = data.ruangan_nama;
            document.getElementById('editLantai').value = data.lantai;

            openModal('editModal');
        })
        .catch(error => {
            console.error('Gagal ambil data ruangan:', error);
            alert('Gagal mengambil data ruangan.');
        });
}



$(document).ready(function () {
    const table = $('#ruanganTable').DataTable({
        searching: false,
        lengthChange: true,
        processing: true,
        serverSide: true,
        ajax: {
            type: "POST",
            url: '{{ url("/api/kelola-ruangan") }}',
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
            { data: 'ruangan_role_id', name: 'ruangan_role_id', searchable: true },
            { data: 'ruangan_nama', name: 'ruangan_nama' },
            { data: 'lantai', name: 'lantai' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                            <button onclick="editModal(${data.ruangan_id})" title="Edit" class="text-gray-600 hover:text-yellow-600">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button onclick="openDelete(${data.ruangan_id})" title="Hapus" class="text-gray-600 hover:text-red-600">
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
//TAMBAH DATA
document.getElementById('addtambahRuangan').addEventListener('submit', async function (e) {
    e.preventDefault();
    const ruangan_role_id = document.getElementById('addidrole').value;
    const ruangan_nama = document.getElementById('addnamaruangan').value;
    const lantai = document.getElementById('addlantai').value;

    const data = {
        ruangan_role_id,
        ruangan_nama,
        lantai,
    };

    try {
        const response = await fetch('/api/kelola-ruangan/create', {
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
            document.getElementById('addtambahRuangan').reset(); // Kosongkan form
            $('#ruanganTable').DataTable().ajax.reload();
        } else {
            showError('Gagal menambahkan data: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Terjadi kesalahan saat mengirim data');
    }
});

//EDIT
document.getElementById('editFormRuangan').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('editRuanganId').value;
    const data = {
        ruangan_role_id: document.getElementById('editRuanganRoleId').value,
        ruangan_nama: document.getElementById('editRuanganNama').value,
        lantai: document.getElementById('editLantai').value,
    };


    fetch(`/api/kelola-ruangan/${id}`, {
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
            $('#ruanganTable').DataTable().ajax.reload();
        } else {
            showError('Gagal update: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Gagal update:', error);
        showError('Terjadi kesalahan saat update');
    });
});

function openDelete(id) {
    document.getElementById('deleteRuanganId').value = id;
    openModal('deleteModal');
}

//DELETE DATA
function confirmDelete() {
    const id = document.getElementById('deleteRuanganId').value;

    fetch(`/api/kelola-ruangan/${id}`, {
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
            $('#ruanganTable').DataTable().ajax.reload();
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
