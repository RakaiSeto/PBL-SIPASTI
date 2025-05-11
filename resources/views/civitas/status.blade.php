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
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tambahkan baris data -->
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">1</td>
                    <td class="p-3">RT001</td>
                    <td class="p-3">AC</td>
                    <td class="p-3">2005-02-02</td>
                    <td class="p-3">
                        <span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">
                            selesai
                        </span>
                    </td>
                        <td class="p-3 flex">
                            <button onclick="bukaDetailModal('selesai')" class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 gap-x-4 "><i class="fas fa-eye"></i> Detail</button>
                        </td>
                </tr>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">2</td>
                    <td class="p-3">RT001</td>
                    <td class="p-3">AC</td>
                    <td class="p-3">2005-02-02</td>
                    <td class="p-3">
                        <span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded uppercase font-bold">
                            Ditolak
                        </span>
                    </td>
                        <td class="p-3 flex">
                            <button onclick="bukaDetailModal('selesai')" class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 gap-x-4 "><i class="fas fa-eye"></i> Detail</button>
                        </td>
                </tr>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">3</td>
                    <td class="p-3">RT001</td>
                    <td class="p-3">AC</td>
                    <td class="p-3">2005-02-02</td>
                    <td class="p-3">
                        <span class="bg-yellow-500/20 text-yellow-900 text-xs px-2 py-1 rounded uppercase font-bold">
                            Diproses
                        </span>
                    </td>
                    <td class="p-3 flex">
                        <button onclick="bukaDetailModal('selesai')" class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 gap-x-4 "><i class="fas fa-eye"></i> Detail</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg w-[90%] max-w-2xl overflow-y-auto max-h-[90vh]">
        <!-- Header -->
        <div class="relative mb-4">
            <h2 class="text-2xl font-bold ">Detail Laporan</h2>
            <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500" onclick="tutupDetailModal()">✕</button>
        </div>

        <!-- Informasi Laporan -->
        <div class="space-y-6 mb-6">

            <!-- Info Utama -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium">Ruangan</h4>
                        <p class="text-gray-800 text-base font-semibold">RT001</p>
                    </div>
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium">Fasilitas</h4>
                        <p class="text-gray-800 text-base font-semibold">AC</p>
                    </div>
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium mb-1">Deskripsi</h4>
                        <p class="text-gray-800">AC tidak dingin sejak seminggu lalu.</p>
                    </div>
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium mb-1">Kategori</h4>
                        <p class="text-gray-800">Pendingin Ruangan</p>
                    </div>
                    {{-- <div>
                        <h4 class="text-sm text-gray-500 font-medium">Tanggal Pelaporan</h4>
                        <p class="text-gray-800 text-base">06-05-2025</p>
                    </div>
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium">Tanggal Diproses</h4>
                        <p class="text-gray-800 text-base">06-05-2025</p>
                    </div>
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium">Tanggal Selesai</h4>
                        <p class="text-gray-800 text-base">07-05-2025</p>
                    </div> --}}
                </div>

                <!-- Foto -->
                <div>
                    <h4 class="text-sm text-gray-500 font-medium mb-1">Foto Fasilitas</h4>
                    <div class="rounded overflow-hidden shadow border">
                        <img s src="{{ asset ('assets/image/5.jpg') }}" alt="Foto Fasilitas" class="w-full h-auto object-cover">
                    </div>
                </div>
            </div>

            <!-- Deskripsi & Kategori -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm text-gray-500 font-medium mb-1">Deskripsi</h4>
                    <p class="text-gray-800">AC tidak dingin sejak seminggu lalu.</p>
                </div>
                <div>
                    <h4 class="text-sm text-gray-500 font-medium mb-1">Kategori</h4>
                    <p class="text-gray-800">Pendingin Ruangan</p>
                </div>
            </div> --}}

            <!-- Riwayat Status -->
            <div>
                <h4 class="text-sm text-gray-500 font-medium mb-2">Riwayat Status</h4>
                <div class="bg-gray-50 p-4 rounded border">
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-flag text-gray-500 w-4"></i>
                            <span><strong>Baru:</strong> 06-05-2025</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-spinner text-yellow-500 w-4"></i>
                            <span><strong>Diproses:</strong> 06-05-2025</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600 w-4"></i>
                            <span><strong>Selesai:</strong> 07-05-2025</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>


        <!-- Form Umpan Balik -->
        <div id="feedbackSection" class="hidden border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Beri Umpan Balik</h3>
            <form onsubmit="kirimUmpanBalik(event)">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <select id="rating" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih rating</option>
                        <option value="1">★☆☆☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="4">★★★★☆</option>
                        <option value="5">★★★★★</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                    <textarea id="komentar" rows="3" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Umpan Balik</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function bukaDetailModal(status) {
        document.getElementById('detailModal').classList.remove('hidden');

        // Tampilkan form feedback jika status selesai
        if (status === 'selesai') {
            document.getElementById('feedbackSection').classList.remove('hidden');
        } else {
            document.getElementById('feedbackSection').classList.add('hidden');
        }
    }

    function tutupDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    function kirimUmpanBalik(event) {
        event.preventDefault();

        const rating = document.getElementById('rating').value;
        const komentar = document.getElementById('komentar').value;

        if (!rating || !komentar.trim()) {
            alert("Silakan isi semua kolom.");
            return;
        }

        alert("Umpan balik terkirim.");
        tutupDetailModal();

        // Tambahkan logika update status (misal ubah teks atau refresh tabel)
    }
    </script>

@endsection
