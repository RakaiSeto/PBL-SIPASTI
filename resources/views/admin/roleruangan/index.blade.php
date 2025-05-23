@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">
    <!-- Filter & Pencarian -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex gap-3 w-full md:w-auto">
            <!-- Filter Lokasi -->
            <div class="flex items-center gap-2">
                <label for="filterLokasi" class="text-sm font-medium text-slate-700">Filter :</label>
                <select
                    id="filterLokasi"
                    onchange="filterTable()"
                    class="h-10 text-sm border border-slate-300 rounded px-3 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Semua Lantai</option>
                    <option value="Lantai 1">Lantai 1</option>
                    <option value="Lantai 2">Lantai 2</option>
                    <option value="Lantai 3">Lantai 3</option>
                    <option value="Lantai 4">Lantai 4</option>
                    <option value="Lantai 5">Lantai 5</option>
                </select>
            </div>

            <!-- Input Cari -->
            <div class="flex items-center gap-2">
                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari nama ruangan..."
                    onkeyup="filterTable()"
                    class="w-full md:w-64 h-10 text-sm border border-slate-300 rounded px-3 focus:ring-blue-500 focus:border-blue-500"
                />
            </div>
        </div>

        <!-- Tombol Tambah -->
        <button
            onclick="openModal('addModal')"
            class="btn-primary">
            Tambah Ruangan
        </button>
    </div>

    <!-- Tabel Ruangan -->
    <div class="overflow-auto border border-slate-200 rounded">
        <table class="w-full table-fixed text-sm text-left">
            <thead class="bg-slate-100 text-slate-700">
                <tr>
                    <th class="p-3 w-32">ID Role Ruangan</th>
                    <th class="p-3 w-60">Nama Role Ruangan</th>
                    <th class="p-3 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="roomTable">
                <!-- Data Ruangan -->
                <tr class="border-t hover:bg-slate-50" data-id="R001" data-nama="Ruang Teori" data-lokasi="Lantai 5">
                    <td class="p-3 font-semibold text-slate-800">R001</td>
                    <td class="p-3">Ruang Teori</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <button onclick="openDetail(this)" class="text-gray-600 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button onclick="openEdit(this)" class="text-gray-600 hover:text-yellow-600" title="Edit"><i class="fas fa-pen"></i></button>
                            <button onclick="openDelete(this)" class="text-gray-600 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>


                <!-- Baris Tidak Ada Data -->
                <tr id="noDataRow" class="hidden">
                    <td colspan="5" class="text-center text-slate-500 py-4">Tidak ada data yang sesuai.</td>
                </tr>
            </tbody>
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

<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-4">Tambah Ruang dan Fasilitas</h2>
        <form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Data berhasil ditambahkan!');">
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="addRole" class="block mb-1 font-medium">Role</label>
                    <select id="addRole" class="w-full border-gray-200 px-3 py-2 rounded" required >
                    <option value="" >Pilih Role</option>
                    <option value="Admin" class="text-slate-700">Admin</option>
                    <option value="Sarpras" class="text-slate-700">Sarpras</option>
                    <option value="Civitas" class="text-slate-700">Civitas</option>
                    <option value="Teknisi" class="text-slate-700">Teknisi</option>
                </select>
                </div>
            </div>
            <div class="space-y-2 text-slate-900">
                <div>
                    <label for="addFasilitas" class="block mb-1 font-medium">Fasilitas</label>
                    <select id="addFasilitas" class="select2 w-full border-gray-200 px-3 py-2 rounded" multiple="multiple" required>
                        <option value="AC">AC</option>
                        <option value="Proyektor">Proyektor</option>
                        <option value="Whiteboard">Whiteboard</option>
                        <option value="Kursi">Kursi</option>
                        <option value="Meja">Meja</option>
                        <option value="PC">PC</option>
                        <option value="LAN">LAN</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
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
            <h4 class="text-base font-medium text-gray-500">Nama Lengkap</h4>
            <p class="text-lg text-gray-800">Agung Fradiansyah</p>
          </div>
          <div>
            <h4 class="text-sm font-medium text-gray-500">Username</h4>
            <p class="text-lg text-gray-800">agungAdmin</p>
          </div>
          <div>
            <h4 class="text-sm font-medium text-gray-500">Role</h4>
            <p class="text-lg text-gray-800">Admin</p>
          </div>
          <div>
            <h4 class="text-sm font-medium text-gray-500">Email</h4>
            <p class="text-lg text-gray-800">agung@gmail.com</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-end gap-2 mt-6">
      <button type="button" onclick="closeModal('detailModal')" class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Tutup</button>
    </div>

  </div>
