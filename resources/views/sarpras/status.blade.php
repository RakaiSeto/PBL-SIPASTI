@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between mb-3 mt-1 items-center gap-4 flex-wrap">

        <!-- Filter Fasilitas -->
        <div class="flex items-center gap-2 whitespace-nowrap">
            <label for="filterFasilitas" class="text-sm text-slate-700">Fasilitas</label>
            <select id="filterFasilitas" class="border border-slate-300 rounded px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua</option>
                <option value="AC">AC</option>
                <option value="Proyektor">Proyektor</option>
                <option value="Kipas Angin">Kipas Angin</option>
                <option value="Lampu">Lampu</option>
            </select>

            <input
                class="w-full sm:max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
                placeholder="Cari..."
            />
        </div>

        <!-- Dropdown Tampilkan data -->
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
                        $headers = ['ID', 'Fasilitas', 'Teknisi', 'Status'];
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
                            Sedang Dikerjakan
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">2</td>
                    <td class="p-3">Kipas Angin</td>
                    <td class="p-3">Andi</td>
                    <td class="p-3">
                        <span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">
                            Selesai
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">3</td>
                    <td class="p-3">Lampu</td>
                    <td class="p-3">Sari</td>
                    <td class="p-3">
                        <span class="bg-yellow-500/20 text-yellow-900 text-xs px-2 py-1 rounded uppercase font-bold">
                            Sedang Dikerjakan
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @include('component.plagination')
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
</script>
@endsection
