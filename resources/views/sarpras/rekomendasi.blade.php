@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    {{-- <h1 class="text-xl font-bold mb-4">Laporan Terverifikasi</h1> --}}

    <!-- Tab Menu -->
   <div class="flex border-b border-slate-300 mb-4"><button id="tab-saw" class="px-4 py-2 -mb-px border-b-2 border-primary text-primary font-bold font-primary transition-colors duration-200" onclick="showTab('saw')">SAW</button>
    <button id="tab-moora" class="px-4 py-2 -mb-px border-b-2 border-transparent text-slate-500 hover:text-primary hover:border-primary transition-colors duration-200" onclick="showTab('moora')">MOORA</button>
</div>



    <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">

    <!-- Filter Berdasarkan Fasilitas -->
<div class="flex items-center gap-2 whitespace-nowrap">
    <label for="filterFasilitas" class="text-sm text-slate-700">Fasilitas</label>
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
        <label for="tampilData" class="text-sm text-slate-700">Tampilkan</label>
        <select id="tampilData" class="border border-slate-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>

   </div>

    <!-- Tab SAW -->
    <div id="content-saw" class="">
        <div class="overflow-auto">
            <table class="w-full table-auto text-sm text-left border border-gray-200">
                <thead>
    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
        @php
            $headers = [
                'No',
                'Ruang',
                'Fasilitas',
                'C1 (Kerusakan)',
                'C2 (Dampak)',
                'C3 (Frekuensi)',
                'C4 (Laporan)',
                'Biaya Perbaikan',
                'C6 (Waktu Perbaikan)',
                'Skor DSS - Keterangan',
                'Aksi'
            ];
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
                    <!-- Contoh data -->
                     <tr class="border-b hover:bg-gray-50">
        <td class="p-3">1</td>
        <td class="p-3">RT001</td>
        <td class="p-3">AC</td>
        <td class="p-3">Sedang</td> <!-- C1 -->
        <td class="p-3">Tinggi</td> <!-- C2 -->
        <td class="p-3">Sering</td> <!-- C3 -->
        <td class="p-3">Baik</td> <!-- C4 -->
        <td class="p-3">Rp 1.000.000</td>
        <td class="p-3">3-5 hari</td>
        <td class="p-3">
            <span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded uppercase font-bold">
    0.80 - Prioritas Tinggi
</span>
        </td>
        <td class="p-3">
    <button class="bg-primary text-white px-3 py-1 rounded text-sm hover:bg-blue-700"
            onclick="openModal(1)">
        Tugaskan
    </button>
</td>

    </tr>
                    <!-- Tambahkan data sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab MOORA -->
    <div id="content-moora" class="hidden">
        <div class="overflow-auto">
            <table class="w-full table-auto text-sm text-left border border-gray-200">
                <thead>
    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
        @php
            $headers = [
                'No',
                'Ruang',
                'Fasilitas',
                'C1 (Kerusakan)',
                'C2 (Dampak)',
                'C3 (Frekuensi)',
                'C4 (Laporan)',
                'Biaya Perbaikan',
                'C6 (Waktu Perbaikan)',
                'Skor DSS - Keterangan',
                'Aksi'
            ];
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
                    <!-- Contoh data -->
                     <tr class="border-b hover:bg-gray-50">
        <td class="p-3">1</td>
        <td class="p-3">RT001</td>
        <td class="p-3">AC</td>
        <td class="p-3">Sedang</td> <!-- C1 -->
        <td class="p-3">Tinggi</td> <!-- C2 -->
        <td class="p-3">Sering</td> <!-- C3 -->
        <td class="p-3">Baik</td> <!-- C4 -->
        <td class="p-3">Rp 1.000.000</td>
        <td class="p-3">3-5 hari</td>
        <td class="p-3">
            <span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded uppercase font-bold">
    0.80 - Prioritas rendah
</span>
        </td>
        <td class="p-3">
    <button class="bg-primary text-white px-3 py-1 rounded text-sm hover:bg-blue-700"
            onclick="openModal(1)">
        Tugaskan
    </button>
</td>

    </tr>
                    <!-- Tambahkan data sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
    </div>
        @include('component.plagination')

</div>

<!-- Modal -->
<div id="modal-teknisi" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Pilih Teknisi</h2>
        <select id="teknisi-select-modal" class="w-full border border-gray-300 rounded px-3 py-2 mb-4">
            <option value="">-- Pilih Teknisi --</option>
            <option value="1">Teknisi A</option>
            <option value="2">Teknisi B</option>
            <option value="3">Teknisi C</option>
        </select>
        <div class="flex justify-end gap-2">
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400" onclick="closeModal()">Batal</button>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="kirimTeknisi()">Kirim</button>
        </div>
    </div>
</div>


<script>
    function showTab(tab) {
        const sawTabBtn = document.getElementById('tab-saw');
        const mooraTabBtn = document.getElementById('tab-moora');
        const sawContent = document.getElementById('content-saw');
        const mooraContent = document.getElementById('content-moora');

        if(tab === 'saw') {
            sawContent.classList.remove('hidden');
            mooraContent.classList.add('hidden');
            sawTabBtn.classList.add('border-blue-600', 'text-blue-600');
            sawTabBtn.classList.remove('border-transparent', 'text-gray-600');
            mooraTabBtn.classList.remove('border-blue-600', 'text-blue-600');
            mooraTabBtn.classList.add('border-transparent', 'text-gray-600');
        } else {
            mooraContent.classList.remove('hidden');
            sawContent.classList.add('hidden');
            mooraTabBtn.classList.add('border-blue-600', 'text-blue-600');
            mooraTabBtn.classList.remove('border-transparent', 'text-gray-600');
            sawTabBtn.classList.remove('border-blue-600', 'text-blue-600');
            sawTabBtn.classList.add('border-transparent', 'text-gray-600');
        }
    }

    function tugaskanTeknisi(id) {
        let selectId = `teknisi-select-${id}`;
        let select = document.getElementById(selectId);
        if (!select) {
            alert('Dropdown teknisi tidak ditemukan.');
            return;
        }
        const teknisi = select.value;
        if(!teknisi) {
            alert('Silakan pilih teknisi terlebih dahulu.');
            return;
        }

        alert('Berhasil menugaskan teknisi');
        // TODO: Kirim data ke backend via AJAX atau submit form
        // Setelah itu bisa reset pilihan dropdown:
        select.value = '';
    }

    // Inisialisasi tab SAW saat load halaman
    document.addEventListener('DOMContentLoaded', () => {
        showTab('saw');
    });


    //nu
     let currentItemId = null;

    function openModal(itemId) {
        currentItemId = itemId; // simpan ID yang sedang diproses (misalnya ID pelaporan)
        document.getElementById("modal-teknisi").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("modal-teknisi").classList.add("hidden");
        currentItemId = null;
    }

    function kirimTeknisi() {
        const teknisiId = document.getElementById("teknisi-select-modal").value;

        if (!teknisiId) {
            alert("Silakan pilih teknisi terlebih dahulu.");
            return;
        }

        // Kirim data ke backend di sini, contoh (simulasi):
        console.log("Menugaskan teknisi ID:", teknisiId, "untuk item ID:", currentItemId);

        // Setelah sukses, tutup modal
        closeModal();
    }

</script>
@endsection
