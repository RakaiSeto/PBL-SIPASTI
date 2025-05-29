@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">

            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="filterFasilitas" class="text-sm text-slate-700">Fasilitas</label>
                <select id="filterFasilitas"
                    class="border border-slate-300 rounded px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-50">
                    <option value="">Semua</option>
                    <option value="AC">AC</option>
                    <option value="Proyektor">Proyektor</option>
                    <option value="Kipas Angin">Kipas Angin</option>
                    <option value="Lampu">Lampu</option>
                </select>

                <input class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
                    placeholder="Cari..." />
            </div>


            <!-- Dropdown Tampilkan data di kanan -->
            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="tampilData" class="text-sm text-slate-700">Tampilkan</label>
                <select id="tampilData"
                    class="border border-slate-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                <p
                                    class="flex items-center justify-between gap-2 text-sm font-bold leading-none text-slate-800">
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
                        <td class="p-3 font-semibold">1</td>
                        <td class="p-3">RT001</td>
                        <td class="p-3">AC</td>
                        <td class="p-3">2005-02-02</td>
                        <td class="p-3">
                            <span class="bg-yellow-500/20 text-yellow-900 text-xs px-2 py-1 rounded font-bold">
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="p-3 flex gap-2">
                            <button onclick="bukaDetailModal('selesai')"
                                class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 gap-x-4 "><i
                                    class="fas fa-eye pr-1"></i> Verifikasi</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>



        @include('component.plagination')
    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-lg w-[90%] max-w-2xl overflow-y-auto max-h-[90vh]">
            <!-- Header -->
            <div class="relative mb-4">
                <h2 class="text-2xl font-bold">Detail Laporan</h2>
                <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500"
                    onclick="tutupDetailModal()">✕</button>
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
                    </div>

                    <!-- Foto -->
                    <div>
                        <h4 class="text-sm text-gray-500 font-medium mb-1">Foto Fasilitas</h4>
                        <div class="rounded overflow-hidden shadow border">
                            <img src="{{ asset('assets/image/5.jpg') }}" alt="Foto Fasilitas"
                                class="w-full h-auto object-cover">
                        </div>
                    </div>
                </div>

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
                                <span><strong>Diproses:</strong> - </span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-green-600 w-4"></i>
                                <span><strong>Selesai:</strong> -</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex justify-end gap-3 border-t pt-4">
                <button onclick="bukaDetailModal('selesai')"
                    class="flex items-center gap-2 bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition">
                    <i class="fas fa-times"></i> Tolak
                </button>
                <button onclick="bukaDetailModal('selesai')"
                    class="flex items-center gap-2 bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition">
                    <i class="fas fa-check"></i> Terima
                </button>
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

        // filter
        const fasilitasFilter = document.getElementById('filterFasilitas');
        const inputCari = document.querySelector('input[placeholder="Cari..."]');

        fasilitasFilter.addEventListener('change', filterData);
        inputCari.addEventListener('input', filterData);

        function filterData() {
            const filterFasilitas = fasilitasFilter.value.toLowerCase();
            const keyword = inputCari.value.toLowerCase();

            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const fasilitas = row.children[2].textContent.toLowerCase();
                const rowText = row.textContent.toLowerCase();

                const matchFasilitas = !filterFasilitas || fasilitas.includes(filterFasilitas);
                const matchKeyword = rowText.includes(keyword);

                row.style.display = (matchFasilitas && matchKeyword) ? '' : 'none';
            });
        }
    </script>
@endsection
