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
