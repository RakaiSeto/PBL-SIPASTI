    @extends('layouts.app')

    @section('content')
    <div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">

        <!-- Filter Berdasarkan Fasilitas -->
    <div class="flex items-center gap-2 whitespace-nowrap">
        <label for="filterFasilitas" class="text-base text-slate-700">Fasilitas</label>
        <select id="filterFasilitas" class="border border-slate-300 rounded px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua</option>
            <option value="AC">AC</option>
            <option value="Proyektor">Proyektor</option>
            <option value="Kipas Angin">Kipas Angin</option>
            <option value="Lampu">Lampu</option>
            <!-- Tambahkan opsi lain sesuai daftar fasilitas -->
        </select>

        <!-- Input Cari di kiri -->
        <input
            class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
            placeholder="Cari..."
        />
    </div>


        <!-- Dropdown Tampilkan data di kanan -->
        <div class="flex items-center gap-2 whitespace-nowrap">
            <label for="tampilData" class=" text-slate-700">Tampilkan</label>
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
                        <td class="p-3">1</td>
                        <td class="p-3">RT001</td>
                        <td class="p-3">AC</td>
                        <td class="p-3">2005-02-02</td>
                        <td class="p-3">
                            <span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">
                                selesai
                            </span>
                        </td>
                            <td class="p-3 flex ">
                                <button onclick="bukaDetailModal('selesai')" class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 "> Beri Nilai</button>
                            </td>
                    </tr>
                    <tr class="hover:bg-slate-50 border-b">
                        <td class="p-3 font-semibold">2</td>
                        <td class="p-3">RT001</td>
                        <td class="p-3">Kipas Angin</td>
                        <td class="p-3">2005-02-02</td>
                        <td class="p-3">
                            <span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded uppercase font-bold">
                                Ditolak
                            </span>
                        </td>
                            <td class="p-3 flex">
                                <button onclick="bukaDetailModal('selesai')" class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 "> Beri Nilai</button>
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
                                <button onclick="bukaDetailModal('selesai')" class="bg-primary text-white rounded py-2 px-4 rounded hover:bg-blue-700 "> Beri Nilai</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>



        @include('component.plagination')
    </div>
    <!-- Modal Detail -->
    <!-- Modal -->
        <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50 transition-opacity duration-300">
            <div class="bg-white rounded-xl p-6 w-[95%] max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl flex flex-col">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Penilaian SPK</h2>
                    <button class="text-gray-500 hover:text-red-500 transition" onclick="document.getElementById('detailModal').classList.add('hidden')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Konten 2 Kolom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-grow">
                    <!-- Kiri: Info Kerusakan -->
                    <div class="space-y-4">
                        <img src="{{ asset('assets/image/5.jpg') }}" alt="Foto Kerusakan" class="rounded border w-full object-cover h-60 shadow-sm">
                        <div>
                            <p class="text-sm text-gray-500">Nama Fasilitas</p>
                            <p class="text-gray-800 font-medium">Kursi</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Keterangan</p>
                            <p class="text-gray-800 font-medium">Kursi patah di ruang kelas, menyebabkan ketidaknyamanan saat belajar.</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Laporan</p>
                            <p class="text-gray-800 font-medium">15 Mei 2025</p>
                        </div>
                    </div>

                    <!-- Kanan: Form Penilaian -->
                    <form id="penilaianForm" class="space-y-4 text-sm">
                        <div class="grid grid-cols-1 gap-3">
                            <!-- Kerusakan -->
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Kerusakan</label>
                                <select name="kerusakan" class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
                                    <option value="1">Sangat ringan (1)</option>
                                    <option value="2">Ringan (2)</option>
                                    <option value="3">Sedang (3)</option>
                                    <option value="4">Berat (4)</option>
                                    <option value="5">Sangat berat (5)</option>
                                </select>
                            </div>
                            <!-- Dampak -->
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Dampak</label>
                                <select name="dampak" class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
                                    <option value="1">Sangat rendah (1)</option>
                                    <option value="2">Rendah (2)</option>
                                    <option value="3">Sedang (3)</option>
                                    <option value="4">Tinggi (4)</option>
                                    <option value="5">Sangat tinggi (5)</option>
                                </select>
                            </div>
                            <!-- Frekuensi -->
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Frekuensi</label>
                                <select name="frekuensi" class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
                                    <option value="1">Sangat jarang (1)</option>
                                    <option value="2">Jarang (2)</option>
                                    <option value="3">Sering (3)</option>
                                    <option value="4">Sangat sering (4)</option>
                                    <option value="5">Selalu digunakan (5)</option>
                                </select>
                            </div>
                            <!-- Jumlah Pelapor -->
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Jumlah Pelapor</label>
                                <select name="pelapor" class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
                                    <option value="1">< 5 (1)</option>
                                    <option value="2">5-10 (2)</option>
                                    <option value="3">11-20 (3)</option>
                                    <option value="4">21-50 (4)</option>
                                    <option value="5">> 50 (5)</option>
                                </select>
                            </div>
                            <!-- Waktu Kerusakan -->
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Waktu Kerusakan</label>
                                <select name="waktu_kerusakan" class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
                                    <option value="1">< 1 hari (1)</option>
                                    <option value="2">1-2 hari (2)</option>
                                    <option value="3">3-5 hari (3)</option>
                                    <option value="4">6-14 hari (4)</option>
                                    <option value="5">> 14 hari (5)</option>
                                </select>
                            </div>
                            <!-- Waktu Perbaikan -->
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Waktu Perbaikan</label>
                                <select name="waktu_perbaikan" class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
                                    <option value="1">< 24 jam (1)</option>
                                    <option value="2">1-2 hari (2)</option>
                                    <option value="3">3-5 hari (3)</option>
                                    <option value="4">1 minggu (4)</option>
                                    <option value="5">> 1 minggu (5)</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer: Tombol -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                    <button type="button" onclick="document.getElementById('detailModal').classList.add('hidden')" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" form="penilaianForm" class="px-6 py-2 bg-primary text-white rounded transition">Beri Nilai</button>
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
