<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\t_laporan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // public function __construct()
    // {
    //     $$this->middleware(['auth', 'role:Admin|Sarpras']);
    // }

    public function index()
    {
        return view('sarpras.laporan.index');
    }

    public function list(Request $request)
    {
        try {
            $columns = [
                0 => 'laporan_id',
                1 => 'user_id',
                2 => 'fasilitas_ruang_id',
                3 => 'fasilitas_ruang_id',
                4 => 'deskripsi_laporan',
                5 => 'lapor_datetime',
                6 => 'is_verified',
            ];

            $status = $request->input('status', 'pending'); // Default ke 'pending' jika tidak ada parameter

            $query = t_laporan::select(
                'laporan_id',
                'user_id',
                'fasilitas_ruang_id',
                'deskripsi_laporan',
                'lapor_datetime',
                'is_verified',
                'is_done'
            );

            // Filter berdasarkan status
            if ($status === 'pending') {
                $query->where('is_verified', 0)->where('is_done', 0);
            } elseif ($status === 'processed') {
                $query->where('is_verified', 1)->where('is_done', 0); // Hanya diproses (is_verified = 1, is_done = 0)
            } elseif ($status === 'completed') {
                $query->where('is_verified', 1)->where('is_done', 1); // Selesai
            } elseif ($status === 'rejected') {
                $query->where('is_verified', 0)->where('is_done', 1); // Ditolak
            } elseif ($status === 'completed,rejected') {
                $query->where('is_done', 1); // Selesai dan Ditolak
            }

            $totalData = $query->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumn = $columns[$request->input('order.0.column', 4)];
            $orderDir = $request->input('order.0.dir', 'desc');

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
                    'user_id' => $laporan->user_id,
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
            Log::error('Gagal mengambil list laporan: ' . $e->getMessage());
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
                'user_id',
                'fasilitas_ruang_id',
                'deskripsi_laporan',
                'lapor_datetime',
                'is_verified',
                'is_done'
            )->findOrFail($id);

            $laporan->lapor_foto_url = $laporan->lapor_foto ? asset('storage/laporan/' . $laporan->laporan_id . '.jpg') : null;

            return response()->json([
                'success' => true,
                'data' => $laporan
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil detail laporan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    public function verify($id)
    {
        try {
            $laporan = t_laporan::findOrFail($id);
            $laporan->is_verified = 1;
            $laporan->save();

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil diverifikasi'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Gagal memverifikasi laporan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memverifikasi laporan'
            ], 500);
        }
    }

    public function complete($id)
    {
        try {
            $laporan = t_laporan::findOrFail($id);
            $laporan->is_verified = 1;
            $laporan->is_done = 1;
            $laporan->save();

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil diselesaikan'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Gagal menyelesaikan laporan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyelesaikan laporan'
            ], 500);
        }
    }

    public function reject($id)
    {
        try {
            $laporan = t_laporan::findOrFail($id);
            if ($laporan->is_verified || $laporan->is_done) {
                return response()->json([
                    'success' => false,
                    'message' => 'Laporan sudah diverifikasi atau selesai dan tidak dapat ditolak'
                ], 422);
            }

            $laporan->is_done = true;
            $laporan->is_verified = false;
            $laporan->save();

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil ditolak'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Gagal menolak laporan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak laporan'
            ], 500);
        }
    }
}
