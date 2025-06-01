@extends('layouts.app')

@section('content')

<!-- Filter and Download Section -->
<div class="p-6 flex justify-between items-center">
  <div>
    <label for="yearFilter" class="text-sm font-semibold mr-2">Filter Tahun:</label>
    <select id="yearFilter" class="border rounded-lg p-2 focus:ring-2 ">
      <option value="2025">2025</option>
      <option value="2024">2024</option>
      <option value="2023">2023</option>
    </select>
  </div>
  <button id="downloadPdf" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm transition duration-200">
    <i class="fa-solid fa-file-pdf mr-1"></i> Ekspor PDF
  </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
  <!-- Laporan Masuk -->
  <div class="bg-blue-600 text-white rounded-2xl p-5 flex items-center justify-between shadow-md">
    <div class="flex items-center space-x-4">
      <div class="bg-white bg-opacity-20 p-3 rounded-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
        </svg>
      </div>
      <div>
        <p class="text-sm text-white text-opacity-80">Total Laporan Masuk</p>
        <p class="text-2xl font-bold">436</p>
      </div>
    </div>
    <div class="text-white text-2xl">⋮</div>
  </div>

  <!-- Total Fasilitas -->
  <div class="bg-blue-600 text-white rounded-2xl p-5 flex items-center justify-between shadow-md">
    <div class="flex items-center space-x-4">
      <div class="bg-white bg-opacity-20 p-3 rounded-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-2m-6 0H3m10-14v14"/>
        </svg>
      </div>
      <div>
        <p class="text-sm text-white text-opacity-80">Total Fasilitas</p>
        <p class="text-2xl font-bold">248</p>
      </div>
    </div>
    <div class="text-white text-2xl">⋮</div>
  </div>

  <!-- Laporan Selesai Diperbaiki -->
  <div class="bg-blue-600 text-white rounded-2xl p-5 flex items-center justify-between shadow-md">
    <div class="flex items-center space-x-4">
      <div class="bg-white bg-opacity-20 p-3 rounded-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      <div>
        <p class="text-sm text-white text-opacity-80">Selesai Diperbaiki</p>
        <p class="text-2xl font-bold">123</p>
      </div>
    </div>
    <div class="text-white text-2xl">⋮</div>
  </div>

  <!-- Kepuasan Pengguna -->
  <div class="bg-blue-600 text-white rounded-2xl p-5 flex items-center justify-between shadow-md">
    <div class="flex items-center space-x-4">
      <div class="bg-white bg-opacity-20 p-3 rounded-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
      </div>
      <div>
        <p class="text-sm text-white text-opacity-80">Kepuasan Pengguna</p>
        <p class="text-2xl font-bold">80%</p>
      </div>
    </div>
    <div class="text-white text-2xl">⋮</div>
  </div>
</div>

<!-- Container fleksibel untuk grafik line dan pie berdampingan -->
<div class="flex flex-col lg:flex-row gap-6 p-6">
  <div class="bg-white p-4 rounded-2xl shadow w-[800px] h-[450px]">
    <h2 class="text-lg font-semibold text-black mb-4 text-left">
      Tren Kerusakan Sarana Prasarana Bulanan
    </h2>
    <canvas id="damageChart" class="h-full w-full"></canvas>
  </div>

  <!-- Grafik Pie Donut -->
  <div class="bg-white p-6 rounded-2xl shadow w-[400px] h-[450px] flex flex-col justify-between">
    <h2 class="text-lg font-semibold text-black mb-4 text-left">
      Proporsi Status Kerusakan
    </h2>
    <div class="flex-1 relative">
      <canvas id="damagePieChart" class="absolute top-0 left-0 w-full h-full"></canvas>
    </div>
  </div>
</div>

<!-- Tabel Data -->
<div class="px-6 py-2">
  <div class="bg-white p-6 rounded-2xl shadow w-full">
    <h2 class="text-lg font-semibold text-black mb-4 text-left">Daftar Kerusakan</h2>
    <div class="overflow-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">No</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Ruang</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Fasilitas</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tanggal</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr>
            <td class="px-4 py-2 text-sm text-gray-800">1</td>
            <td class="px-4 py-2 text-sm text-gray-800">Ruang 101</td>
            <td class="px-4 py-2 text-sm text-gray-800">Proyektor</td>
            <td class="px-4 py-2 text-sm text-gray-800">2025-05-30</td>
            <td class="px-4 py-2 text-sm">
              <span class="inline-block px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">Sedang</span>
            </td>
            <td class="px-4 py-2 text-sm">
              <button class="text-blue-500 hover:underline">Detail</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Line Chart
  const ctx = document.getElementById('damageChart').getContext('2d');
  const damageChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Jumlah Kerusakan',
        data: [8, 12, 15, 20, 18, 16, 10, 9, 14, 13, 11, 7],
        borderColor: '#1E40AF',
        backgroundColor: 'rgba(30, 64, 175, 0.1)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#1E40AF',
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      layout: {
        padding: { top: 10, bottom: 20, left: 10, right: 10 }
      },
      scales: {
        x: { ticks: { maxRotation: 0, minRotation: 0, padding: 10 } },
        y: { beginAtZero: true, ticks: { stepSize: 5, padding: 10 } }
      },
      plugins: { legend: { display: false } }
    }
  });

  // Pie Donut Chart
  const ctxPie = document.getElementById('damagePieChart').getContext('2d');
  const damagePieChart = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
      labels: ['Kerusakan Ringan', 'Kerusakan Sedang', 'Kerusakan Kritis', 'Sudah Diperbaiki'],
      datasets: [{
        label: 'Status Kerusakan',
        data: [25, 40, 20, 15],
        backgroundColor: ['#1E3A8A', '#3B82F6', '#60A5FA', '#BFDBFE'],
        borderColor: '#fff',
        borderWidth: 1,
        hoverOffset: 20,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            boxWidth: 12,
            padding: 10,
            font: { size: 12 }
          }
        },
        tooltip: { enabled: true }
      }
    }
  });
</script>
@endpush