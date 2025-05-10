@extends('layouts.app')
@section('content')
{{-- <div class="p-4"> --}}
    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
      <!-- Card 1 -->
      <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="text-sm text-gray-500">Laporan Aktif</h3>
            <p class="text-lg font-bold">3</p>
          </div>
          <div class="bg-primary text-white p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m1-9h4m-1-6h-2" />
            </svg>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="text-sm text-gray-500">Laporan diproses</h3>
            <p class="text-lg font-bold">1,240</p>
          </div>
          <div class="bg-primary text-white p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 114 0v2m4 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
            </svg>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="text-sm text-gray-500">Laporan Selesai</h3>
            <p class="text-lg font-bold">15</p>
          </div>
          <div class="bg-primary text-white p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414a8 8 0 11-11.314 0L4.636 5.636a10 10 0 1014.728 0z" />
            </svg>
          </div>
        </div>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-2 sm:gap-4 mb-4">
      <!-- Card -->
      <div class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 rounded shadow dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-2">
          <div class="mb-4">
            <h2 class="text-sm text-gray-500 dark:text-neutral-500">Total Kerusakan</h2>
          </div>
        </div>
        <!-- End Header -->

        <div id="hs-multiple-bar-charts"></div>
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 rounded shadow dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-2">
          <div class="mb-4">
            <h2 class="text-sm text-gray-500 dark:text-neutral-500">Visitors</h2>
          </div>
        </div>
        <!-- End Header -->

        <div id="hs-single-area-chart"></div>
      </div>
      <!-- End Card -->
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
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        datasets: [
          {
            label: "Income",
            data: [18, 22, 19, 25, 26, 31],
            backgroundColor: "#1652B7",
            borderRadius: 5,
          },
          {
            label: "Income",
            data: [10, 20, 11, 21, 20, 30],
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
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        datasets: [
          {
            label: "Visitors",
            data: [6, 15, 12, 17, 10, 18],
            fill: true,
            backgroundColor: "rgba(22, 82, 183, 0.1)",
            borderColor: "#1652B7",
            tension: 0.4,
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
  </script>
  @endsection
