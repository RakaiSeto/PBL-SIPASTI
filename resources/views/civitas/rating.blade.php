@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">
    <!-- Input Cari di kiri -->
    <input
        class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
        placeholder="Cari..."
    />

    <!-- Dropdown Tampilkan data di kanan -->
    <div class="flex items-center gap-2 whitespace-nowrap">
        <label for="tampilData" class="text-sm text-slate-700">Tampilkan</label>
        <select id="tampilData" class="border border-slate-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>
</div>

    <!-- Table -->
    <div class="overflow-auto">
        <table class="w-full table-auto text-sm text-left">
            <thead>
    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
        @php
            $headers = ['No', 'Ruang', 'Fasilitas', 'Tanggal', 'Status', 'Aksi'];
        @endphp
        @foreach ($headers as $header)
        <th class="p-3 transition-colors cursor-pointer hover:bg-slate-100">
            <p class="flex items-center justify-between gap-2 text-sm font-bold leading-none text-slate-800">
                {{ $header }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 15L12 18.75 15.75 15M8.25 9L12 5.25 15.75 9" />
                </svg>
            </p>
        </th>
        @endforeach
    </tr>
</thead>

            <tbody>
                <!-- Tambahkan baris data -->
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">2</td>
                    <td class="p-3">RT001</td>
                    <td class="p-3">AC</td>
                    <td class="p-3">2005-02-02</td>
                    <td class="p-3">
                        <span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">
                            selesai
                        </span>
                    </td>
                        <td class="p-3 flex">
                            <button class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 gap-x-4 " onclick="bukaModal()"> Beri Feedback</button>
                        </td>
                </tr>
            </tbody>
        </table>
    </div>


<!-- Pagination Minimalis -->
<div class="flex justify-between items-center px-4 py-3">
    <span class="text-sm text-gray-500">
        Menampilkan <span class="font-medium text-gray-700">1-5</span> dari <span class="font-medium text-gray-700">45</span>
    </span>

    <nav class="inline-flex items-center space-x-1">
        <button class="px-3 py-1 text-sm text-gray-500 bg-white border border-gray-300 rounded hover:bg-gray-100">
            ‹
        </button>
        <button class="px-3 py-1 text-sm text-white bg-primary border border-gray-300 rounded hover:bg-slate-700">
            1
        </button>
        <button class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100">
            2
        </button>
        <button class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100">
            3
        </button>
        <button class="px-3 py-1 text-sm text-gray-500 bg-white border border-gray-300 rounded hover:bg-gray-100">
            ›
        </button>
    </nav>
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
