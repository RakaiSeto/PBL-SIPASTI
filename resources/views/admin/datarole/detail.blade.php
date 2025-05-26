<!-- MODAL DETAIL -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden transition-opacity duration-300">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95">
        <div class="relative mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detail Role</h2>
            <button class="absolute right-0 top-0 text-gray-500 hover:text-red-500 text-xl font-semibold transition duration-200" onclick="closeModal('detailModal')">×</button>
        </div>

        <div class="space-y-3">
            <div>
                <h4 class="  font-medium text-gray-500">Nama Role</h4>
                <p class="text-lg text-gray-800 role_nama">-</p>
            </div>
        </div>
    </div>
</div>
