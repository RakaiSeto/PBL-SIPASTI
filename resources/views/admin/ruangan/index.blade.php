@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between mb-3 mt-1">
        <input
            class="w-full max-w-sm pr-11 h-10 pl-3 py-2 text-sm border border-slate-200 rounded"
            placeholder="Cari..."
        />
        <button class="px-4 py-2 bg-primary text-white rounded hover:bg-blue-700" onclick="document.getElementById('myModal').classList.remove('hidden')">
            Tambah Data
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-auto">
        <table class="w-full table-auto text-sm text-left">
            <thead>
                <tr class="bg-slate-100">
                    <th class="p-3">ID Ruangan</th>
                    <th class="p-3">Nama Ruangan</th>
                    <th class="p-3">Tipe Ruangan</th>
                    <th class="p-3">Lokasi</th>
                    <th class="p-3">Kapasitas</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tambahkan baris data -->
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">LF001</td>
                    <td class="p-3">AC Mati</td>
                    <td class="p-3">AC</td>
                    <td class="p-3">Febri</td>
                    <td class="p-3">2025-05-05</td>
                    <td class="p-3 flex gap-2">
                        <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Melihat Fasilitas
                          </button>                          
                        <button class="text-gray-600 hover:text-blue-600"><i class="fas fa-eye"></i></button>
                        <button class="text-gray-600 hover:text-yellow-600"><i class="fas fa-pen"></i></button>
                        <button class="text-gray-600 hover:text-red-600"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
