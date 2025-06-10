<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_user as User;
use App\Models\t_fasilitas_ruang as FasilitasRuangan;
use App\Models\t_laporan as Laporan;
use App\Models\m_fasilitas as Fasilitas;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalPengguna = User::count();
        $totalFasilitas = FasilitasRuangan::count();
        $totalLaporan = Laporan::count();
        $totalLaporanSelesai = Laporan::where('is_done', 1)->count();

        // get last 6 months name
        $bulanLaporan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulanLaporan[] = date('M', strtotime('-' . $i . ' months'));
        }

        $jumlahLaporan = [];
        for ($i = 5; $i >= 0; $i--) {
            $jumlahLaporan[] = Laporan::where('lapor_datetime', 'like', date('Y-m', strtotime('-' . $i . ' months')) . '%')->count();
        }

        $jumlahLaporanSelesai = [];
        for ($i = 5; $i >= 0; $i--) {
            $jumlahLaporanSelesai[] = Laporan::where('is_done', 1)->where('lapor_datetime', 'like', date('Y-m', strtotime('-' . $i . ' months')) . '%')->count();
        }

        $hariLaporan = [];
        for ($i = 5; $i >= 0; $i--) {
            $hariLaporan[] = date('d-M', strtotime('-' . $i . ' days'));
        }

        $jumlahLaporanMingguan = [];
        for ($i = 5; $i >= 0; $i--) {
            $jumlahLaporanMingguan[] = Laporan::where('lapor_datetime', 'like', date('Y-m-d', strtotime('-' . $i . ' days')) . '%')->count();
        }

        return view('admin.index', compact('totalPengguna', 'totalFasilitas', 'totalLaporan', 'totalLaporanSelesai', 'bulanLaporan', 'jumlahLaporan', 'jumlahLaporanSelesai', 'jumlahLaporanMingguan', 'hariLaporan'));
    }

    public function sarpras()
    {
        $totalFasilitas = FasilitasRuangan::count();
        $totalLaporan = Laporan::count();
        $totalLaporanSelesai = Laporan::where('is_done', 1)->count();

        // get last 6 months name
        $bulanLaporan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulanLaporan[] = date('M', strtotime('-' . $i . ' months'));
        }

        $jumlahLaporan = [];
        for ($i = 5; $i >= 0; $i--) {
            $jumlahLaporan[] = Laporan::where('lapor_datetime', 'like', date('Y-m', strtotime('-' . $i . ' months')) . '%')->count();
        }

        $jumlahLaporanSelesai = [];
        for ($i = 5; $i >= 0; $i--) {
            $jumlahLaporanSelesai[] = Laporan::where('is_done', 1)->where('lapor_datetime', 'like', date('Y-m', strtotime('-' . $i . ' months')) . '%')->count();
        }

        $hariLaporan = [];
        for ($i = 5; $i >= 0; $i--) {
            $hariLaporan[] = date('d-M', strtotime('-' . $i . ' days'));
        }

        $jumlahLaporanMingguan = [];
        for ($i = 5; $i >= 0; $i--) {
            $jumlahLaporanMingguan[] = Laporan::where('lapor_datetime', 'like', date('Y-m-d', strtotime('-' . $i . ' days')) . '%')->count();
        }

        return view('sarpras.index', compact('totalFasilitas', 'totalLaporan', 'totalLaporanSelesai', 'bulanLaporan', 'jumlahLaporan', 'jumlahLaporanSelesai', 'jumlahLaporanMingguan', 'hariLaporan'));
    }
}
