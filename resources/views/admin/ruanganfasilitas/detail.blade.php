<!-- MODAL DETAIL -->
<div id="detailModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden transition-opacity duration-300">
    <div
        class="bg-white p-8 rounded shadow-2xl w-full max-w-xl transform transition-all duration-300 scale-95 space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between border-b pb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Detail Ruangan dan Fasilitas</h2>
            <button onclick="closeModal('detailModal')"
                class="text-gray-500 hover:text-red-500 text-2xl leading-none">&times;</button>
        </div>

        <!-- Konten Dua Kolom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Kiri: Info Ruang -->
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Nama Ruang</h4>
                    <p class="text-lg text-gray-800 font-semibold">RT01</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Lokasi</h4>
                    <p class="text-lg text-gray-800 font-semibold">Lantai 5</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Jumlah Fasilitas</h4>
                    <p class="text-lg text-gray-800 font-semibold">6 Unit</p>
                </div>
            </div>

            <!-- Kanan: Fasilitas -->
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Nama Fasilitas</h4>
                <ul class="list-disc list-inside text-gray-800 space-y-1 pl-2">
                    <li>AC</li>
                    <li>Projector</li>
                    <li>Kelistrikan</li>
                    <li>Meja</li>
                    <li>Kursi</li>
                    <li>Wifi</li>
                </ul>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end pt-4 border-t">
            <button type="button" onclick="closeModal('detailModal')"
                class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 text-sm">Tutup</button>
        </div>

    </div>
</div>
