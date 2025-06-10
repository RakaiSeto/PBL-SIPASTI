@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <!-- Tab Menu -->
        <div class="flex border-b border-slate-300 mb-6">
            <button id="tab-saw"
                class="px-6 py-3 -mb-px border-b-2 border-transparent text-slate-600 font-semibold hover:text-[#1652b7] hover:border-[#1652b7] transition-colors duration-300"
                onclick="showTab('saw')">SAW</button>
            <button id="tab-moora"
                class="px-6 py-3 -mb-px border-b-2 border-transparent text-slate-600 font-semibold hover:text-[#1652b7] hover:border-[#1652b7] transition-colors duration-300"
                onclick="showTab('moora')">MOORA</button>
        </div>


        <!-- Tab SAW -->
        <div id="content-saw" class="">
            <div id="saw-cards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card akan di-render oleh JavaScript -->
            </div>
        </div>

        <!-- Tab MOORA -->
        <div id="content-moora" class="hidden">
            <div id="moora-cards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            </div>
        </div>
    </div>

    <!-- Modal Teknisi -->
    <div id="modal-teknisi" class="fixed inset-0 bg-black/60 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-slate-800">Pilih Teknisi</h2>
            <select id="teknisi-select-modal"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-[#1652b7]">
                <option value="">-- Pilih Teknisi --</option>
                <option value="1">Teknisi A</option>
                <option value="2">Teknisi B</option>
                <option value="3">Teknisi C</option>
            </select>
            <div class="flex justify-end gap-3">
                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors"
                    onclick="closeModal()">Batal</button>
                <button class="bg-[#1652b7] text-white px-4 py-2 rounded-lg hover:bg-[#123d8f] transition-colors"
                    onclick="kirimTeknisi()">Kirim</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            showTab('saw');
            loadCards('saw');
            loadCards('moora');

            // Event listener untuk filter dan pencarian
            $('#filterFasilitas, #tampilData, #searchInput').on('change keyup', function() {
                loadCards('saw');
                loadCards('moora');
            });
        });

        function showTab(tab) {
            const sawTabBtn = document.getElementById('tab-saw');
            const mooraTabBtn = document.getElementById('tab-moora');
            const sawContent = document.getElementById('content-saw');
            const mooraContent = document.getElementById('content-moora');

            if (tab === 'saw') {
                sawContent.classList.remove('hidden');
                mooraContent.classList.add('hidden');
                sawTabBtn.classList.add('border-[#1652b7]', 'text-[#1652b7]');
                sawTabBtn.classList.remove('border-transparent', 'text-slate-600');
                mooraTabBtn.classList.remove('border-[#1652b7]', 'text-[#1652b7]');
                mooraTabBtn.classList.add('border-transparent', 'text-slate-600');
            } else {
                mooraContent.classList.remove('hidden');
                sawContent.classList.add('hidden');
                mooraTabBtn.classList.add('border-[#1652b7]', 'text-[#1652b7]');
                mooraTabBtn.classList.remove('border-transparent', 'text-slate-600');
                sawTabBtn.classList.remove('border-[#1652b7]', 'text-[#1652b7]');
                sawTabBtn.classList.add('border-transparent', 'text-slate-600');
            }
        }

        function loadCards(type) {
            const container = $(`#${type}-cards`);
            const filterFasilitas = $('#filterFasilitas').val();
            const pageLength = $('#tampilData').val();
            const searchQuery = $('#searchInput').val();

            $.ajax({
                url: `/api/${type}`,
                data: {
                    fasilitas: filterFasilitas,
                    length: pageLength,
                    search: searchQuery
                },
                success: function(response) {
                    container.empty();
                    const rankData = response.rank || [];
                    rankData.forEach((item, index) => {
                        const rank = index + 1;
                        const cardClass = rank === 1 ? 'border-[#1652b7] bg-[#e6edf8]' :
                            'border-gray-200';
                        const card = `
                            <div class="relative bg-white border ${cardClass} rounded-lg shadow-md p-5 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-start gap-3">
                                    <button class="bg-[#1652b7] text-white p-2 rounded-full hover:bg-[#123d8f] transition-colors"
                                        onclick="openModal('${item.id || ''}')" title="Tugaskan Teknisi">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </button>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-3">
                                            <h3 class="text-lg font-semibold text-slate-800">${item.name || 'Unknown'}</h3>
                                            <span class="text-sm font-bold text-[#1652b7] bg-[#e6edf8] px-2 py-1 rounded-full">Rank ${rank}</span>
                                        </div>
                                        <p class="text-sm text-slate-600 mb-4"><strong>Ruang-Fasilitas:</strong> ${item.room || 'Tidak diketahui'}</p>
                                        <button class="toggle-details bg-gray-200 text-gray-700 font-semibold py-1 px-3 rounded-lg hover:bg-gray-300 transition-colors w-full"
                                            onclick="toggleDetails(this, '${item.id}')">
                                            Lihat Detail
                                        </button>
                                        <div class="details hidden mt-4 text-sm border-t border-gray-200 pt-3">
                                            <div class="grid grid-cols-2 gap-3">
                                                <p><strong>C1 (Kerusakan):</strong> ${item.alternatif && Array.isArray(item.alternatif) ? item.alternatif[0] : '-'}</p>
                                                <p><strong>C2 (Dampak):</strong> ${item.alternatif && Array.isArray(item.alternatif) ? item.alternatif[1] : '-'}</p>
                                                <p><strong>C3 (Frekuensi):</strong> ${item.alternatif && Array.isArray(item.alternatif) ? item.alternatif[2] : '-'}</p>
                                                <p><strong>C4 (Laporan):</strong> ${item.alternatif && Array.isArray(item.alternatif) ? item.alternatif[3] : '-'}</p>
                                                <p><strong>C5 (Waktu Kerusakan):</strong> ${item.alternatif && Array.isArray(item.alternatif) ? item.alternatif[4] : '-'}</p>
                                                <p><strong>C6 (Waktu Perbaikan):</strong> ${item.alternatif && Array.isArray(item.alternatif) ? item.alternatif[5] : '-'}</p>
                                            </div>
                                            <p class="mt-3 font-semibold"><strong>Skor DSS:</strong> ${item.value ? item.value.toFixed(3) : '-'}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.append(card);
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data. Silakan coba lagi.'
                    });
                }
            });
        }

        function toggleDetails(button, itemId) {
            const details = button.nextElementSibling;
            const isHidden = details.classList.contains('hidden');
            details.classList.toggle('hidden');
            button.textContent = isHidden ? 'Sembunyikan Detail' : 'Lihat Detail';
        }

        let currentItemId = null;

        function openModal(itemId) {
            currentItemId = itemId;
            document.getElementById("modal-teknisi").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("modal-teknisi").classList.add("hidden");
            currentItemId = null;
        }

        function kirimTeknisi() {
            const teknisiId = document.getElementById("teknisi-select-modal").value;

            if (!teknisiId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih teknisi terlebih dahulu.'
                });
                return;
            }

            // Simulasi pengiriman data ke backend
            console.log("Menugaskan teknisi ID:", teknisiId, "untuk item ID:", currentItemId);
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: 'Berhasil menugaskan teknisi!'
            });

            closeModal();
        }
    </script>

    <style>
        /* Styling tambahan untuk card */
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .sm\:grid-cols-2 {
            @media (min-width: 640px) {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .lg\:grid-cols-3 {
            @media (min-width: 1024px) {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .details {
            transition: all 0.3s ease;
        }

        .bg-[#1652b7] {
            background-color: #1652b7;
        }

        .text-[#1652b7] {
            color: #1652b7;
        }

        .border-[#1652b7] {
            border-color: #1652b7;
        }

        .focus\:ring-[#1652b7] {
            --tw-ring-color: #1652b7;
        }

        .bg-[#e6edf8] {
            background-color: #e6edf8;
        }

        .hover\:bg-[#123d8f]:hover {
            background-color: #123d8f;
        }
    </style>
@endsection
