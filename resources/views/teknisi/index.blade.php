@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Tugas Baru</h3>
                    <p class="text-lg font-bold">2</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M12 11v6m3-3H9" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Tugas Selesai</h3>
                    <p class="text-lg font-bold">50</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <a href="/teknisi/tugasperbaikan" class="block bg-white p-4 rounded shadow hover:bg-gray-100 transition">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500">Tugas Dikerjakan</h3>
                    <p class="text-lg font-bold">15</p>
                </div>
                <div class="bg-primary text-white p-2 rounded-full">
                    <!-- Icon list -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
            </div>
        </a>
        <div class="grid lg:grid-cols-2 gap-2 sm:gap-4 mb-4">
    </div>
@endsection