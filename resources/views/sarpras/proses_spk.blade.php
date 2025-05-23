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
        <!-- Matriks Keputusan -->
        <h3 class="text-lg font-semibold mb-2">Matriks Keputusan</h3>
        <div class="overflow-auto mb-4">
            <table class="w-full table-auto text-sm text-left border border-gray-200">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        @php
                            $headers = [
                                'No',
                                'Alternatif',
                                'C1 (Kerusakan)',
                                'C2 (Dampak)',
                                'C3 (Frekuensi)',
                                'C4 (Laporan)',
                                'C5 (Waktu Kerusakan)',
                                'C6 (Waktu Perbaikan)'
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
                    @php
                        $data = [
                            ['alternatif' => 'Meja dan Kursi', 'c1' => 5, 'c2' => 5, 'c3' => 3, 'c4' => 2, 'c5' => 4, 'c6' => 3],
                            ['alternatif' => 'Proyektor', 'c1' => 4, 'c2' => 4, 'c3' => 3, 'c4' => 3, 'c5' => 3, 'c6' => 3],
                            ['alternatif' => 'Stop Kontak', 'c1' => 4, 'c2' => 4, 'c3' => 4, 'c4' => 3, 'c5' => 3, 'c6' => 2],
                            ['alternatif' => 'AC', 'c1' => 4, 'c2' => 3, 'c3' => 4, 'c4' => 4, 'c5' => 2, 'c6' => 4],
                            ['alternatif' => 'Toilet', 'c1' => 3, 'c2' => 2, 'c3' => 5, 'c4' => 5, 'c5' => 5, 'c6' => 4],
                            ['alternatif' => 'Printer', 'c1' => 3, 'c2' => 3, 'c3' => 2, 'c4' => 2, 'c5' => 2, 'c6' => 3],
                            ['alternatif' => 'Scanner', 'c1' => 2, 'c2' => 2, 'c3' => 1, 'c4' => 1, 'c5' => 2, 'c6' => 2]
                        ];
                    @endphp
                    @foreach ($data as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3">{{ $item['alternatif'] }}</td>
                            <td class="p-3">{{ $item['c1'] }}</td>
                            <td class="p-3">{{ $item['c2'] }}</td>
                            <td class="p-3">{{ $item['c3'] }}</td>
                            <td class="p-3">{{ $item['c4'] }}</td>
                            <td class="p-3">{{ $item['c5'] }}</td>
                            <td class="p-3">{{ $item['c6'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Matriks Normalisasi -->
        <h3 class="text-lg font-semibold mb-2">Matriks Normalisasi</h3>
        <div class="overflow-auto mb-4">
            <table class="w-full table-auto text-sm text-left border border-gray-200">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
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
                    @php
                        // Menghitung nilai max untuk setiap kriteria (semua benefit)
                        $max_values = [
                            'c1' => max(array_column($data, 'c1')),
                            'c2' => max(array_column($data, 'c2')),
                            'c3' => max(array_column($data, 'c3')),
                            'c4' => max(array_column($data, 'c4')),
                            'c5' => max(array_column($data, 'c5')),
                            'c6' => max(array_column($data, 'c6'))
                        ];
                        // Normalisasi: nilai / max (untuk benefit)
                        $normalized_data = [];
                        foreach ($data as $item) {
                            $normalized_data[] = [
                                'alternatif' => $item['alternatif'],
                                'c1' => number_format($item['c1'] / $max_values['c1'], 2),
                                'c2' => number_format($item['c2'] / $max_values['c2'], 2),
                                'c3' => number_format($item['c3'] / $max_values['c3'], 2),
                                'c4' => number_format($item['c4'] / $max_values['c4'], 2),
                                'c5' => number_format($item['c5'] / $max_values['c5'], 2),
                                'c6' => number_format($item['c6'] / $max_values['c6'], 2)
                            ];
                        }
                    @endphp
                    @foreach ($normalized_data as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3">{{ $item['alternatif'] }}</td>
                            <td class="p-3">{{ $item['c1'] }}</td>
                            <td class="p-3">{{ $item['c2'] }}</td>
                            <td class="p-3">{{ $item['c3'] }}</td>
                            <td class="p-3">{{ $item['c4'] }}</td>
                            <td class="p-3">{{ $item['c5'] }}</td>
                            <td class="p-3">{{ $item['c6'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Nilai Max/Min per Kriteria -->
        <h3 class="text-lg font-semibold mb-2">Nilai Max/Min per Kriteria</h3>
        <div class="overflow-auto mb-4">
            <table class="w-full table-auto text-sm text-left border border-gray-200">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        <th class="p-3">Kriteria</th>
                        <th class="p-3">Nilai Maksimum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($max_values as $key => $value)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ strtoupper($key) }}</td>
                            <td class="p-3">{{ $value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Skor SAW dan Peringkat -->
        <h3 class="text-lg font-semibold mb-2">Skor SAW dan Peringkat</h3>
        <div class="overflow-auto">
            <table class="w-full table-auto text-sm text-left border border-gray-200">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        <th class="p-3">No</th>
                        <th class="p-3">Alternatif</th>
                        <th class="p-3">Skor SAW</th>
                        <th class="p-3">Peringkat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Bobot kriteria (contoh)
                        $weights = ['c1' => 0.3, 'c2' => 0.2, 'c3' => 0.2, 'c4' => 0.1, 'c5' => 0.1, 'c6' => 0.1];
                        // Hitung skor SAW
                        $saw_scores = [];
                        foreach ($normalized_data as $index => $item) {
                            $score = ($item['c1'] * $weights['c1']) +
                                     ($item['c2'] * $weights['c2']) +
                                     ($item['c3'] * $weights['c3']) +
                                     ($item['c4'] * $weights['c4']) +
                                     ($item['c5'] * $weights['c5']) +
                                     ($item['c6'] * $weights['c6']);
                            $saw_scores[] = [
                                'alternatif' => $item['alternatif'],
                                'score' => number_format($score, 3)
                            ];
                        }
                        // Urutkan berdasarkan skor (descending)
                        usort($saw_scores, function($a, $b) {
                            return $b['score'] <=> $a['score'];
                        });
                    @endphp
                    @foreach ($saw_scores as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3">{{ $item['alternatif'] }}</td>
                            <td class="p-3">{{ $item['score'] }}</td>
                            <td class="p-3">{{ $index + 1 }}</td>
                        </tr>
                    @endforeach
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
                    @foreach ($data as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3">{{ $item['alternatif'] }}</td>
                            <td class="p-3">{{ $item['c1'] }}</td>
                            <td class="p-3">{{ $item['c2'] }}</td>
                            <td class="p-3">{{ $item['c3'] }}</td>
                            <td class="p-3">{{ $item['c4'] }}</td>
                            <td class="p-3">{{ $item['c5'] }}</td>
                            <td class="p-3">{{ $item['c6'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('component.plagination')
</div>

<script>
// Tab handling
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

// Filter dan Pencarian
document.addEventListener('DOMContentLoaded', () => {
    showTab('saw');

    const filterAlternatif = document.getElementById('filterAlternatif');
    const searchInput = document.getElementById('searchInput');
    const tampilData = document.getElementById('tampilData');
    const sawTables = document.querySelectorAll('#content-saw tbody');
    const mooraTable = document.querySelector('#content-moora tbody');
    const originalRows = Array.from(sawTables[0].querySelectorAll('tr')); // Ambil dari tabel matriks keputusan

    function filterTable() {
        const alternatif = filterAlternatif.value.toLowerCase();
        const search = searchInput.value.toLowerCase();
        const rowsToShow = parseInt(tampilData.value);

        const filteredRows = originalRows.filter((row, index) => {
            const alternatifText = row.cells[1].textContent.toLowerCase();
            const matchesAlternatif = !alternatif || alternatifText === alternatif;
            const matchesSearch = alternatifText.includes(search);
            return matchesAlternatif && matchesSearch;
        });

        // Update tabel MOORA
        mooraTable.innerHTML = '';
        filteredRows.slice(0, rowsToShow).forEach(row => mooraTable.appendChild(row.cloneNode(true)));

        // Update semua tabel SAW (Matriks Keputusan, Normalisasi, Skor)
        sawTables.forEach((table, index) => {
            table.innerHTML = '';
            if (index < 2) { // Matriks Keputusan dan Normalisasi
                filteredRows.slice(0, rowsToShow).forEach(row => table.appendChild(row.cloneNode(true)));
            } else { // Tabel Skor SAW
                // Urutkan ulang skor berdasarkan filteredRows
                const filteredAlternatifs = filteredRows.map(row => row.cells[1].textContent);
                const sawScoreTable = Array.from(table.querySelectorAll('tr')).filter(row =>
                    filteredAlternatifs.includes(row.cells[1].textContent)
                );
                sawScoreTable.slice(0, rowsToShow).forEach((row, i) => {
                    row.cells[0].textContent = i + 1; // Update nomor
                    row.cells[3].textContent = i + 1; // Update peringkat
                    table.appendChild(row);
                });
            }
        });
    }

    filterAlternatif.addEventListener('change', filterTable);
    searchInput.addEventListener('keyup', filterTable);
    tampilData.addEventListener('change', filterTable);
});
</script>
@endsection
