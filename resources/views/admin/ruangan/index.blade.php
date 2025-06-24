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
            <label for="filterLantai" class="text-sm font-medium text-slate-700">Filter :</label>
            <select id="filterLantai" class="border border-slate-300 text-sm h-10 rounded px-3 pr-8">
                <option value="">Semua Lantai</option>
                <option value="5">Lantai 5</option>
                <option value="6">Lantai 6</option>
                <option value="7">Lantai 7</option>
                <option value="8">Lantai 8</option>
            </select>
            <input type="text" id="searchInput" placeholder="Cari Ruangan..." onkeyup="filterTable()"
                class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3">
        </div>

        <div class="flex gap-2">
                <button onclick="openModal('addModal')"
                    class="h-10 px-4 text-white bg-primary rounded hover:opacity-90 transition">
                    Tambah Ruangan
                </button>
                <a href="{{ route('admin.ruangan.export_excel') }}"
                    class="h-10 px-4 text-white bg-green-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                    Export Excel
                </a>
                <a href="{{ route('admin.ruangan.export_pdf') }}"
                    class="h-10 px-4 text-white bg-red-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                    Export PDF
                </a>
                
            </div>
    </div>

    <!-- TABEL -->
  <div class="overflow-auto rounded">
            <table id="ruanganTable" class="w-full text-left table-fixed border border-slate-200 rounded"
                style="border-collapse: separate; border-spacing: 0;">
                <thead class="bg-slate-100 text-slate-700 font-medium">
                    <tr>
                        <th class="p-3 w-10">No</th>
                        <th class="p-3 w-40">Jenis Ruangan</th>
                        <th class="p-3 w-32">Nama Ruangan</th>
                        <th class="p-3 w-32">Lantai</th>
                        <th class="p-3 w-28">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
</div>
@include('admin.ruangan.tambah')
@include('admin.ruangan.detail')
@include('admin.ruangan.edit')
@include('admin.ruangan.hapus')

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


//Detail
function openDetail(id) {
        console.log("ID yang dikirim:", id);
        fetch(`/api/kelola-ruangan/${id}`)
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                const data = response.data;
                openModal('detailModal');
                document.querySelector('.ruangan_id').textContent = data.ruangan_id ?? '-';
                document.querySelector('.ruangan_role_nama').textContent = data.ruangan_role?.ruangan_role_nama ?? '-';
                document.querySelector('.ruangan_nama').textContent = data.ruangan_nama ?? '-';
                document.querySelector('.lantai').textContent = data.lantai ?? '-';
            } else {
                alert("Data tidak ditemukan");
            }
        })
        .catch(error => {
            console.error("Gagal ambil data:", error);
        });
    }


//Edit
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
        lengthChange: false,
        processing: true,
        serverSide: true,
        ajax: {
            type: "POST",
            url: '{{ url("/api/kelola-ruangan") }}',
            data: function (d) {
                d.lantai = $('#filterLantai').val();
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
            { data: 'ruangan_role.ruangan_role_nama', name: 'ruangan_role', searchable: true },
            { data: 'ruangan_nama', name: 'ruangan_nama' },
            { data: 'lantai', name: 'lantai' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                            <button onclick="openDetail(${data.ruangan_id})" title="Lihat" class="text-gray-600 hover:text-blue-600">
                                <i class="fas fa-eye"></i>
                            </button>
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

    $('#filterLantai, #searchInput').on('change keyup', function () {
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

//DELETE 
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
