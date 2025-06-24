<?php

namespace App\Http\Controllers;

use App\Models\t_laporan as Laporan;
use App\Models\m_fasilitas as Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\t_laporan;

class StatistikSarprasController extends Controller
{
    public function Statistik(Request $request)
    {
        $tahun = $request->input('tahun') ?? date('Y');

        $totalLaporan = Laporan::whereYear('lapor_datetime', $tahun)->count();

        // Hitung laporan yang masih diproses 
        $totalLaporanDiproses = Laporan::whereYear('lapor_datetime', $tahun)
            ->where('is_verified', 1)
            ->where('is_done', 0)
            ->count();

        // Hitung laporan yang sudah selesai 
        $totalLaporanSelesai = Laporan::whereYear('lapor_datetime', $tahun)
            ->where('is_done', 1)
            ->where('is_verified', 1)
            ->count();

        // Hitung laporan yang ditolak 
        $totalLaporanDitolak = Laporan::whereYear('lapor_datetime', $tahun)
            ->where('is_done', 1)
            ->where('is_verified', 0)
            ->count();

        $totalLaporanDiverifikasi = Laporan::whereYear('lapor_datetime', $tahun)
            ->where('is_verified', 1)
            ->where('is_done', 0)
            ->count();

        // Laporan per bulan
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
            ->limit(14)
            ->get();
        
        $namafasilitas = $kerusakanFasilitas->pluck('nama_fasilitas');
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

        return view('sarpras.statistik', compact(
            'totalLaporan',
            'totalLaporanDiproses',
            'totalLaporanSelesai',
            'totalLaporanDitolak',
            'totalLaporanDiverifikasi',
            'tahun',
            'bulanLaporan',
            'jumlahLaporan',
            'namafasilitas',
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

            $kerusakanFasilitas = t_laporan::with('fasilitas_ruang.fasilitas')
            ->whereYear('lapor_datetime', $tahun)
            ->get()
            ->groupBy(fn($laporan) => $laporan->fasilitas_ruang->fasilitas->fasilitas_nama ?? 'Tidak Diketahui')
            ->map(fn($group) => count($group))
            ->sortDesc()
            ->take(10);

        $namafasilitas = $kerusakanFasilitas->keys();
        $jumlahkerusakanfasilitas = $kerusakanFasilitas->values();

        $rataKepuasan = Laporan::whereNotNull('review_pelapor')
            ->whereYear('lapor_datetime', $tahun)
            ->avg('review_pelapor') ?? 0;


        $kerusakanRuangan = t_laporan::with(['fasilitas_ruang.fasilitas', 'fasilitas_ruang.ruangan'])
        ->whereYear('lapor_datetime', $tahun)
        ->get()
        ->groupBy(function ($laporan) {
            $ruangan = $laporan->fasilitas_ruang->ruangan->ruangan_nama ?? 'Tidak Diketahui';
            $fasilitas = $laporan->fasilitas_ruang->fasilitas->fasilitas_nama ?? 'Tidak Diketahui';
            return "$ruangan|$fasilitas";
        })
        ->map(function ($group) {
            return [
                'jumlah_laporan' => count($group),
                'terakhir_dilaporkan' => $group->max('lapor_datetime'),
                'ruangan' => $group->first()->fasilitas_ruang->ruangan->ruangan_nama ?? 'Tidak Diketahui',
                'fasilitas' => $group->first()->fasilitas_ruang->fasilitas->fasilitas_nama ?? 'Tidak Diketahui',
            ];
        })
        ->sortByDesc('jumlah_laporan')
        ->take(5)
        ->values();

        $detailKerusakanRuangan = \App\Models\t_laporan::with([
                'user',
                'fasilitas_ruang.fasilitas',
                'fasilitas_ruang.ruangan'
            ])
            ->whereYear('lapor_datetime', $tahun)
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pelapor' => $item->user->fullname ?? '-',
                    'ruangan_nama' => $item->fasilitas_ruang->ruangan->ruangan_nama ?? '-',
                    'fasilitas_nama' => $item->fasilitas_ruang->fasilitas->fasilitas_nama ?? '-',
                    'tanggal_pelaporan' => $item->lapor_datetime,
                ];
            });

        $pdf = PDF::loadView('sarpras.export_pdf', compact(
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
            'namafasilitas',
            'jumlahkerusakanfasilitas',
            'rataKepuasan',
            'kerusakanRuangan',
            'detailKerusakanRuangan'
        ));

        return $pdf->stream('laporan_statistik-Sarana Prasarana' . $tahun . '.pdf');
    }
}