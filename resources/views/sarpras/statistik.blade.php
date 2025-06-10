@extends('layouts.app')

@section('content')
<!-- Container filter+download -->
<div class="flex items-center justify-between py-4 px-4 mb-4 bg-white rounded shadow">
    <div>
<label for="filterTahun" class="mr-2 font-semibold text-gray-700 text-sm">Filter Tahun:</label>
<select id="filterTahun" name="tahun" class="border border-gray-300 rounded px-3 py-1 pr-8">
    <option value="">Semua Tahun</option>
    @php
        $startYear = 2025;
        $endYear = date('Y') + 3; // 3 tahun ke depan dari tahun sekarang
    @endphp

    @for ($year = $startYear; $year <= $endYear; $year++)
        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
    @endfor
</select>



    </div>
   <div>
  <form method="GET">
      <input type="hidden" name="tahun" id="exportTahun" value="{{ request('tahun') }}">
      <button type="submit"
          class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm flex items-center">
          Ekspor PDF
      </button>
  </form>
</div>

</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
    
    <!-- Card: Total Laporan Kerusakan -->
    <div class="bg-[#1652b7]  text-white rounded p-5 flex items-center justify-between shadow-md">
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
                <p id="jumlahLaporan" class="text-2xl font-bold text-white">{{ $totalLaporanTahunan }}</p>
            </div>
        </div>
        <div class="text-white text-2xl">:</div>
    </div>

        <div class="bg-white rounded p-5 flex items-center justify-between shadow-md text-black">
        <div class="flex items-center space-x-4">
            <div class="bg-[#1652b7]  p-3 rounded-full text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.5 12a7.5 7.5 0 0112.768-5.303m0 0l-3.768 3.768m3.768-3.768v5.303
                        M19.5 12a7.5 7.5 0 01-12.768 5.303m0 0l3.768-3.768m-3.768 3.768v-5.303" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-opacity-80">Laporan Diproses</p>
                <p id="jumlahFasilitas" class="text-2xl font-bold">437</p>
            </div>
        </div>
        <div class="text-2xl">:</div>
    </div>
    <!-- Card: Perbaikan Selesai -->
    <div class="bg-white rounded p-5 flex items-center justify-between shadow-md text-black">
        <div class="flex items-center space-x-4">
            <div class="bg-[#1652b7]  p-3 rounded-full text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-opacity-80">Perbaikan Selesai</p>
                <p id="selesaiDiperbaiki" class="text-2xl font-bold">69</p>
            </div>
        </div>
        <div class="text-2xl">:</div>
    </div>

    <!-- Card: Total Fasilitas -->
        <!-- Card: Laporan Ditolak -->
    <div class="bg-white rounded p-5 flex items-center justify-between shadow-md text-black">
        <div class="flex items-center space-x-4">
            <div class="bg-[#1652b7]  p-3 rounded-full text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-opacity-80">Laporan Ditolak</p>
                <p id="laporanditolak" class="text-2xl font-bold">40</p>
            </div>
        </div>
        <div class="text-2xl">:</div>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
    <div
        class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border border-gray-200 rounded shadow lg:col-span-2 dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div class="mb-4">
                <h2 class="text-sm text-gray-500 dark:text-neutral-500">Laporan Kerusakan Bulanan</h2>
            </div>
        </div>
        <div id="charts-kerusakan" class="relative w-full h-full"></div>
    </div>
    <div
        class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border border-gray-200 rounded shadow dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div class="mb-4">
                <h2 class="text-sm text-gray-500 dark:text-neutral-500"> Status Laporan</h2>
            </div>
        </div>
        <div id="hs-statuslaporan" class="relative w-full h-full"></div>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
    <div
        class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border border-gray-200 rounded shadow lg:col-span-2 dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div class="mb-4">
                <h2 class="text-sm text-gray-500 dark:text-neutral-500">Laporan Jumlah Kerusakan Fasilitas</h2>
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

