<?php

namespace App\Http\Controllers;

use App\Models\t_laporan as Laporan;
use App\Models\m_fasilitas as Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class StatistikController extends Controller
{
    public function laporanStatistik(Request $request)
    {
        $tahun = $request->input('tahun') ?? date('Y');

        // Total laporan dan fasilitas
        $totalLaporan = Laporan::whereYear('lapor_datetime', $tahun)->count();
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

        $totalLaporanProses = $totalLaporanDiverifikasi; // sama dengan diverifikasi tapi belum selesai

        // Laporan per bulan
        $bulanLaporan = [];
        $jumlahLaporan = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
            $bulanLaporan[] = date('M', strtotime("$tahun-$bulan-01"));
            $jumlahLaporan[] = Laporan::where('lapor_datetime', 'like', "$tahun-$bulan%")->count();
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

        // Rata-rata kepuasan
        $rataKepuasan = DB::table('t_laporan')
            ->whereNotNull('review_pelapor')
            ->whereYear('lapor_datetime', $tahun)
            ->avg('review_pelapor') ?? 0;

        //tabel
        $kerusakanRuangan = DB::table('t_laporan')
            ->join('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
            ->join('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
            ->join('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
            ->whereYear('t_laporan.lapor_datetime', $tahun)
            ->select(
                'm_ruangan.ruangan_nama',
                'm_fasilitas.fasilitas_nama',
                DB::raw('count(t_laporan.laporan_id) as jumlah_laporan'),
                DB::raw('MAX(t_laporan.lapor_datetime) as terakhir_dilaporkan') 
            )
            ->groupBy('m_ruangan.ruangan_nama', 'm_fasilitas.fasilitas_nama')
            ->orderByDesc('jumlah_laporan')
            ->limit(5)
            ->get();


        return view('admin.laporanstatistik.index', compact(
            'totalLaporan',
            'totalLaporanDitolak',
            'totalFasilitas',
            'bulanLaporan',
            'jumlahLaporan',
            'totalLaporanSelesai',
            'totalLaporanDiverifikasi',
            'totalLaporanProses',
            'tahun',
            'kerusakanFasilitas',
            'labelsfasilitas',
            'jumlahkerusakanfasilitas',
            'rataKepuasan',
            'kerusakanRuangan'
        ));
    }

    public function exportPDF(Request $request)
{
    $tahun = $request->input('tahun') ?? date('Y');

    // Ambil data sama seperti di laporanStatistik
    $totalLaporan = Laporan::whereYear('lapor_datetime', $tahun)->count();
    $totalFasilitas = Fasilitas::count();

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

    $bulanLaporan = [];
    $jumlahLaporan = [];

    for ($i = 1; $i <= 12; $i++) {
        $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
        $bulanLaporan[] = date('M', strtotime("$tahun-$bulan-01"));
        $jumlahLaporan[] = Laporan::where('lapor_datetime', 'like', "$tahun-$bulan%")->count();
    }

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

    $rataKepuasan = DB::table('t_laporan')
        ->whereNotNull('review_pelapor')
        ->whereYear('lapor_datetime', $tahun)
        ->avg('review_pelapor') ?? 0;

    $kerusakanRuangan = DB::table('t_laporan')
        ->join('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
        ->join('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
        ->join('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
        ->whereYear('t_laporan.lapor_datetime', $tahun)
        ->select(
            'm_ruangan.ruangan_nama',
            'm_fasilitas.fasilitas_nama',
            DB::raw('count(t_laporan.laporan_id) as jumlah_laporan'),
            DB::raw('MAX(t_laporan.lapor_datetime) as terakhir_dilaporkan') 
        )
        ->groupBy('m_ruangan.ruangan_nama', 'm_fasilitas.fasilitas_nama')
        ->orderByDesc('jumlah_laporan')
        ->limit(5)
        ->get();

    // Load view PDF dan kirim data
    $pdf = PDF::loadView('admin.laporanstatistik.export_pdf', compact(
        'totalLaporan',
        'totalLaporanDitolak',
        'totalFasilitas',
        'bulanLaporan',
        'jumlahLaporan',
        'totalLaporanSelesai',
        'totalLaporanDiverifikasi',
        'totalLaporanProses',
        'tahun',
        'kerusakanFasilitas',
        'labelsfasilitas',
        'jumlahkerusakanfasilitas',
        'rataKepuasan',
        'kerusakanRuangan'
    ));

    return $pdf->stream('laporan_statistik-Sarana Prasarana' . $tahun . '.pdf');
}

}
