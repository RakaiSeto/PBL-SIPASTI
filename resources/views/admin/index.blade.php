@extends('layouts.app')
@section('content')
{{-- <div class="p-4"> --}}
    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
      <!-- Card 1 -->
      <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="text-sm text-gray-500">Total Pengguna</h3>
            {{-- <p class="text-lg font-bold">173</p> --}}
            <p id="jumlahPengguna" class="text-lg font-bold">{{ $totalPengguna }}</p>
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
            <h3 class="text-sm text-gray-500">Total Fasilitas</h3>
            <p class="text-lg font-bold">{{ $totalFasilitas }}</p>
          </div>
          <div class="bg-primary text-white p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 114 0v2m4 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="text-sm text-gray-500">Total Laporan</h3>
            <p class="text-lg font-bold">{{ $totalLaporan }}</p>
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
            <h3 class="text-sm text-gray-500"> Fasilitas diperbaiki</h3>
            <p class="text-lg font-bold">{{ $totalLaporanSelesai }}</p>
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
            <h2 class="text-sm text-gray-500 dark:text-neutral-500">Total Kerusakan Bulanan</h2>
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
            <h2 class="text-sm text-gray-500 dark:text-neutral-500">Laporan Harian</h2>
          </div>
        </div>
        <!-- End Header -->

        <div id="hs-single-area-chart"></div>
      </div>
      <!-- End Card -->
    </div>

    <div class="bg-white p-4 rounded shadow">
      <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
        <div>
          <h3 class="text-lg font-semibold text-slate-800">Laporan Terbaru</h3>
        </div>
        <div class="ml-3">
          <div class="w-full max-w-sm min-w-[200px] relative">
            <div class="relative">
              <input
                class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-200 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                placeholder="Cari..."
              />
              <button class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-800 bg-white shadow-md rounded-lg bg-clip-border">
        <table class="w-full text-left table-auto min-w-max">
          <thead>
            <tr>
              <th class="p-4 border-b border-slate-200 bg-slate-100">
                <p class="text-sm font-normal leading-none text-slate-500">ID Laporan</p>
              </th>
              <th class="p-4 border-b border-slate-200 bg-slate-100">
                <p class="text-sm font-normal leading-none text-slate-500">Nama Fasilitas</p>
              </th>
              <th class="p-4 border-b border-slate-200 bg-slate-100">
                <p class="text-sm font-normal leading-none text-slate-500">Kategori</p>
              </th>
              <th class="p-4 border-b border-slate-200 bg-slate-100">
                <p class="text-sm font-normal leading-none text-slate-500">Nama Pelapor</p>
              </th>
              <th class="p-4 border-b border-slate-200 bg-slate-100">
                <p class="text-sm font-normal leading-none text-slate-500">Due Date</p>
              </th>
              <th class="p-4 border-b border-slate-200 bg-slate-100">
                <p class="text-sm font-normal leading-none text-slate-500">Status</p>
              </th>
              <th class="p-4 border-b border-slate-200 bg-slate-100">
                <p class="text-sm font-normal leading-none text-slate-500">Aksi</p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="hover:bg-slate-50 border-b border-slate-200">
              <td class="p-4 py-5">
                <p class="block font-semibold text-sm text-slate-800">LF001</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">AC Mati</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">AC</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">Febri</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">2025-05-05</p>
              </td>
              <td class="p-4 border-b border-blue-gray-50">
                <div class="w-max">
                  <div class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-green-900 uppercase rounded-md select-none whitespace-nowrap bg-green-500/20">
                    <span class="">Selesai</span>
                  </div>
                </div>
              </td>
              <td class="p-4 flex border-b border-gray-200">
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-pen"></i>
                </button>
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
            <tr class="hover:bg-slate-50 border-b border-slate-200">
              <td class="p-4 py-5">
                <p class="block font-semibold text-sm text-slate-800">LF001</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">AC Mati</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">AC</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">Nopak</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">2025-05-05</p>
              </td>
              <td class="p-4 border-b border-blue-gray-50">
                <div class="w-max">
                  <div class="relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap bg-amber-500/20 text-amber-900">
                    <span class="">Prosses</span>
                  </div>
                </div>
              </td>
              <td class="p-4 flex border-b border-gray-200">
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-pen"></i>
                </button>
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
            <tr class="hover:bg-slate-50 border-b border-slate-200">
              <td class="p-4 py-5">
                <p class="block font-semibold text-sm text-slate-800">LF001</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">AC Mati</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">AC</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">Rakai</p>
              </td>
              <td class="p-4 py-5">
                <p class="text-sm text-slate-500">2025-05-05</p>
              </td>
              <td class="p-4">
                <div class="w-max">
                  <div class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-red-900 uppercase rounded-md select-none whitespace-nowrap bg-red-500/20">
                    <span class="">Dibatalkan</span>
                  </div>
                </div>
              </td>
              <td class="p-4 flex border-b border-gray-200">
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-pen"></i>
                </button>
                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-gray-900 hover:bg-gray-200">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="flex justify-between items-center px-4 py-3">
          <div class="text-sm text-slate-500">Showing <b>1-5</b> of 45</div>
          <div class="flex space-x-1">
            <button class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">Prev</button>
            <button class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-white bg-primary border border-slate-800 rounded hover:bg-slate-600 hover:border-slate-600 transition duration-200 ease">1</button>
            <button class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">2</button>
            <button class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">3</button>
            <button class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">Next</button>
          </div>
        </div>
      </div>
    {{-- </div> --}}

    <!--  -->
  </div>

  <script>
$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: '{{ url("/api/kelola-pengguna") }}',
        data: {
            role: '',
            search: ''
        },
        success: function(response) {
            const jumlah = response.data.total || response.data.data.length || 0;
            $('#jumlahPengguna').text(jumlah);
        }
    });
});

    // Multiple Bar Chart (Income)
    const incomeCtx = document.createElement("canvas");
    document.getElementById("hs-multiple-bar-charts").appendChild(incomeCtx);

    new Chart(incomeCtx, {
      type: "bar",
      data: {
        labels: [@foreach ($bulanLaporan as $item)
          "{{ $item }}",
        @endforeach],
        datasets: [
          {
            label: "Jumlah Laporan",
            data: [@foreach ($jumlahLaporan as $item)
              {{ $item }},
            @endforeach],
            backgroundColor: "#1652B7",
            borderRadius: 5,
          },
          {
            label: "Jumlah Laporan Selesai",
            data: [@foreach ($jumlahLaporanSelesai as $item)
              {{ $item }},
            @endforeach],
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
        labels: [@foreach ($hariLaporan as $item)
          "{{ $item }}",
        @endforeach],
        datasets: [
          {
            label: "Jumlah Laporan Harian",
            data: [@foreach ($jumlahLaporanMingguan as $item)
              {{ $item }},
            @endforeach],
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
