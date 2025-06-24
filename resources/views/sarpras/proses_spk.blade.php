@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 rounded shadow">
        <!-- Tab Menu -->
        <div class="flex border-b border-slate-300 mb-4">
            <button id="tab-saw"
                class="px-4 py-2 -mb-px border-b-2 border-transparent text-slate-500 hover:text-primary hover:border-primary transition-colors duration-200"
                onclick="showTab('saw')">SAW</button>
            <button id="tab-moora"
                class="px-4 py-2 -mb-px border-b-2 border-transparent text-slate-500 hover:text-primary hover:border-primary transition-colors duration-200"
                onclick="showTab('moora')">MOORA</button>
        </div>

        <!-- Tab SAW -->
        <div id="content-saw" class="">
            <!-- Matriks Keputusan -->
            <h3 class="text-lg font-semibold mb-2">Alternatif</h3>
            <div class="overflow-auto mb-4">
                <table class="w-full table-auto text-sm text-left border border-gray-200">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                            <th class="p-2">No</th>
                            <th class="p-2">Alternatif</th>
                            <th class="p-2">C1 (Kerusakan)</th>
                            <th class="p-2">C2 (Dampak)</th>
                            <th class="p-2">C3 (Frekuensi)</th>
                            <th class="p-2">C4 (Laporan)</th>
                            <th class="p-2">C5 (Waktu Kerusakan)</th>
                            <th class="p-2">C6 (Waktu Perbaikan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saw['alternatif'] as $key => $value)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $key }}</td>
                                <td class="p-3">{{ $value['name'] }}</td>
                                <td class="p-3">{{ $value['values'][0] }}</td>
                                <td class="p-3">{{ $value['values'][1] }}</td>
                                <td class="p-3">{{ $value['values'][2] }}</td>
                                <td class="p-3">{{ $value['values'][3] }}</td>
                                <td class="p-3">{{ $value['values'][4] }}</td>
                                <td class="p-3">{{ $value['values'][5] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Matriks Normalisasi -->
            <h3 class="text-lg font-semibold mb-2">Max/Min per Kriteria</h3>
            <div class="overflow-auto mb-4">
                <table class="w-full table-auto text-sm text-left border border-gray-200">
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        <th class="p-2">Kriteria</th>
                        <th class="p-2">Tipe</th>
                        <th class="p-2">Nilai Maksimum</th>
                        <th class="p-2">Nilai Minimum</th>
                    </tr>
                    </j>
                    <tbody>
                        @foreach ($saw['maxMin'] as $key => $value)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $value['name'] }}</td>
                                <td class="p-3">{{ $saw['criteria'][$key]['type'] }}</td>
                                <td class="p-3">{{ $value['max'] }}</td>
                                <td class="p-3">{{ $value['min'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Nilai Max/Min per Kriteria -->
            <h3 class="text-lg font-semibold mb-2">Normalisasi</h3>
            <div class="overflow-auto mb-4">
                <table class="w-full table-auto text-sm text-left border border-gray-200">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                            <th class="p-2">No</th>
                            <th class="p-2">Alternatif</th>
                            <th class="p-2">C1 (Kerusakan)</th>
                            <th class="p-2">C2 (Dampak)</th>
                            <th class="p-2">C3 (Frekuensi)</th>
                            <th class="p-2">C4 (Laporan)</th>
                            <th class="p-2">C5 (Waktu Kerusakan)</th>
                            <th class="p-2">C6 (Waktu Perbaikan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saw['normalisasi'] as $key => $value)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $key }}</td>
                                <td class="p-3">{{ $value['name'] }}</td>
                                <td class="p-3">{{ $value['values'][0] }}</td>
                                <td class="p-3">{{ $value['values'][1] }}</td>
                                <td class="p-3">{{ $value['values'][2] }}</td>
                                <td class="p-3">{{ $value['values'][3] }}</td>
                                <td class="p-3">{{ $value['values'][4] }}</td>
                                <td class="p-3">{{ $value['values'][5] }}</td>
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
                            <th class="p-2">Peringkat</th>
                            <th class="p-2">Alternatif</th>
                            <th class="p-2">Skor SAW</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saw['rank'] as $key => $value)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $key + 1 }}</td>
                                <td class="p-3">{{ $value['name'] }}</td>
                                <td class="p-3">{{ $value['value'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab MOORA -->
        <div id="content-moora" class="hidden">
            <h3 class="text-lg font-semibold mb-2">Alternatif</h3>
            <div class="overflow-auto mb-4">
                <table class="w-full table-auto text-sm text-left border border-gray-200">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                            <th class="p-2">No</th>
                            <th class="p-2">Alternatif</th>
                            <th class="p-2">C1 (Kerusakan)</th>
                            <th class="p-2">C2 (Dampak)</th>
                            <th class="p-2">C3 (Frekuensi)</th>
                            <th class="p-2">C4 (Laporan)</th>
                            <th class="p-2">C5 (Waktu Kerusakan)</th>
                            <th class="p-2">C6 (Waktu Perbaikan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($moora['alternatif'] as $key => $value)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $key }}</td>
                                <td class="p-3">{{ $value['name'] }}</td>
                                <td class="p-3">{{ $value['values'][0] }}</td>
                                <td class="p-3">{{ $value['values'][1] }}</td>
                                <td class="p-3">{{ $value['values'][2] }}</td>
                                <td class="p-3">{{ $value['values'][3] }}</td>
                                <td class="p-3">{{ $value['values'][4] }}</td>
                                <td class="p-3">{{ $value['values'][5] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3 class="text-lg font-semibold mb-2">Nilai Pangkat per Kriteria</h3>
            <div class="overflow-auto mb-4">
                <table class="w-full table-auto text-sm text-left border border-gray-200">
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        <th class="p-2">Kriteria</th>
                        <th class="p-2">Tipe</th>
                        <th class="p-2">Nilai</th>
                    </tr>
                    </j>
                    <tbody>
                        @foreach ($moora['sqrt'] as $key => $value)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $moora['criteria'][$key]['name'] }}</td>
                                <td class="p-3">{{ $moora['criteria'][$key]['type'] }}</td>
                                <td class="p-3">{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3 class="text-lg font-semibold mb-2">Normalisasi</h3>
            <div class="overflow-auto mb-4">
                <table class="w-full table-auto text-sm text-left border border-gray-200">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                            <th class="p-2">No</th>
                            <th class="p-2">Alternatif</th>
                            <th class="p-2">C1 (Kerusakan)</th>
                            <th class="p-2">C2 (Dampak)</th>
                            <th class="p-2">C3 (Frekuensi)</th>
                            <th class="p-2">C4 (Laporan)</th>
                            <th class="p-2">C5 (Waktu Kerusakan)</th>
                            <th class="p-2">C6 (Waktu Perbaikan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($moora['normalisasi'] as $key => $value)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $key }}</td>
                                <td class="p-3">{{ $value['name'] }}</td>
                                <td class="p-3">{{ $value['values'][0] }}</td>
                                <td class="p-3">{{ $value['values'][1] }}</td>
                                <td class="p-3">{{ $value['values'][2] }}</td>
                                <td class="p-3">{{ $value['values'][3] }}</td>
                                <td class="p-3">{{ $value['values'][4] }}</td>
                                <td class="p-3">{{ $value['values'][5] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Skor MOORA dan Peringkat -->
            <h3 class="text-lg font-semibold mb-2">Skor MOORA dan Peringkat</h3>
            <div class="overflow-auto">
                <table class="w-full table-auto text-sm text-left border border-gray-200">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                            <th class="p-2">Peringkat</th>
                            <th class="p-2">Alternatif</th>
                            <th class="p-2">Skor MOORA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($moora['rank'] as $key => $value)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $key + 1 }}</td>
                                <td class="p-3">{{ $value['name'] }}</td>
                                <td class="p-3">{{ $value['value'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
        });
    </script>
@endsection