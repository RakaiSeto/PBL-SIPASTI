@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow space-y-4">
    <livewire:list-user />
</div>

<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-lg font-semibold mb-4">Tambah Pengguna</h2>
        <form onsubmit="event.preventDefault(); closeModal('addModal'); showSuccess('Data berhasil ditambahkan!');">
            <div class="space-y-3">
                <input type="text" placeholder="Nama Lengkap" class="w-full border px-3 py-2 rounded text-sm" required>
                <input type="text" placeholder="Username" class="w-full border px-3 py-2 rounded text-sm" required>
                <input type="email" placeholder="Email" class="w-full border px-3 py-2 rounded text-sm" required>
                <select class="w-full border px-3 py-2 rounded text-sm" required>
                    <option value="">Pilih Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Sarpras">Sarpras</option>
                    <option value="Civitas">Civitas</option>
                    <option value="Teknisi">Teknisi</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>
        <button onclick="closeModal('addModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-lg font-semibold mb-4">Edit Pengguna</h2>
        <form onsubmit="event.preventDefault(); closeModal('editModal'); showSuccess('Data berhasil diperbarui!');">
            <div class="space-y-3">
                <input id="editNama" type="text" class="w-full border px-3 py-2 rounded text-sm" required>
                <input id="editUsername" type="text" class="w-full border px-3 py-2 rounded text-sm" required>
                <input id="editEmail" type="email" class="w-full border px-3 py-2 rounded text-sm" required>
                <select id="editRole" class="w-full border px-3 py-2 rounded text-sm" required>
                    <option value="">Pilih Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Sarpras">Sarpras</option>
                    <option value="Civitas">Civitas</option>
                    <option value="Teknisi">Teknisi</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">Simpan Perubahan</button>
            </div>
        </form>
        <button onclick="closeModal('editModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- MODAL HAPUS -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold text-red-600 mb-4">Konfirmasi Hapus</h2>
        <p class="text-sm text-slate-600">Apakah Anda yakin ingin menghapus pengguna ini?</p>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm">Batal</button>
            <button type="button" onclick="closeModal('deleteModal'); showSuccess('Data berhasil dihapus!');" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
        </div>
        <button onclick="closeModal('deleteModal')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-lg">&times;</button>
    </div>
</div>

<!-- MODAL DETAIL -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 animate-fadeIn relative">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-blue-100 text-blue-600 rounded-full p-2">
                <i class="fas fa-user text-lg"></i>
            </div>
            <h3 class="text-lg font-semibold text-slate-800">Detail Pengguna</h3>
        </div>

        <!-- Isi -->
        <div class="text-sm space-y-3 text-slate-700">
            <div class="flex justify-between">
                <span class="font-medium">ID:</span>
                <span id="detailId"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium">Nama Lengkap:</span>
                <span id="detailNama"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium">Username:</span>
                <span id="detailUsername"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium">Email:</span>
                <span id="detailEmail"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium">Role:</span>
                <span id="detailRole" class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold"></span>
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end mt-6">
            <button onclick="closeModal('detailModal')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-sm rounded-md">
                Tutup
            </button>
        </div>

        <!-- Tombol Close -->
        <button onclick="closeModal('detailModal')" class="absolute top-3 right-4 text-slate-400 hover:text-red-500 text-xl">
            &times;
        </button>
        
    </div>
</div>


<!-- MODAL SUKSES -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-md text-center max-w-sm w-full">
        <h3 class="text-green-600 font-semibold text-lg mb-2">Berhasil!</h3>
        <p id="successMessage" class="text-sm text-slate-700"></p>
    </div>
</div>

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

    function showSuccess(message) {
        document.getElementById("successMessage").textContent = message;
        const modal = document.getElementById("successModal");
        modal.classList.remove("hidden");
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 2000);
    }

    // Untuk tombol lihat detail
    function openDetail(button) {
        const tr = button.closest('tr');
        document.getElementById('detailNama').textContent = tr.dataset.nama;
        document.getElementById('detailUsername').textContent = tr.dataset.username;
        document.getElementById('detailEmail').textContent = tr.dataset.email;
        document.getElementById('detailRole').textContent = tr.dataset.role;
        openModal('detailModal');
    }

    // Untuk tombol edit
    function openEdit(button) {
        const tr = button.closest('tr');
        document.getElementById('editNama').value = tr.dataset.nama;
        document.getElementById('editUsername').value = tr.dataset.username;
        document.getElementById('editEmail').value = tr.dataset.email;
        document.getElementById('editRole').value = tr.dataset.role;
        openModal('editModal');
    }

    // Untuk tombol hapus, sudah ada openDelete dari contoh sebelumnya, 
    // tapi kita perlu definisikan:
    function openDelete() {
        openModal('deleteModal');
    }

    function showDetail(id, nama, username, email, role) {
    document.getElementById('detailId').textContent = id;
    document.getElementById('detailNama').textContent = nama;
    document.getElementById('detailUsername').textContent = username;
    document.getElementById('detailEmail').textContent = email;
    document.getElementById('detailRole').textContent = role;
    openModal('detailModal');
}

</script>
@endsection
