<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_ruangan;
use App\Models\t_fasilitas_ruang;
use App\Models\t_laporan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CivitasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function laporkan()
    {
        $ruang = m_ruangan::all();
        $fasilitas = t_fasilitas_ruang::all();
        return view('civitas.laporkan', compact('ruang', 'fasilitas'));
    }

    public function index()
    {
        try {
            $userId = Auth::id();
            $laporanAktif = t_laporan::where('user_id', $userId)->where('is_verified', 0)->where('is_done', 0)->count();
            $laporanDiproses = t_laporan::where('user_id', $userId)->where('is_verified', 1)->where('is_done', 0)->count();
            $laporanSelesai = t_laporan::where('user_id', $userId)->where('is_done', 1)->where('is_verified', 1)->count();
            $laporanDitolak = t_laporan::where('user_id', $userId)->where('is_done', 1)->where('is_verified', 0)->count();
            $totalLaporan = $laporanAktif + $laporanDiproses + $laporanSelesai + $laporanDitolak;

            $lineChartData = t_laporan::select(
                DB::raw('DATE(lapor_datetime) as tanggal'),
                DB::raw('COUNT(*) as jumlah')
            )
                ->where('user_id', $userId)
                ->where('lapor_datetime', '>=', now()->subDays(7))
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get()
                ->pluck('jumlah', 'tanggal')
                ->toArray();

            $labelsLine = [];
            $dataLine = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $labelsLine[] = now()->subDays($i)->format('d M');
                $dataLine[] = $lineChartData[$date] ?? 0;
            }

            $dataDoughnut = [
                'Menunggu' => $totalLaporan ? round(($laporanAktif / $totalLaporan) * 100, 1) : 0,
                'Diproses' => $totalLaporan ? round(($laporanDiproses / $totalLaporan) * 100, 1) : 0,
                'Selesai' => $totalLaporan ? round(($laporanSelesai / $totalLaporan) * 100, 1) : 0,
                'Ditolak' => $totalLaporan ? round(($laporanDitolak / $totalLaporan) * 100, 1) : 0,
            ];

            return view('civitas.index', compact(
                'laporanAktif',
                'laporanDiproses',
                'laporanSelesai',
                'laporanDitolak',
                'totalLaporan',
                'labelsLine',
                'dataLine',
                'dataDoughnut'
            ));
        } catch (\Exception $e) {
            Log::error('Gagal memuat dashboard civitas: ' . $e->getMessage());
            return view('civitas.index')->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    public function status()
    {
        return view('civitas.status');
    }

    public function list(Request $request)
    {
        try {
            $columns = [
                0 => 't_laporan.laporan_id',
                1 => 'm_ruangan.ruangan_nama',
                2 => 'm_fasilitas.fasilitas_nama',
                3 => 't_laporan.lapor_datetime',
                4 => 't_laporan.is_verified',
            ];

            $limit = $request->input('length', 5);
            $start = $request->input('start', 0);
            $orderColumn = $columns[$request->input('order.0.column', 3)];
            $orderDir = $request->input('order.0.dir', 'desc');

            $query = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
                ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
                ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
                ->where('t_laporan.user_id', Auth::id());

            $totalData = $query->count();

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('m_ruangan.ruangan_nama', 'like', "%$search%")
                        ->orWhere('m_fasilitas.fasilitas_nama', 'like', "%$search%")
                        ->orWhere('t_laporan.deskripsi_laporan', 'like', "%$search%");
                });
            }

            $totalFiltered = $query->count();

            $laporans = $query->select(
                't_laporan.laporan_id',
                't_laporan.fasilitas_ruang_id',
                't_laporan.deskripsi_laporan',
                't_laporan.lapor_datetime',
                't_laporan.is_verified',
                't_laporan.is_done',
                'm_ruangan.ruangan_nama',
                'm_fasilitas.fasilitas_nama'
            )
                ->offset($start)
                ->limit($limit)
                ->orderBy($orderColumn, $orderDir)
                ->get();

            $data = [];
            foreach ($laporans as $laporan) {
                $data[] = [
                    'laporan_id' => $laporan->laporan_id,
                    'fasilitas_ruang_id' => $laporan->fasilitas_ruang_id,
                    'deskripsi_laporan' => $laporan->deskripsi_laporan,
                    'lapor_datetime' => $laporan->lapor_datetime,
                    'is_verified' => $laporan->is_verified,
                    'is_done' => $laporan->is_done,
                    'ruangan_nama' => $laporan->ruangan_nama,
                    'fasilitas_nama' => $laporan->fasilitas_nama,
                ];
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil list laporan (join): ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $laporan = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
                ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
                ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
                ->leftJoin('m_user', 't_laporan.user_id', '=', 'm_user.user_id')
                ->select(
                    't_laporan.laporan_id',
                    't_laporan.fasilitas_ruang_id',
                    't_laporan.deskripsi_laporan',
                    't_laporan.lapor_datetime',
                    't_laporan.verifikasi_datetime',
                    't_laporan.is_verified',
                    't_laporan.is_done',
                    't_laporan.lapor_foto',
                    'm_ruangan.ruangan_nama as ruangan_nama',
                    'm_fasilitas.fasilitas_nama as fasilitas_nama',
                    'm_user.fullname as user_fullname'
                )
                ->where('t_laporan.user_id', Auth::id())
                ->where('t_laporan.laporan_id', $id)
                ->firstOrFail();

            // Cek dan proses foto jika ada
            if ($laporan->lapor_foto) {
                $filePath = 'laporan/' . $laporan->laporan_id . '.jpg';
                // Use Laravel's asset helper to generate the full URL
                $laporan->lapor_foto_url = asset('storage/' . $filePath);

                if (!Storage::disk('public')->exists('laporan/' . $laporan->laporan_id . '.jpg')) {
                    // Laravel's Storage facade automatically creates parent directories if they don't exist.
                    Storage::disk('public')->put($filePath, $laporan->lapor_foto);
                }

                $laporan->lapor_foto = null;
            }

            return response()->json([
                'success' => true,
                'data' => $laporan
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan atau bukan milik Anda'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil detail laporan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }


    public function rating()
    {
        return view('civitas.rating');
    }

    public function ratingList(Request $request)
    {
        try {
            $columns = [
                0 => 't_laporan.laporan_id',
                1 => 'm_ruangan.ruangan_nama',
                2 => 'm_fasilitas.fasilitas_nama',
                3 => 't_laporan.lapor_datetime',
                4 => 't_laporan.selesai_datetime',
                5 => 't_laporan.is_verified',
            ];

            $totalData = t_laporan::where('user_id', Auth::id())
                ->where('is_done', 1)
                ->where('is_verified', 1)
                ->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length', 5);
            $start = $request->input('start', 0);
            $orderColumn = $columns[$request->input('order.0.column', 3)];
            $orderDir = $request->input('order.0.dir', 'desc');

            $query = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
                ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
                ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
                ->where('t_laporan.user_id', Auth::id())
                ->where('is_done', 1)
                ->where('is_verified', 1);

            if ($request->has('search') && !empty($request->search['value'])) {
                $search = $request->search['value'];
                $query->where('deskripsi_laporan', 'like', '%' . $search . '%');
                $totalFiltered = $query->count();
            }

            $laporans = $query->offset($start)
                ->limit($limit)
                ->orderBy($orderColumn, $orderDir)
                ->get();

            $data = [];
            foreach ($laporans as $laporan) {
                $data[] = [
                    'laporan_id' => $laporan->laporan_id,
                    'fasilitas_ruang_id' => $laporan->fasilitas_ruang_id,
                    'deskripsi_laporan' => $laporan->deskripsi_laporan,
                    'lapor_datetime' => $laporan->lapor_datetime,
                    'selesai_datetime' => $laporan->selesai_datetime,
                    'is_verified' => $laporan->is_verified,
                    'is_done' => $laporan->is_done,
                    'ruangan_nama' => $laporan->ruangan_nama,
                    'fasilitas_nama' => $laporan->fasilitas_nama,
                    'review_pelapor' => $laporan->review_pelapor,
                    'review_komentar' => $laporan->review_komentar,
                ];
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil list rating laporan: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    public function submitRating(Request $request)
    {
        try {
            $request->validate([
                'laporan_id' => 'required|exists:t_laporan,laporan_id',
                'rating' => 'required|integer|between:1,5',
                'komentar' => 'required|string|max:1000',
            ]);

            $laporan = t_laporan::where('user_id', Auth::id())
                ->where('laporan_id', $request->laporan_id)
                ->where('is_done', 1)
                ->where('is_verified', 1)
                ->firstOrFail();

            if ($laporan->review_pelapor !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Laporan ini sudah diberi rating.'
                ], 400);
            }

            $laporan->update([
                'review_pelapor' => $request->rating,
                'review_komentar' => $request->komentar,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Umpan balik berhasil dikirim.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan umpan balik: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan umpan balik.'
            ], 500);
        }
    }

    public function getRatingDetail($id)
    {
        $laporan = t_laporan::with('user', 'ruangan', 'fasilitas')
            ->where('laporan_id', $id)
            ->where('user_id', Auth::id()) // opsional, untuk batasi hanya yang buat bisa lihat
            ->first();

        if (!$laporan) {
            return response()->json([
                'success' => false,
                'message' => 'Data laporan tidak ditemukan'
            ], 404);
        }

        // Format tanggal helper
        $formatTanggal = fn($tgl) => $tgl
            ? \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('d F Y')
            : '-';

        // Riwayat status
        $riwayat = [];

        $riwayat[] = [
            'status'  => 'Baru',
            'icon'    => 'fa-flag text-gray-500',
            'tanggal' => $formatTanggal($laporan->lapor_datetime),
        ];

        if ($laporan->is_verified || $laporan->is_done) {
            $riwayat[] = [
                'status'  => 'Diproses',
                'icon'    => 'fa-spinner text-yellow-500',
                'tanggal' => $formatTanggal($laporan->verifikasi_datetime),
            ];
        }

        if ($laporan->is_done) {
            $status = $laporan->is_verified ? 'Selesai' : 'Ditolak';
            $icon = $laporan->is_verified ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600';
            $riwayat[] = [
                'status'  => $status,
                'icon'    => $icon,
                'tanggal' => $formatTanggal($laporan->verifikasi_datetime),
            ];
        }

        // Rating (dalam bentuk angka dan emoji)
        $rating = (int) $laporan->review_pelapor;
        $stars = str_repeat('⭐️', $rating) . str_repeat('☆', 5 - $rating);

        return response()->json([
            'success' => true,
            'data' => [
                'user_fullname'     => $laporan->user->fullname ?? '-',
                'ruangan_nama'      => $laporan->ruangan->ruangan_nama ?? '-',
                'fasilitas_nama'    => $laporan->fasilitas->fasilitas_nama ?? '-',
                'deskripsi_laporan' => $laporan->deskripsi_laporan ?? '-',
                'lapor_foto_url'    => $laporan->foto_url ?? asset('assets/profile/default.jpg'),
                'riwayat'           => $riwayat,
                'rating'            => $stars,
                'komentar'          => $laporan->review_komentar ?? '-',
            ]
        ]);
    }
}
