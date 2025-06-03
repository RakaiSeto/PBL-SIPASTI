@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- <div class="p-4"> --}}
    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <!-- Card 1 -->
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Laporan total</h3>
                    <p class="text-lg font-bold">{{ $totalLaporan }}</p>
                </div>
                <div class="bg-primary text-white w-10 h-10 flex items-center justify-center rounded-full">
                    <i class="fas fa-clipboard-list text-white"></i>
                </div>

            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Laporan diproses</h3>
                    <p class="text-lg font-bold">{{ $laporanDiproses }}</p>
                </div>
                <div class="bg-primary text-white w-10 h-10 flex items-center justify-center rounded-full">
                    <i class="fas fa-spinner text-white"></i>
                </div>

            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Laporan Selesai</h3>
                    <p class="text-lg font-bold">{{ $laporanSelesai }}</p>
                </div>
                <div class="bg-primary text-white w-10 h-10 flex items-center justify-center rounded-full">
                    <i class="fas fa-check-circle text-white"></i>
                </div>

            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Laporan Ditolak</h3>
                    <p class="text-lg font-bold">{{ $laporanDitolak }}</p>
                </div>
                <div class="bg-primary text-white w-10 h-10 flex items-center justify-center rounded-full">
                    <i class="fas fa-times-circle text-white"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">


        <!-- Card -->
        <!-- Line Chart - Lebar 2/3 -->
        <div
            class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 rounded shadow lg:col-span-2 dark:bg-neutral-800 dark:border-neutral-700">
            <!-- Header -->
            <div class="flex flex-wrap justify-between items-center gap-2">
                <div class="mb-4">
                    <h2 class="text-sm text-gray-500 dark:text-neutral-500">Jumlah Laporan Perhari</h2>
                </div>
            </div>
            <!-- End Header -->
            <div id="hs-single-area-chart" class="relative w-full h-[300px] sm:h-[350px] md:h-[400px] lg:h-[420px]"></div>

            {{-- <div id="hs-single-area-chart"></div> --}}
        </div>

        <!-- Donut Chart - Lebar 1/3 -->
        <div
            class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 rounded shadow dark:bg-neutral-800 dark:border-neutral-700">
            <!-- Header -->
            <div class="flex flex-wrap justify-between items-center gap-2">
                <div class="mb-4">
                    <h2 class="text-sm text-gray-500 dark:text-neutral-500">Persentase Status Laporan</h2>
                </div>
            </div>
            <!-- End Header -->
            {{-- <div id="hs-doughnut-chart"></div> --}}
            <div id="hs-doughnut-chart" class="relative w-full h-[300px] sm:h-[350px] md:h-[400px] lg:h-[420px]"></div>

        </div>

    </div>

    <!-- Tabel Laporan Terbaru -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table id="laporanTable" class="w-full table-auto text-sm text-left">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                        <th class="p-3">No</th>
                        <th class="p-3">Ruang</th>
                        <th class="p-3">Fasilitas</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>



    <!--  -->
    </div>

    <script>
        // Multiple Bar Chart (Income)


        // Area Chart (Visitors)
        const visitorCtx = document.createElement("canvas");
        visitorCtx.style.width = "100%";
        visitorCtx.style.height = "100%";
        document.getElementById("hs-single-area-chart").appendChild(visitorCtx);

        new Chart(visitorCtx, {
            type: "line",
            data: {
                labels: {!! json_encode($labelsLine) !!}, // Ambil dari controller
                datasets: [{
                    label: "Jumlah Laporan",
                    data: {!! json_encode($dataLine) !!}, // Ambil dari controller
                    fill: true,
                    backgroundColor: "rgba(22, 82, 183, 0.1)",
                    borderColor: "#1652B7",
                    tension: 0.4,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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



        // Donut Chart
        const donutCtx = document.createElement("canvas");
        donutCtx.style.width = "100%";
        donutCtx.style.height = "100%";
        document.getElementById("hs-doughnut-chart").appendChild(donutCtx);

        new Chart(donutCtx, {
            type: "doughnut",
            data: {
                labels: {!! json_encode(array_keys($dataDoughnut)) !!}, // ['Menunggu', 'Diproses', 'Selesai', 'Ditolak']
                datasets: [{
                    data: {!! json_encode(array_values($dataDoughnut)) !!}, // [nilai-nilai persentase]
                    backgroundColor: [
                        '#3B82F6', '#1E3A8A', '#60A5FA', '#BFDBFE'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: "#6B7280", // Warna teks legend
                        }
                    }
                }
            }
        });
    </script>
@endsection
