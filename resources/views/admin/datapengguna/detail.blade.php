<!-- MODAL DETAIL -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden transition-opacity duration-300">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 flex flex-col justify-between">
        <!-- Header -->
        <div class="flex justify-between items-start mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Detail Laporan</h2>
            <button class="text-gray-500 hover:text-red-500 text-2xl font-bold transition duration-200" onclick="closeModal('detailModal')">×</button>
        </div>

        <!-- Isi Konten -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Foto -->
            <div class="flex justify-center">
                  <div class=" overflow-hidden rounded">
                    <img src="{{ asset('assets/image/10.jpg') }}" alt="Foto" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Info -->
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-500">Nama Lengkap</h4>
                    <p class="text-lg text-gray-800 fullname">-</p>
                </div>
                <div>
                    <h4 class=" font-medium text-gray-500">Username</h4>
                    <p class="text-lg text-gray-800 username">-</p>
                </div>
                <div>
                    <h4 class=" font-medium text-gray-500">Role</h4>
                    <p class="text-lg text-gray-800 role">-</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-500">Email</h4>
                    <p class="text-lg text-gray-800 email">-</p>
                </div>
                <div>
                    <h4 class=" font-medium text-gray-500">Telepon</h4>
                    <p class="text-lg text-gray-800 no_telp">-</p>
                </div>
            </div>
        </div>

        <!-- Footer / Tombol Tutup -->
        <div class="mt-6 text-right">
            <button onclick="closeModal('detailModal')" class="bg-primary hover:bg-primary text-white px-5 py-2 rounded-lg transition duration-200">Tutup</button>
        </div>
    </div>

</div>
