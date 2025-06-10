<?php

namespace App\Http\Controllers;

use App\Models\t_laporan as Laporan;
use App\Models\m_fasilitas as Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikSarprasController extends Controller
{
     public function laporanStatistik(Request $request)
{
    $tahun = $request->input('tahun') ?? date('Y');

    // Total laporan dan fasilitas
    $totalLaporanTahunan = Laporan::whereYear('lapor_datetime', $tahun)->count();
    $totalFasilitas = Fasilitas::count();

    // Laporan status
    $totalLaporanSelesai = Laporan::whereYear('lapor_datetime', $tahun)
        ->where('is_done', 1)
        ->where('is_verified', 1)
        ->count();

    $totalLaporanDitolak = Laporan::whereYear('lapor_datetime', $tahun)
        ->where('is_done', 1)
        ->where('is_verified', 0)
        ->count();

    $totalLaporanDiverifikasi = Laporan::whereYear('lapor_datetime', $tahun)
        ->where('is_verified', 1)
        ->where('is_done', 0)
        ->count();

    $totalLaporanProses = $totalLaporanDiverifikasi;

    // Laporan per bulan
    $bulanLaporan = [];
    $jumlahLaporanPerBulan = [];

    for ($i = 1; $i <= 12; $i++) {
        $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
        $bulanLaporan[] = date('M', strtotime("$tahun-$bulan-01"));
        $jumlahLaporanPerBulan[] = Laporan::where('lapor_datetime', 'like', "$tahun-$bulan%")->count();
    }

    // Top 10 kerusakan fasilitas
    $kerusakanFasilitas = DB::table('t_laporan')
        ->join('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
        ->join('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
        ->whereYear('t_laporan.lapor_datetime', $tahun)
        ->select('m_fasilitas.fasilitas_nama as nama_fasilitas', DB::raw('count(*) as jumlah'))
        ->groupBy('m_fasilitas.fasilitas_nama')
        ->orderByDesc('jumlah')
        ->limit(10)
        ->get();

    $labelsfasilitas = $kerusakanFasilitas->pluck('nama_fasilitas');
    $jumlahkerusakanfasilitas = $kerusakanFasilitas->pluck('jumlah');

    return view('sarpras.statistik', compact(
        'totalLaporanTahunan',
        'totalFasilitas',
        'totalLaporanDitolak',
        'totalLaporanSelesai',
        'totalLaporanDiverifikasi',
        'totalLaporanProses',
        'bulanLaporan',
        'jumlahLaporanPerBulan',
        'tahun',
        'kerusakanFasilitas',
        'labelsfasilitas',
        'jumlahkerusakanfasilitas'
    ));
}
}