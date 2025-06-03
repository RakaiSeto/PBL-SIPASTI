@extends('layouts.app')

@section('content')
<!-- Container filter+download -->
<div class="flex items-center justify-between py-4 px-4 mb-4 bg-white rounded shadow">
    <div>
        <label for="filterTahun" class="mr-2 font-semibold text-gray-700">Filter Tahun:</label>
        <select id="filterTahun" class="border border-gray-300 rounded px-3 py-1 pr-8">
            <option value="">Semua Tahun</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
        </select>
    </div>
    <div>
       <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm flex items-center">
          Ekspor PDF
       </button>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
    
    <!-- Card: Total Laporan Kerusakan -->
    <div class="bg-blue-800 text-white rounded p-5 flex items-center justify-between shadow-md">
        <div class="flex items-center space-x-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-white text-opacity-80">Total Laporan Kerusakan</p>
                <p id="totalLaporan" class="text-2xl font-bold text-white">{{ $totalLaporan }}</p>
            </div>
        </div>
        <div class="text-white text-2xl">:</div>
    </div>

    <!-- Card: Laporan Ditolak -->
    <div class="bg-white rounded p-5 flex items-center justify-between shadow-md text-black">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-800 p-3 rounded-full text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-opacity-80">Laporan Ditolak</p>
                <p id="laporanditolak" class="text-2xl font-bold">{{ $totalLaporanDitolak }}</p>
            </div>
        </div>
        <div class="text-2xl">:</div>
    </div>

    <!-- Card: Perbaikan Selesai -->
    <div class="bg-white rounded p-5 flex items-center justify-between shadow-md text-black">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-800 p-3 rounded-full text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-opacity-80">Perbaikan Selesai</p>
                <p id="selesaiDiperbaiki" class="text-2xl font-bold">{{$totalLaporanSelesai}}</p>
            </div>
        </div>
        <div class="text-2xl">:</div>
    </div>

    <!-- Card: Total Fasilitas -->
    <div class="bg-white rounded p-5 flex items-center justify-between shadow-md text-black">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-800 p-3 rounded-full text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-2m-6 0H3m10-14v14"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-opacity-80">Total Fasilitas</p>
                <p id="jumlahFasilitas" class="text-2xl font-bold">{{ $totalFasilitas }}</p>
            </div>
        </div>
        <div class="text-2xl">:</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
    <div
        class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border border-gray-200 rounded shadow lg:col-span-2 dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div class="mb-4">
                <h2 class="text-sm text-gray-500 dark:text-neutral-500">Laporan Kerusakan Bulanan</h2>
            </div>
        </div>
        <!-- End Header -->
        <div id="charts-kerusakan" class="relative w-full h-full"></div>
    </div>

    <div
        class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border border-gray-200 rounded shadow dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div class="mb-4">
                <h2 class="text-sm text-gray-500 dark:text-neutral-500"> Status Laporan</h2>
            </div>
        </div>
        <!-- End Header -->
        <div id="hs-statuslaporan" class="relative w-full h-full"></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
    <div
        class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border border-gray-200 rounded shadow lg:col-span-2 dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div class="mb-4">
                <h2 class="text-sm text-gray-500 dark:text-neutral-500">Laporan per jenis kategori</h2>
            </div>
        </div>
        <!-- End Header -->
        <div id="charts-kategori" class="relative w-full h-full"></div>
    </div>

    <!-- kepuasan pengguna -->
    <div
        class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border border-gray-200 rounded shadow dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div class="mb-4">
                <h2 class="text-sm text-gray-500 dark:text-neutral-500">Kepuasan Pengguna</h2>
            </div>
        </div>

        <div id="kepuasanChartContainer" class="relative w-full h-full"></div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const bulanLabels = @json($bulanLaporan);
  const totalKerusakan = @json($jumlahLaporan);

  const ctx = document.createElement('canvas');
  document.getElementById('charts-kerusakan').appendChild(ctx);

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: bulanLabels,
      datasets: [{
        data: totalKerusakan,
        fill: true,
        borderColor: 'rgb(59, 130, 246)', 
        backgroundColor: 'rgba(59, 130, 246, 0.2)',
        tension: 0.3,
        pointRadius: 5,
        pointHoverRadius: 7,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: {
          beginAtZero: true,
          suggestedMax: 50,
          ticks: {
            stepSize: 10
          },
          grid: {
            color: '#e5e7eb'
          }
        },
        x: {
          grid: {
            color: '#e5e7eb'
          }
        }
      }
    }
  });

  // Donut Chart status laporan 
  const donutCtx = document.createElement("canvas");
  donutCtx.style.width = "100%";
  donutCtx.style.height = "100%";
  document.getElementById("hs-statuslaporan").appendChild(donutCtx);

  new Chart(donutCtx, {
      type: "doughnut",
      data: {
          labels: ['Diverifikasi', 'Diproses', 'Selesai', 'Ditolak'],
          datasets: [{
              data: [40, 30, 10, 20], // Contoh data persentase
              backgroundColor: ['#1E3A8A', '#3B82F6', '#60A5FA', '#BFDBFE'],
              hoverOffset: 4
          }]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
              legend: {
                  position: 'bottom',
                  labels: { color: "#6B7280" }
              }
          }
      }
  });

  //Chart kategori fasilitas 
  const fasilitasLabels = [
    'AC', 'Projector', 'Kelistrikan', 'Meja', 'Kursi',
    'WiFi', 'Printer', 'Komputer', 'Scanner', 'Dispenser'
  ];
  const jumlahKerusakanFasilitas = [60, 15, 12, 40, 10, 5, 62, 6, 4, 3];

  const canvasKategori = document.createElement("canvas");
  document.getElementById("charts-kategori").appendChild(canvasKategori);

  new Chart(canvasKategori, {
    type: 'bar',
    data: {
      labels: fasilitasLabels,
      datasets: [{
        label: 'Jumlah Kerusakan',
        data: jumlahKerusakanFasilitas,
        backgroundColor: '#3B82F6',
        borderRadius: 5,
        barThickness: 40,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        title: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          max: 100,
          ticks: { 
            color: '#374151',
            stepSize: 5
          },
          title: { display: true, text: 'Jumlah', color: '#6B7280' }
        },
        x: {
          ticks: { color: '#374151' },
          title: { display: true, text: 'Jenis Fasilitas', color: '#6B7280' }
        }
      }
    }
  });

  // Chart Kepuasan Pengguna
const kepuasanContainer = document.getElementById('kepuasanChartContainer');
const kepuasanCanvas = document.createElement('canvas');
kepuasanContainer.appendChild(kepuasanCanvas);

const ratingPercent = 90;

new Chart(kepuasanCanvas.getContext('2d'), {
  type: 'doughnut',
  data: {
    datasets: [{
      data: [ratingPercent, 100 - ratingPercent],
      backgroundColor: ['#2563EB', '#60A5FA'],
      hoverBackgroundColor: ['#1E3A8A', '#3B82F6'],
      borderWidth: 0
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: { enabled: true }
    }
  },
  plugins: [{
    id: 'centerText',
    beforeDraw(chart) {
      const { ctx, width, height } = chart;
      ctx.save();
      ctx.font = 'bold 2.5rem sans-serif';
      ctx.fillStyle = '#1E3A8A';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText(ratingPercent + '%', width / 2, height / 2);
      ctx.restore();
    }
  }]
});

</script>

@endsection
