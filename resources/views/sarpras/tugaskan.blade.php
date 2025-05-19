@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <!-- Tab Menu -->
    <div class="flex border-b border-slate-300 mb-4">
        <button id="tab-saw" class="px-4 py-2 -mb-px border-b-2 border-primary text-primary font-bold font-primary transition-colors duration-200" onclick="showTab('saw')">SAW</button>
        <button id="tab-moora" class="px-4 py-2 -mb-px border-b-2 border-transparent text-slate-500 hover:text-primary hover:border-primary transition-colors duration-200" onclick="showTab('moora')">MOORA</button>
    </div>

    <!-- Tab SAW -->
    <div id="content-saw" class="">
        <div class="overflow-auto">
            <table class="w-full table-auto text-sm text-left border border-gray-200">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        <th class="p-3">No</th>
                        <th class="p-3">Ruang</th>
                        <th class="p-3">Fasilitas</th>
                        <th class="p-3">Skor DSS - Keterangan</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">1</td>
                        <td class="p-3">RT003</td>
                        <td class="p-3">AC</td>
                        <td class="p-3">
                            <span class="bg-red-500/20 text-red-900 text-xs px-2 py-1 rounded uppercase font-bold">
                                0.80 - Prioritas Tinggi
                            </span>
                        </td>
                        <td class="p-3">
                            <button class="bg-primary text-white px-3 py-1 rounded text-sm hover:bg-blue-700" onclick="openModal(1)">Tugaskan</button>
                        </td>
                    </tr>
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
                        <th class="p-3">No</th>
                        <th class="p-3">Ruang</th>
                        <th class="p-3">Fasilitas</th>
                        <th class="p-3">Skor DSS - Keterangan</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">1</td>
                        <td class="p-3">RT005</td>
                        <td class="p-3">AC</td>
                        <td class="p-3">
                            <span class="bg-yellow-400/20 text-yellow-800 text-xs px-2 py-1 rounded uppercase font-bold">
                                0.65 - Prioritas Sedang
                            </span>
                        </td>
                        <td class="p-3">
                            <button class="bg-primary text-white px-3 py-1 rounded text-sm hover:bg-blue-700" onclick="openModal(1)">Tugaskan</button>
                        </td>
                    </tr>
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

        if (tab === 'saw') {
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

    document.addEventListener('DOMContentLoaded', () => {
        showTab('saw');
    });

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
            alert("Silakan pilih teknisi terlebih dahulu.");
            return;
        }

        console.log("Menugaskan teknisi ID:", teknisiId, "untuk item ID:", currentItemId);
        closeModal();
    }
</script>
@endsection
