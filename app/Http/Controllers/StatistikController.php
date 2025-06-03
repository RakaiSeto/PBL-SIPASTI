<?php

namespace App\Http\Controllers;

use App\Models\t_laporan as Laporan;
use App\Models\m_fasilitas as fasilitas;
use Illuminate\Http\Request;

class StatistikController extends Controller
{

        public function laporanStatistik()
        {
            $totalLaporan = Laporan::count(); 
            $totalLaporanDitolak = Laporan::where('is_done', 1)
            ->where('is_verified', 0)
            ->count();
            $totalLaporanSelesai = Laporan::where('is_done', 1)->count();
            $totalFasilitas = fasilitas::count();

            $tahun = date('Y'); // Ambil tahun saat ini, misal: 2025

            $bulanLaporan = [];
            $jumlahLaporan = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan = str_pad($i, 2, '0', STR_PAD_LEFT); // Format 01, 02, ..., 12
            $bulanLaporan[] = date('M', strtotime("$tahun-$bulan-01")); // Contoh: Jan, Feb, ...
            $jumlahLaporan[] = Laporan::where('lapor_datetime', 'like', "$tahun-$bulan%")->count();
        }
        

            return view('admin.laporanstatistik.index', compact('totalLaporan', 'totalLaporanDitolak', 'totalFasilitas', 'bulanLaporan', 'jumlahLaporan', 'totalLaporanSelesai'));
        }

}   