</div>


<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
    <h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>

    <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diubah!'); ">
      <div class="space-y-2 text-slate-800">
        <div>
          <label class="block mb-1 font-medium text-sm">Nama Lengkap</label>
          <input type="text" class="w-full border-gray-200 text-sm  rounded" placeholder="Masukkan Nama Lengkap" required>
        </div>
        <div>
          <label class="block mb-1 font-medium text-sm">Username</label>
          <input type="text" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan Username">
        </div>
        <div>
          <label class="block mb-1 font-medium text-sm">Email</label>
          <input type="email" class="w-full border-gray-200 text-sm rounded" placeholder="Masukkan Email" required>
        </div>
        <div>
          <label class="block mb-1 font-medium text-sm">Role</label>
          <select class="w-full border-gray-200 px-2 py-2 text-sm rounded" required>
            <option value="">Pilih Role</option>
            <option value="Admin">Admin</option>
            <option value="Sarpras">Sarpras</option>
            <option value="Civitas">Civitas</option>
            <option value="Teknisi">Teknisi</option>
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
@include('component.popsukses')

<!--modalhapus-->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
    <h2 class="text-xl font-semibold text-slate-800 mb-4">Konfirmasi Hapus</h2>
    <p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus pengguna berikut ini?</p>

    <div class="text-sm text-slate-700 space-y-2 mb-5">
      <div><span class="font-medium">Nama Lengkap:</span> <span id="delNama"></span></div>
      <div><span class="font-medium">Username:</span> <span id="delUsername"></span></div>
      <div><span class="font-medium">Role:</span> <span id="delRole"></span></div>
      <div><span class="font-medium">Email:</span> <span id="delEmail"></span></div>
    </div>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
            <button type="button" onclick="closeModal('deleteModal'); showDelete('deleteSuccess');" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
        </div>
        <button onclick="closeModal('deleteModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>
@include('component.pophapus')
<script>
    function filterTable() {
        const searchValue = document.getElementById("searchInput").value.toLowerCase();
        const roleFilter = document.getElementById("filterRole").value;
        const rows = document.querySelectorAll("#userTable tr");
        let visibleCount = 0;

        rows.forEach(row => {
            const nama = row.children[1].textContent.toLowerCase();
            const username = row.children[2].textContent.toLowerCase();
            const role = row.children[3].textContent.trim().toLowerCase();

            const matchSearch = nama.includes(searchValue) || username.includes(searchValue);
            const matchRole = !roleFilter || role === roleFilter.toLowerCase();

            if (matchSearch && matchRole) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById("noDataRow").classList.toggle("hidden", visibleCount > 0);
    }

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }


    function openModal(id) {
  document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
  document.getElementById(id).classList.add('hidden');
}

function openDetail() {
  openModal('detailModal');
}


function openFasilitas() {
  openModal('detailModal');
}
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openEdit() {
        openModal('editModal');
    }

    function openDelete() {
        openModal('deleteModal');
    }

    $(document).ready(function () {
        $('#addFasilitas').select2({
            placeholder: "Pilih Fasilitas",
            width: '100%',
            allowClear: true
        });
    });

</script>
@endsection
