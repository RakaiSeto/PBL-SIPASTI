@extends('layouts.app')
@section('content')
    {{-- <div class="p-4"> --}}
    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
        <!-- Card 1 -->
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Total Fasilitas</h3>
                    <p class="text-lg font-bold">{{ $totalFasilitas }}</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m1-9h4m-1-6h-2" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Total Laporan</h3>
                    <p class="text-lg font-bold">{{ $totalLaporan }}</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a4 4 0 114 0v2m4 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Total Laporan Selesai</h3>
                    <p class="text-lg font-bold">{{ $totalLaporanSelesai }}</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-1.414 1.414a8 8 0 11-11.314 0L4.636 5.636a10 10 0 1014.728 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-2 sm:gap-4 mb-4">
        <!-- Card -->
        <div
            class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 rounded shadow dark:bg-neutral-800 dark:border-neutral-700">
            <!-- Header -->
            <div class="flex flex-wrap justify-between items-center gap-2">
                <div class="mb-4">
                    <h2 class="text-sm text-gray-500 dark:text-neutral-500">Rasio Progress Laporan</h2>
                </div>
            </div>
            <!-- End Header -->

            <div id="hs-multiple-bar-charts"></div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div
            class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 rounded shadow dark:bg-neutral-800 dark:border-neutral-700">
            <!-- Header -->
            <div class="flex flex-wrap justify-between items-center gap-2">
                <div class="mb-4">
                    <h2 class="text-sm text-gray-500 dark:text-neutral-500">Statistik Pelaporan</h2>
                </div>
            </div>
            <!-- End Header -->

            <div id="hs-single-area-chart"></div>
        </div>
        <!-- End Card -->
    </div>
    <div class="bg-white p-4 rounded shadow mb-4">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Laporan Terbaru</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700 font-medium">
                    <tr>
                        <th class="px-4 py-2 text-left  text-gray-600">No</th>
                        <th class="px-4 py-2 text-left  text-gray-600">Ruang</th>
                        <th class="px-4 py-2 text-left  text-gray-600">Fasilitas</th>
                        <th class="px-4 py-2 text-left  text-gray-600">Tanggal Lapor</th>
                        <th class="px-4 py-2 text-left  text-gray-600">Status</th>
                        <th class="px-4 py-2 text-left  text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($laporanTerbaru as $index => $lapor)
                        <tr>
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $lapor->ruangan->ruangan_nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $lapor->fasilitas->fasilitas_nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($lapor->lapor_datetime)->format('d M Y - H:i') }}
                            </td>
                            <td class="px-4 py-2">
                                <span
                                    class="inline-block px-2 py-1 rounded text-xs font-semibold
    {{ $lapor->is_done ? 'bg-green-500 text-white' : 'bg-blue-500/20 text-blue-900' }}">
                                    {{ $lapor->is_done ? 'Selesai' : 'Diproses' }}
                                </span>
                            </td>
                            <td>
                                <button onclick="openDetail(${data.laporan_id})" title="Detail"
                                    class="flex items-center gap-1 px-3 py-1 text-white bg-primary hover:bg-blue-700 rounded">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!--  -->
    </div>

    <script>
        // Multiple Bar Chart (Income)
        const incomeCtx = document.createElement("canvas");
        document.getElementById("hs-multiple-bar-charts").appendChild(incomeCtx);

        new Chart(incomeCtx, {
            type: "bar",
            data: {
                labels: [
                    @foreach ($bulanLaporan as $item)
                        "{{ $item }}",
                    @endforeach
                ],
                datasets: [{
                        label: "Jumlah Laporan",
                        data: [
                            @foreach ($jumlahLaporan as $item)
                                {{ $item }},
                            @endforeach
                        ],
                        backgroundColor: "#1652B7",
                        borderRadius: 5,
                    },
                    {
                        label: "Jumlah Laporan Selesai",
                        data: [
                            @foreach ($jumlahLaporanSelesai as $item)
                                {{ $item }},
                            @endforeach
                        ],
                        backgroundColor: "#ea8a14",
                        borderRadius: 5,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        // Area Chart (Visitors)
        const visitorCtx = document.createElement("canvas");
        document.getElementById("hs-single-area-chart").appendChild(visitorCtx);

        new Chart(visitorCtx, {
            type: "line",
            data: {
                labels: [
                    @foreach ($hariLaporan as $item)
                        "{{ $item }}",
                    @endforeach
                ],
                datasets: [{
                    label: "Jumlah Laporan Harian",
                    data: [
                        @foreach ($jumlahLaporanMingguan as $item)
                            {{ $item }},
                        @endforeach
                    ],
                    fill: true,
                    backgroundColor: "rgba(22, 82, 183, 0.1)",
                    borderColor: "#1652B7",
                    tension: 0.4,
                }, ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
@endsection
