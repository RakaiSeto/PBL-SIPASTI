@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between mb-3 mt-1">
        <input
            class="w-full max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
            placeholder="Cari..."
        />
    </div>

    <!-- Table -->
    <div class="overflow-auto">
        <table class="w-full table-auto text-sm text-left">
            <thead>
                <tr class="bg-slate-100">
                    <th class="p-3">No</th>
                    <th class="p-3">Ruang</th>
                    <th class="p-3">Fasilitas</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Pelapor</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tambahkan baris data -->
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">2</td>
                    <td class="p-3">RT001</td>
                    <td class="p-3">AC</td>
                    <td class="p-3">Agung</td>
                    <td class="p-3">2005-02-02</td>
                    <td class="p-3">
                        <span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">
                            selesai
                        </span>
                    </td>
                        <td class="p-3 flex">
                            <button class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 gap-x-4 " onclick="bukaModal()"><i class="fas fa-star"></i> Beri Feedback</button>
                        </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal Feedback -->
<div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 rounded flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg w-[90%] max-w-lg">
        <!-- Header -->
        <div class="relative mb-4">
            <h2 class="text-2xl font-bold">Umpan Balik</h2>
            <p class="text-sm text-gray-600">Berikan penilaian untuk laporan yang sudah selesai.</p>
            <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500" onclick="tutupModal()">✕</button>
        </div>

        <!-- Form -->
        <form id="feedbackForm" class="space-y-4" onsubmit="kirimUmpanBalik(event)">
            <!-- Dropdown Rating -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating (1–5)</label>
                <select id="rating" class="w-full border border-gray-300 bg-white rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih rating</option>
                    <option value="1">★☆☆☆☆</option>
                    <option value="2">★★☆☆☆</option>
                    <option value="3">★★★☆☆</option>
                    <option value="4">★★★★☆</option>
                    <option value="5">★★★★★</option>
                </select>
            </div>

            <!-- Komentar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                <textarea id="komentar" rows="3" placeholder="Tuliskan komentar Anda..." class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>

            <!-- Tombol Kirim -->
            <div class="text-right">
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Umpan Balik</button>
            </div>
        </form>
    </div>
</div>

</div>

<script>
    function bukaModal() {
        document.getElementById('feedbackModal').classList.remove('hidden');
    }

    function tutupModal() {
        document.getElementById('feedbackModal').classList.add('hidden');
    }

    function kirimUmpanBalik(event) {
        event.preventDefault();

        const rating = document.getElementById('rating').value;
        const komentar = document.getElementById('komentar').value;

        if (!rating || !komentar.trim()) {
            alert("Silakan isi semua kolom.");
            return;
        }

        // Simulasi kirim data
        alert("Umpan balik terkirim");

        // Tutup modal
        tutupModal();

        // Perbarui tampilan status (jika perlu, bisa via JS/refresh/AJAX)
        // Contoh: ubah teks status jadi "dinilai" atau sejenisnya
    }
    </script>

@endsection
