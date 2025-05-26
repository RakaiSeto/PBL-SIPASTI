<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden transition-opacity duration-300">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 flex flex-col justify-between">
        <div class="flex justify-between items-start mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Detail Fasilitas</h2>
            <button class="text-gray-500 hover:text-red-500 text-2xl font-bold transition duration-200" onclick="closeModal('detailModal')">×</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-500">ID Fasilitas</h4>
                    <p class="text-lg text-gray-800 fasilitas_id">-</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-500">Nama Fasilitas</h4>
                    <p class="text-lg text-gray-800 fasilitas_nama">-</p>
                </div>
            </div>
        </div>
        <div class="mt-6 text-right">
            <button onclick="closeModal('detailModal')" class="bg-primary hover:bg-primary text-white px-5 py-2 rounded-lg transition duration-200">Tutup</button>
        </div>
    </div>

</div>