<div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
      <h2 class="text-lg font-semibold mb-4 text-slate-700">Laporan Kerusakan Terbanyak</h2> 
    <div class="overflow-x-auto">
        <table id="laporanTable" class="w-full table-auto text-center">
          <thead class="text-sm font-normal leading-none text-slate-600">
              <tr class="bg-slate-100 border-b border-slate-300 font-bold">
                  <th class="p-3">No</th>
                  <th class="p-3">Ruang</th>
                  <th class="p-3">Fasilitas</th>
                  <th class="p-3">Jumlah Laporan Kerusakan</th>
                  <th class="p-3">Terakhir Dilaporkan</th>
              </tr>
          </thead>
        </table>
    </div>
</div>

<script>
  const totalKerusakan = [12, 19, 3, 5, 20, 3, 5, 2, 10, 3, 4, 5];
  const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

  const ctx = document.createElement('canvas');
  document.getElementById('charts-kerusakan').appendChild(ctx);

  new Chart(ctx, {
  type: 'line',
  data: {
    labels: bulanLabels,
    datasets: [{
      data: totalKerusakan,
      fill: true,
      borderColor: '#1652b7',
      backgroundColor: 'rgba(22, 82, 183, 0.2)',
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
          suggestedMax: 20,
          ticks: {
            stepSize:2
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


const donutData = [12, 19, 3, 5];
const donutLabels = ['Diverifikasi', 'Diproses', 'Selesai', 'Ditolak'];

const donutCtx = document.createElement("canvas");
donutCtx.style.width = "100%";
donutCtx.style.height = "100%";
document.getElementById("hs-statuslaporan").appendChild(donutCtx);

new Chart(donutCtx, {
    type: "doughnut",
    data: {
        labels: donutLabels,
        datasets: [{
            data: donutData,
            backgroundColor: ['#1E3A8A', '#3B82F6', '#60A5FA', '#BFDBFE'],
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
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const index = context.dataIndex;
                        const label = context.label;
                        const originalValue = rawData[index] || 0;
                        return `${label}: ${originalValue}`;
                    }
                }
            }
        },
        cutout: '70%',
    }
});

//Chart kategori fasilitas 
  const fasilitasLabels = ['ac', 'pintu', 'lantai', 'meja', 'kursi','led'];
  const jumlahKerusakanFasilitas = [12, 19, 3, 5, 20, 3, 5, 2, 10, 3, 4, 5];   

  const canvasKategori = document.createElement("canvas");
  document.getElementById("charts-kategori").appendChild(canvasKategori);

  new Chart(canvasKategori, {
    type: 'bar',
    data: {
      labels: fasilitasLabels,
      datasets: [{
        label: 'Jumlah Kerusakan',
        data: jumlahKerusakanFasilitas,
        backgroundColor: '#1652b7',
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
          max: 16,
          ticks: { 
            color: '#6B7280',
            stepSize: 2
          },
          
        },
        x: {
          ticks: { color: '#6B7280' },
          title: { display: true, text: 'Jenis Fasilitas', color: '#6B7280' }
        }
      }
    }
  });


  // chart kepuasan pengguna

const validPersen = 80;
const kepuasanCanvas = document.createElement('canvas');
const container = document.getElementById('kepuasanChartContainer');
container.innerHTML = '';
container.appendChild(kepuasanCanvas);

// Jika nilai 0, tetap tampilkan 100% biru
const dataValues = [validPersen > 0 ? validPersen : 100];
const dataColors = ['#1652b7'];

// Jika nilai > 0, tambahkan bagian abu-abu
if (validPersen > 0) {
  dataValues.push(100 - validPersen);
  dataColors.push('#E5E7EB');
}

new Chart(kepuasanCanvas.getContext('2d'), {
  type: 'doughnut',
  data: {
    datasets: [{
      data: dataValues,
      backgroundColor: dataColors,
      borderWidth: 0,
      cutout: '70%',
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        enabled: true,
        callbacks: {
          label: function (context) {
            return validPersen + '%';
          }
        }
      }
    }
  },
  plugins: [{
    id: 'centerText',
    beforeDraw(chart) {
      const { ctx, width, height } = chart;
      ctx.save();
      ctx.font = 'bold 1.5rem sans-serif';
      ctx.fillStyle = '#1652b7';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText(validPersen + '%', width / 2, height / 2);
      ctx.restore();
    }
  }]
});


</script>
@endsection

