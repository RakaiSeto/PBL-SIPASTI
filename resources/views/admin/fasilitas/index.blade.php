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
                    <th class="p-3">ID Fasilitas</th>
                    <th class="p-3">Nama Fasilitas</th>
                    <th class="p-3">Kategori Fasilitas</th>
                    <th class="p-3">Lantai</th>
                    <th class="p-3">Ruangan</th>
                    <th class="p-3">Kondisi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tambahkan baris data -->
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-3 font-semibold">LF001</td>
                    <td class="p-3">AC Mati</td>
                    <td class="p-3">Pendingin ruangan</td>
                    <td class="p-3">Lantai 5</td>
                    <td class="p-3">RT01</td>
                
                    <td class="p-3">
                        <span class="bg-green-500/20 text-green-900 text-xs px-2 py-1 rounded uppercase font-bold">
                            <i class="fas fa-check-circle mr-1"></i> Aktif
                        </span>
                        
                    </td>
                    <td class="p-3 flex gap-2">
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
