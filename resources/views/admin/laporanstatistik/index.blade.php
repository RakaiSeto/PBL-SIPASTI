@extends('layouts.app')

@section('title', 'Laporan & Statistik')

@section('content')
<div class="p-6 bg-white min-h-screen">

  <h1 class="text-2xl font-bold flex items-center mb-6 space-x-3 text-blue-700">
    <i class="fa-solid fa-file-lines"></i>
    <span>Laporan & Statistik</span>
  </h1>


 <!-- Filter Periode Tahun -->
@php
  $tahunSekarang = now()->year;
  $tahunAwal = 2022;
@endphp

<form method="GET" action="#" class="mb-6 flex items-center gap-4 flex-wrap">
  <label for="tahun" class="font-semibold">Pilih Tahun:</label>
  <select name="tahun" id="tahun" class="border rounded px-3 py-1">
    @for ($tahun = $tahunAwal; $tahun <= $tahunSekarang; $tahun++)
      <option value="{{ $tahun }}">{{ $tahun }}</option>
    @endfor
  </select>
  <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
    Tampilkan
  </button>
</form>


  <!-- Ringkasan Status Perbaikan -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white rounded shadow p-4 text-center">
      <div class="text-4xl font-bold text-yellow-500">12</div>
      <div class="mt-2 font-semibold">Sedang Diperbaiki</div>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
      <div class="text-4xl font-bold text-green-600">28</div>
      <div class="mt-2 font-semibold">Sudah Diperbaiki</div>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
      <div class="text-4xl font-bold text-gray-400">5</div>
      <div class="mt-2 font-semibold">Menunggu Antrian</div>
    </div>
  </div>

  <!-- Grafik Tren Perbaikan -->
  <div class="bg-white rounded shadow p-6 mb-10">
    <h2 class="text-xl font-semibold mb-4 flex items-center space-x-2 text-blue-700">
      <i class="fa-solid fa-chart-line"></i>
      <span>Tren Perbaikan Fasilitas</span>
    </h2>
    <canvas id="chartPerbaikan" height="150"></canvas>
  </div>

  <!-- Statistik Kepuasan Pengguna -->
  <div class="bg-white rounded shadow p-6">
    <h2 class="text-xl font-semibold mb-4 flex items-center space-x-2 text-green-700">
      <i class="fa-solid fa-face-smile"></i>
      <span>Kepuasan Pengguna</span>
    </h2>
    <canvas id="chartKepuasan" height="150"></canvas>
  </div>

</div>
@endsection

@push('scripts')
<script>
  // Chart Tren Perbaikan (Data dummy, ganti dengan data dari controller)
  const ctxPerbaikan = document.getElementById('chartPerbaikan').getContext('2d');
  new Chart(ctxPerbaikan, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
      datasets: [{
        label: 'Perbaikan',
        data: [5, 9, 7, 14, 10, 12, 15],
        borderColor: '#2563EB',
        backgroundColor: 'rgba(37, 99, 235, 0.3)',
        fill: true,
        tension: 0.3,
        pointRadius: 5,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Chart Kepuasan Pengguna (Data dummy)
  const ctxKepuasan = document.getElementById('chartKepuasan').getContext('2d');
  new Chart(ctxKepuasan, {
    type: 'doughnut',
    data: {
      labels: ['Puas', 'Cukup Puas', 'Tidak Puas'],
      datasets: [{
        label: 'Kepuasan',
        data: [65, 25, 10],
        backgroundColor: [
          '#16A34A',
          '#FBBF24',
          '#DC2626',
        ],
        hoverOffset: 30
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });

  // Event tombol filter (masih dummy)
  document.getElementById('btnFilter').addEventListener('click', () => {
    alert('Fitur filter belum diaktifkan. Hubungkan dengan backend.');
  });
</script>
@endpush
