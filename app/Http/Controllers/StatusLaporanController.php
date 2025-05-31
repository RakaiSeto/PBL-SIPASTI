<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\t_laporan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StatusLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Hanya pengguna yang login
    }

    public function index()
    {
        return view('civitas.status-laporan.index');
    }

    public function list(Request $request)
    {
        try {
            $columns = [
                0 => 'laporan_id',
                1 => 'fasilitas_ruang_id',
                2 => 'fasilitas_ruang_id',
                3 => 'lapor_datetime',
                4 => 'is_verified',
            ];

            $totalData = t_laporan::where('user_id', Auth::id())->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length', 5);
            $start = $request->input('start', 0);
            $orderColumn = $columns[$request->input('order.0.column', 3)];
            $orderDir = $request->input('order.0.dir', 'desc');

            $query = t_laporan::select(
                'laporan_id',
                'fasilitas_ruang_id',
                'deskripsi_laporan',
                'lapor_datetime',
                'is_verified',
                'is_done'
            )->where('user_id', Auth::id());

            // Filter fasilitas
            if ($request->has('fasilitas') && !empty($request->fasilitas)) {
                $query->where('fasilitas_ruang_id', 'like', '%' . $request->fasilitas . '%');
            }

            // Pencarian deskripsi
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
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
                    'is_verified' => $laporan->is_verified,
                    'is_done' => $laporan->is_done,
                ];
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil list status laporan: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $laporan = t_laporan::select(
                'laporan_id',
                'fasilitas_ruang_id',
                'deskripsi_laporan',
                'lapor_datetime',
                'is_verified',
                'is_done',
                'lapor_foto'
            )->where('user_id', Auth::id())->findOrFail($id);

            $laporan->lapor_foto_url = $laporan->lapor_foto ? asset('storage/laporan/' . $laporan->laporan_id . '.jpg') : null;

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
            Log::error('Gagal mengambil detail status laporan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }
}
