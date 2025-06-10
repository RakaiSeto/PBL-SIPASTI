@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">
            <!-- Filter Fasilitas -->
            <div class="flex items-center gap-2 whitespace-nowrap">
                <label for="filterFasilitas" class="text-sm text-slate-700">Fasilitas</label>
                <select id="filterFasilitas"
                    class="border border-slate-300 rounded px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="AC">AC</option>
                    <option value="Proyektor">Proyektor</option>
                    <option value="Kipas Angin">Kipas Angin</option>
                    <option value="Lampu">Lampu</option>
                </select>

                <input class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
                    placeholder="Cari..." />
            </div>

            <!-- Dropdown Tampilkan data -->
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
                            $headers = ['ID', 'Fasilitas', 'Teknisi', 'Status', 'Aksi'];
                        @endphp
                        @foreach ($headers as $header)
                            <th class="p-3">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh data statis -->
                    <tr class="hover:bg-slate-50 border-b">
                        <td class="p-3 font-semibold">1</td>
                        <td class="p-3">AC</td>
                        <td class="p-3">Budi</td>
                        <td class="p-3">
                            <span class="bg-yellow-500/20 text-yellow-900 text-xs px-2 py-1 rounded uppercase font-bold">
                                Ditugaskan
                            </span>
                        </td>
                        <td class="p-3">
                            <button class="text-blue-600 hover:underline open-modal" data-id="1" data-fasilitas="AC"
                                data-teknisi="Budi" data-status="Ditugaskan">Detail</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 border-b">
                        <td class="p-3 font-semibold">2</td>
                        <td class="p-3">Kipas Angin</td>
                        <td class="p-3">Andi</td>
                        <td class="p-3">
                            <span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">
                                Selesai dikerjakan
                            </span>
                        </td>
                        <td class="p-3">
                            <button class="text-blue-600 hover:underline open-modal" data-id="2"
                                data-fasilitas="Kipas Angin" data-teknisi="Andi"
                                data-status="Selesai dikerjakan">Detail</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 border-b">
                        <td class="p-3 font-semibold">3</td>
                        <td class="p-3">Lampu</td>
                        <td class="p-3">Sari</td>
                        <td class="p-3">
                            <span class="bg-blue-500/20 text-blue-900 text-xs px-2 py-1 rounded uppercase font-bold">
                                Sedang Dikerjakan
                            </span>
                        </td>
                        <td class="p-3">
                            <button class="text-blue-600 hover:underline open-modal" data-id="3" data-fasilitas="Lampu"
                                data-teknisi="Sari" data-status="Sedang Dikerjakan">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded shadow-lg w-[90%] max-w-2xl overflow-y-auto max-h-[90vh]">
                <!-- Header -->
                <div class="relative mb-4">
                    <h2 class="text-2xl font-bold">Detail Laporan Sarpras</h2>
                    <button class="absolute right-2 top-2 text-gray-500 hover:text-red-500"
                        onclick="closeModal()">✕</button>
                </div>

                <!-- Informasi Laporan -->
                <div class="space-y-6 mb-6">
                    <!-- Info Utama -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <div>
                                <h4 class="text-sm text-gray-500 font-medium">Pelapor</h4>
                                <p class="user_id text-gray-800 text-base font-semibold">-</p>
                            </div>
                            <div>
                                <h4 class="text-sm text-gray-500 font-medium">Ruangan</h4>
                                <p class="ruang text-gray-800 text-base font-semibold">-</p>
                            </div>
                            <div>
                                <h4 class="text-sm text-gray-500 font-medium">Fasilitas</h4>
                                <p class="fasilitas text-gray-800 text-base font-semibold">-</p>
                            </div>
                            <div>
                                <h4 class="text-sm text-gray-500 font-medium mb-1">Deskripsi</h4>
                                <p class="deskripsi text-gray-800">-</p>
                            </div>
                            <div>
                                <h4 class="text-sm text-gray-500 font-medium mb-1">Tanggal</h4>
                                <p class="tanggal text-gray-800">-</p>
                            </div>
                            <div>
                                <h4 class="text-sm text-gray-500 font-medium mb-1">Status</h4>
                                <p class="status text-gray-800">-</p>
                            </div>
                        </div>

                        <!-- Foto -->
                        <div>
                            <h4 class="text-sm text-gray-500 font-medium mb-1">Foto Fasilitas</h4>
                            <div class="rounded overflow-hidden shadow border">
                                <img id="detail-photo" src="/assets/image/placeholder.jpg" alt="Foto Fasilitas"
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
                                    <span><strong>Baru:</strong> <span id="statusBaru">-</span></span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-spinner text-yellow-500 w-4"></i>
                                    <span><strong>Diproses:</strong> <span id="statusProses">-</span></span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-600 w-4"></i>
                                    <span><strong>Selesai:</strong> <span id="statusSelesai">-</span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t pt-4" id="modalActions">
                    <!-- Tombol aksi akan dimuat via JS -->
                </div>
            </div>
        </div>
        @include('component.plagination')

    </div>

    </div>

    <script>
        // Filter Fasilitas dan Cari
        const fasilitasFilter = document.getElementById('filterFasilitas');
        const inputCari = document.querySelector('input[placeholder="Cari..."]');

        fasilitasFilter.addEventListener('change', filterData);
        inputCari.addEventListener('input', filterData);

        function filterData() {
            const filterFasilitas = fasilitasFilter.value.toLowerCase();
            const keyword = inputCari.value.toLowerCase();

            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const fasilitas = row.children[1].textContent.toLowerCase();
                const rowText = row.textContent.toLowerCase();

                const matchFasilitas = !filterFasilitas || fasilitas.includes(filterFasilitas);
                const matchKeyword = rowText.includes(keyword);

                row.style.display = (matchFasilitas && matchKeyword) ? '' : 'none';
            });
        }

        // Modal Logic
        const modal = document.getElementById('detailModal');
        const openModalButtons = document.querySelectorAll('.open-modal');
        const modalActions = document.getElementById('modalActions');

        function closeModal() {
            modal.classList.add('hidden');
            modalActions.innerHTML = ''; // Clear actions when closing
        }

        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Populate modal fields
                document.querySelector('.user_id').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('.ruang').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('.fasilitas').textContent = button.getAttribute('data-fasilitas');
                document.querySelector('.deskripsi').textContent =
                    'No description'; // Replace with actual data if available
                document.querySelector('.tanggal').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('.status').textContent = button.getAttribute('data-status');
                document.querySelector('#detail-photo').src =
                    '/assets/image/placeholder.jpg'; // Replace with actual image if available
                document.querySelector('#statusBaru').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('#statusProses').textContent =
                    'Unknown'; // Replace with actual data if available
                document.querySelector('#statusSelesai').textContent = button.getAttribute(
                    'data-status') === 'Selesai dikerjakan' ? 'Completed' : '-';

                // Clear previous actions
                modalActions.innerHTML = '';

                // Add Selesai button if status is "Selesai dikerjakan"
                if (button.getAttribute('data-status') === 'Selesai dikerjakan') {
                    const selesaiButton = document.createElement('button');
                    selesaiButton.className =
                        'bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600';
                    selesaiButton.textContent = 'Selesai';
                    selesaiButton.addEventListener('click', () => {
                        alert(
                            'Laporan telah ditandai sebagai selesai!'); // Replace with actual logic
                    });
                    modalActions.appendChild(selesaiButton);
                }

                modal.classList.remove('hidden');
            });
        });

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
@endsection
