@extends('layouts.app')

@section('content')
    <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous">

    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="bg-white p-6 rounded shadow space-y-4 text-sm">
        <!-- Filter dan Tombol -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3 flex-wrap">
                <label for="searchInput" class="  font-medium text-slate-700">Cari:</label>
                <input type="text" id="searchInput" placeholder="Cari Nama Role..."
                    class="w-full md:w-64 h-10   border border-slate-300 rounded px-3">
            </div>

            <div class="flex gap-2">
                <button onclick="openModal('addModal')"
                    class="h-10 px-4 text-white bg-primary rounded hover:opacity-90 transition">
                    Tambah data
                </button>

                <a href="{{ route('admin.datarole.export_excel') }}"
                    class="h-10 px-4 text-white bg-green-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                    Export Excel
                </a>

                <a href="{{ route('admin.datarole.export_pdf') }}"
                    class="h-10 px-4 text-white bg-red-600 rounded hover:opacity-90 transition inline-flex items-center justify-center">
                    Export PDF
                </a>
            </div>
        </div>

        <!-- TABEL -->
        <div class="overflow-auto rounded">
            <table id="roleTable" class="w-full text-left border border-slate-200 rounded"
                style="border-collapse: separate; border-spacing: 0;">
                <thead class="bg-slate-100 text-slate-700 font-medium">
                    <tr>
                        <th class="p-3 w-10">No</th>
                        <th class="p-3 w-40">Nama Role</th>
                        <th class="p-3 w-10">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>


    </div>
    @include('admin.datarole.tambah')
    @include('admin.datarole.edit')
    @include('admin.datarole.hapus')
    @include('admin.datarole.detail')


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
            fetch(`/api/kelola-role/${id}`, {
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
                        const roleNamaElement = document.querySelector('.role_nama');
                        if (roleNamaElement) {
                            roleNamaElement.textContent = data.role_nama || '-';
                        } else {
                            console.error('Elemen .role_nama tidak ditemukan');
                        }
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
            fetch(`/api/kelola-role/${id}`, {
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
                        const editRoleId = document.getElementById('editRoleId');
                        const editRoleNama = document.getElementById('editRoleNama');
                        if (editRoleId && editRoleNama) {
                            editRoleId.value = id;
                            editRoleNama.value = data.role_nama || '';
                            openModal('editModal');
                        } else {
                            console.error('Elemen editRoleId atau editRoleNama tidak ditemukan');
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
            const deleteRoleId = document.getElementById('deleteRoleId');
            if (deleteRoleId) {
                deleteRoleId.value = id;
                openModal('deleteModal');
            } else {
                console.error('Elemen deleteRoleId tidak ditemukan');
            }
        }

        // DATA TABLE INITIALIZATION
        $(document).ready(function() {
            try {
                table = $('#roleTable').DataTable({
                    searching: false,
                    lengthChange: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: "POST",
                        url: '{{ url('/api/kelola-role') }}',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: function(d) {
                            d.search = $('#searchInput').val();
                        },
                        error: function(xhr, error, thrown) {
                            console.error('Gagal memuat DataTable:', error, thrown);
                            showError('Gagal memuat data tabel: ' + (xhr.statusText ||
                                'Kesalahan tidak diketahui'));
                        }
                    },
                    columns: [{
                            data: null,
                            name: 'no',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'role_nama',
                            name: 'role_nama',
                            searchable: true
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                return `
                            <div class="flex gap-2">
                                <button onclick="openDetail(${data.role_id})" title="Lihat" class="text-gray-600 hover:text-blue-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="openEdit(${data.role_id})" title="Edit" class="text-gray-600 hover:text-yellow-600">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button onclick="openDelete(${data.role_id})" title="Hapus" class="text-gray-600 hover:text-red-600">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>`;
                            }
                        }
                    ],
                    createdRow: function(row, data, dataIndex) {
                        $(row).addClass('border-t hover:bg-slate-50');
                        $('td', row).addClass('p-3 text-slate-700');
                    }
                });

                $('#searchInput').on('keyup', function() {
                    if (table) {
                        table.ajax.reload(null, false);
                    } else {
                        console.error('DataTable belum diinisialisasi');
                    }
                });
            } catch (error) {
                console.error('Gagal menginisialisasi DataTable:', error);
                showError('Gagal menginisialisasi tabel: ' + error.message);
            }
        });

        // TAMBAH DATA
        document.getElementById('addForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const role_nama = document.getElementById('addRoleNama')?.value;

            if (!role_nama) {
                showError('Nama role tidak boleh kosong');
                return;
            }

            fetch('/api/kelola-role/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        role_nama
                    })
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
                        showSuccess('Role berhasil ditambahkan!');
                        if (table) {
                            table.ajax.reload(null, false); // Refresh DataTable tanpa reset paging
                        } else {
                            console.error('DataTable tidak tersedia untuk disegarkan');
                            location.reload(); // Fallback ke reload halaman
                        }
                    } else {
                        showError('Gagal menambahkan role: ' + (result.message || 'Kesalahan tidak diketahui'));
                    }
                })
                .catch(error => {
                    console.error('Error tambah data:', error);
                    showError('Terjadi kesalahan saat mengirim data: ' + error.message);
                    if (table) {
                        table.ajax.reload(null,
                        false); // Coba segarkan tabel untuk memeriksa apakah data tersimpan
                    }
                });
        });

        // EDIT DATA
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editRoleId')?.value;
            const role_nama = document.getElementById('editRoleNama')?.value;

            if (!id || !role_nama) {
                showError('ID atau nama role tidak boleh kosong');
                return;
            }

            fetch(`/api/kelola-role/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        role_nama
                    })
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
                        showSuccess('Role berhasil diubah!');
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
                        table.ajax.reload(null,
                        false); // Coba segarkan tabel untuk memeriksa apakah data tersimpan
                    }
                });
        });

        // DELETE DATA
        function confirmDelete() {
            const id = document.getElementById('deleteRoleId')?.value;

            if (!id) {
                showError('ID role tidak ditemukan');
                return;
            }

            fetch(`/api/kelola-role/${id}`, {
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
                        showDelete('Role berhasil dihapus!');
                        if (table) {
                            table.ajax.reload(null, false); // Refresh DataTable tanpa reset paging
                        } else {
                            console.error('DataTable tidak tersedia untuk disegarkan');
                            location.reload(); // Fallback ke reload halaman
                        }
                    } else {
                        showError('Gagal menghapus role: ' + (result.message || 'Kesalahan tidak diketahui'));
                    }
                })
                .catch(error => {
                    console.error('Error hapus data:', error);
                    showError('Terjadi kesalahan saat menghapus data: ' + error.message);
                });
        }
    </script>
@endsection
