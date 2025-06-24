<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_user as User;
use App\Models\t_fasilitas_ruang as FasilitasRuangan;
use App\Models\t_laporan as Laporan;
use Illuminate\Support\Facades\Auth;
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

    public function teknisi()
    {
        $tugasDikerjakan = Laporan::where('teknisi_id', Auth::user()->user_id)->where('is_kerjakan', 1)->where('is_done', 0)->count();
        $tugasSelesai = Laporan::where('is_done', 1)->where('teknisi_id', Auth::user()->user_id)->count();
        $tugasBaru = Laporan::where('teknisi_id', Auth::user()->user_id)->where('is_kerjakan', null)->count();

        // get last 6 months name
        $bulanLaporan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulanLaporan[] = date('M', strtotime('-' . $i . ' months'));
        }

        $jumlahLaporanSelesai = [];
        for ($i = 5; $i >= 0; $i--) {
            $jumlahLaporanSelesai[] = Laporan::where('is_done', 1)->where('teknisi_id', Auth::user()->user_id)->where('selesai_datetime', 'like', date('Y-m', strtotime('-' . $i . ' months')) . '%')->count();
        }

        $last3tugas = Laporan::where('teknisi_id', Auth::user()->user_id)->where('is_done', 0)->orderBy('lapor_datetime', 'desc')->limit(3)->get();

        return view('teknisi.index', compact('tugasDikerjakan', 'tugasSelesai', 'tugasBaru', 'bulanLaporan', 'jumlahLaporanSelesai', 'last3tugas'));
    }

    public function sarpras()
    {
        $totalFasilitas = FasilitasRuangan::count();
        $totalLaporan = Laporan::count();
        $totalLaporanSelesai = Laporan::where('is_done', 1)->count();

        // get last 6 months name
        $bulanLaporan = [];
        for ($i = 1; $i <= 7; $i++) {
            $bulanLaporan[] = date('M', mktime(0, 0, 0, $i, 1));
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

        // Ambil 5 laporan terakhir
        $laporanTerbaru = Laporan::latest('lapor_datetime')->take(5)->get();


        return view('sarpras.index', compact('totalFasilitas', 'totalLaporan', 'totalLaporanSelesai', 'bulanLaporan', 'jumlahLaporan', 'jumlahLaporanSelesai', 'jumlahLaporanMingguan', 'hariLaporan', 'laporanTerbaru'));
    }
}
