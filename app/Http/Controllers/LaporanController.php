<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\t_laporan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                0 => 't_laporan.fasilitas_ruang_id',
                1 => 'jumlah_laporan',
                2 => 'oldest_lapor_datetime',
                3 => 'ruangan_nama',
                4 => 'fasilitas_nama',
            ];

            $status = $request->input('status', 'pending'); // Default ke 'pending' jika tidak ada parameter

            $query = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
                ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
                ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
                ->leftJoin('m_user', 't_laporan.user_id', '=', 'm_user.user_id')
                ->select(
                    't_laporan.laporan_id',
                    't_fasilitas_ruang.fasilitas_ruang_id',
                    DB::raw('count(*) as jumlah_laporan'),
                    DB::raw('MIN(t_laporan.lapor_datetime) as oldest_lapor_datetime'),
                    'm_ruangan.ruangan_nama as ruangan_nama',
                    'm_fasilitas.fasilitas_nama as fasilitas_nama',
                    'm_user.fullname as user_nama',
                    't_laporan.lapor_datetime as lapor_datetime',
                    't_laporan.deskripsi_laporan as deskripsi_laporan',
                    't_laporan.is_verified as is_verified',
                    't_laporan.is_done as is_done'
                )
                ->groupBy(
                    't_laporan.laporan_id',
                    't_fasilitas_ruang.fasilitas_ruang_id',
                    'm_ruangan.ruangan_nama',
                    'm_fasilitas.fasilitas_nama',
                    'm_user.fullname',
                    't_laporan.lapor_datetime',
                    't_laporan.deskripsi_laporan'
                );

            $totalData = $query->count();

            // Filter berdasarkan status
            if ($status === 'pending') {
                $query->where('t_laporan.is_verified', 0)->where('t_laporan.is_done', 0);
            } elseif ($status === 'processed') {
                $query->where('t_laporan.is_verified', 1)->where('t_laporan.is_done', 0); // Hanya diproses (is_verified = 1, is_done = 0)
            } elseif ($status === 'completed') {
                $query->where('t_laporan.is_verified', 1)->where('t_laporan.is_done', 1); // Selesai
            } elseif ($status === 'rejected') {
                $query->where('t_laporan.is_verified', 0)->where('t_laporan.is_done', 1); // Ditolak
            } elseif ($status === 'completed,rejected') {
                $query->where('t_laporan.is_done', 1); // Selesai dan Ditolak
            }

            // Filter fasilitas
            if ($request->has('fasilitas') && !empty($request->fasilitas)) {
                $query->where('t_fasilitas_ruang.fasilitas_ruang_id', 'like', '%' . $request->fasilitas . '%');
            }

            $totalFiltered = $query->count();

            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumn = $columns[$request->input('order.0.column', 2)]; // Default to oldest_lapor_datetime
            $orderDir = $request->input('order.0.dir', 'desc');

            $query->offset($start)
                ->limit($limit)
                ->orderBy($orderColumn, $orderDir);

            $laporans = $query->get();

            $data = [];
            foreach ($laporans as $laporan) {
                $status = 'pending';
                if ($laporan->is_verified == 1 && $laporan->is_done == 0) {
                    $status = 'processed';
                } else if ($laporan->is_verified == 1 && $laporan->is_done == 1) {
                    $status = 'completed';
                } else if ($laporan->is_verified == 0 && $laporan->is_done == 1) {
                    $status = 'rejected';
                }
                $data[] = [
                    'laporan_id' => $laporan->laporan_id,
                    'fasilitas_ruang_id' => $laporan->fasilitas_ruang_id,
                    'ruangan_nama' => $laporan->ruangan_nama,
                    'fasilitas_nama' => $laporan->fasilitas_nama,
                    'jumlah_laporan' => $laporan->jumlah_laporan,
                    'oldest_lapor_datetime' => $laporan->oldest_lapor_datetime,
                    'user_nama' => $laporan->user_nama,
                    'lapor_datetime' => $laporan->lapor_datetime,
                    'deskripsi_laporan' => $laporan->deskripsi_laporan,
                    'status' => $status,
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

    public function listAll(Request $request)
    {
        try {
            $columns = [
                0 => 't_laporan.fasilitas_ruang_id',
                1 => 'jumlah_laporan',
                2 => 'oldest_lapor_datetime',
                3 => 'ruangan_nama',
                4 => 'fasilitas_nama',
            ];

            $query = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
                ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
                ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
                ->leftJoin('m_user', 't_laporan.user_id', '=', 'm_user.user_id')
                ->select(
                    't_laporan.laporan_id',
                    't_fasilitas_ruang.fasilitas_ruang_id',
                    DB::raw('count(*) as jumlah_laporan'),
                    DB::raw('MIN(t_laporan.lapor_datetime) as oldest_lapor_datetime'),
                    'm_ruangan.ruangan_nama as ruangan_nama',
                    'm_fasilitas.fasilitas_nama as fasilitas_nama',
                    'm_user.fullname as user_nama',
                    't_laporan.lapor_datetime as lapor_datetime',
                    't_laporan.deskripsi_laporan as deskripsi_laporan',
                    't_laporan.is_verified as is_verified',
                    't_laporan.is_done as is_done'
                )
                ->groupBy(
                    't_laporan.laporan_id',
                    't_fasilitas_ruang.fasilitas_ruang_id',
                    'm_ruangan.ruangan_nama',
                    'm_fasilitas.fasilitas_nama',
                    'm_user.fullname',
                    't_laporan.lapor_datetime',
                    't_laporan.deskripsi_laporan'
                );

            $queryNew = $query;

            $totalData = count($queryNew->get()->toArray());
            
            // Filter fasilitas
            if ($request->has('fasilitas') && !empty($request->fasilitas)) {
                $query->where('t_fasilitas_ruang.fasilitas_ruang_id', 'like', '%' . $request->fasilitas . '%');
            }

            $totalFiltered = count($query->get()->toArray());

            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumn = $columns[$request->input('order.0.column', 2)]; // Default to oldest_lapor_datetime

            $query->offset($start)
                ->limit($limit)
                ->orderBy('t_laporan.lapor_datetime', 'desc');

            $laporans = $query->get();

            $data = [];
            foreach ($laporans as $laporan) {
                $status = 'pending';
                
                if ($laporan->is_verified == 1 && $laporan->is_done == 0) {
                    if ($laporan->is_kerjakan == 1) {
                        $status = 'kerjakan';
                    } else {
                        $status = 'processed';
                    }
                } else if ($laporan->is_verified == 1 && $laporan->is_done == 1) {
                    $status = 'completed';
                } else if ($laporan->is_verified == 0 && $laporan->is_done == 1) {
                    $status = 'rejected';
                }
                $data[] = [
                    'laporan_id' => $laporan->laporan_id,
                    'fasilitas_ruang_id' => $laporan->fasilitas_ruang_id,
                    'ruangan_nama' => $laporan->ruangan_nama,
                    'fasilitas_nama' => $laporan->fasilitas_nama,
                    'jumlah_laporan' => $laporan->jumlah_laporan,
                    'oldest_lapor_datetime' => $laporan->oldest_lapor_datetime,
                    'user_nama' => $laporan->user_nama,
                    'lapor_datetime' => $laporan->lapor_datetime,
                    'deskripsi_laporan' => $laporan->deskripsi_laporan,
                    'status' => $status,
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

    public function listTeknisi(Request $request)
    {
        try {
            $columns = [
                0 => 't_laporan.fasilitas_ruang_id',
                1 => 'jumlah_laporan',
                2 => 'oldest_lapor_datetime',
                3 => 'ruangan_nama',
                4 => 'fasilitas_nama',
            ];

            $query = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
                ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
                ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
                ->leftJoin('m_user', 't_laporan.user_id', '=', 'm_user.user_id')
                ->where('t_laporan.teknisi_id', Auth::user()->user_id);

            $status = $request->input('status', 'pending');
            if ($status == 'kerjakan') {
                $query->where('t_laporan.is_kerjakan', 1)->where('t_laporan.is_done', 0);
            } else if ($status == 'done') {
                $query->where('t_laporan.is_done', 1)->where('t_laporan.is_kerjakan', 1);
            } else {
                $query->where('t_laporan.is_done', 0)->where('t_laporan.is_kerjakan', null);
            }

            $query->select(
                't_laporan.laporan_id',
                't_fasilitas_ruang.fasilitas_ruang_id',
                DB::raw('count(*) as jumlah_laporan'),
                DB::raw('MIN(t_laporan.lapor_datetime) as oldest_lapor_datetime'),
                'm_ruangan.ruangan_nama as ruangan_nama',
                'm_fasilitas.fasilitas_nama as fasilitas_nama',
                'm_user.fullname as user_nama',
                't_laporan.lapor_datetime as lapor_datetime',
                't_laporan.deskripsi_laporan as deskripsi_laporan',
                't_laporan.is_verified as is_verified',
                't_laporan.is_done as is_done',
                't_laporan.is_kerjakan as is_kerjakan',
                't_laporan.selesai_datetime as selesai_datetime'
            )
            ->groupBy(
                't_laporan.laporan_id',
                't_fasilitas_ruang.fasilitas_ruang_id',
                'm_ruangan.ruangan_nama',
                'm_fasilitas.fasilitas_nama',
                'm_user.fullname',
                't_laporan.lapor_datetime',
                't_laporan.deskripsi_laporan'
            );

            $queryNew = $query;

            $totalData = count($queryNew->get()->toArray());
            
            // Filter fasilitas
            if ($request->has('fasilitas') && !empty($request->fasilitas)) {
                $query->where('t_fasilitas_ruang.fasilitas_ruang_id', 'like', '%' . $request->fasilitas . '%');
            }

            $totalFiltered = count($query->get()->toArray());

            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumn = $columns[$request->input('order.0.column', 2)]; // Default to oldest_lapor_datetime

            $query->offset($start)
                ->limit($limit)
                ->orderBy('t_laporan.lapor_datetime', 'desc');

            $laporans = $query->get();

            $data = [];
            foreach ($laporans as $laporan) {
                $status = 'pending';
                if ($laporan->is_verified == 1 && $laporan->is_done == 0) {
                    if ($laporan->is_kerjakan == 1) {
                        $status = 'kerjakan';
                    } else {
                        $status = 'processed';
                    }
                } else if ($laporan->is_verified == 1 && $laporan->is_done == 1) {
                    $status = 'completed';
                } else if ($laporan->is_verified == 0 && $laporan->is_done == 1) {
                    $status = 'rejected';
                }
                $data[] = [
                    'laporan_id' => $laporan->laporan_id,
                    'fasilitas_ruang_id' => $laporan->fasilitas_ruang_id,
                    'ruangan_nama' => $laporan->ruangan_nama,
                    'fasilitas_nama' => $laporan->fasilitas_nama,
                    'jumlah_laporan' => $laporan->jumlah_laporan,
                    'oldest_lapor_datetime' => $laporan->oldest_lapor_datetime,
                    'user_nama' => $laporan->user_nama,
                    'lapor_datetime' => $laporan->lapor_datetime,
                    'selesai_datetime' => $laporan->selesai_datetime,
                    'deskripsi_laporan' => $laporan->deskripsi_laporan,
                    'status' => $status,
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

    public function listKategorisasi(Request $request)
    {
        try {
            $columns = [
                0 => 'fasilitas_ruang_id',
                1 => 'jumlah_laporan',
                2 => 'oldest_lapor_datetime',
                3 => 'ruangan_nama',
                4 => 'fasilitas_nama',
            ];

            $status = $request->input('status', 'pending'); // Default ke 'pending' jika tidak ada parameter

            $query = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
                ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
                ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
                ->where('t_laporan.is_verified', 1)
                ->where('t_laporan.is_done', 0)
                ->where('spk_kerusakan', null)
                ->where('spk_dampak', null)
                ->where('spk_frekuensi', null)
                ->where('spk_waktu_perbaikan', null)
                ->select(
                    't_fasilitas_ruang.fasilitas_ruang_id',
                    DB::raw('count(*) as jumlah_laporan'),
                    DB::raw('MIN(t_laporan.lapor_datetime) as oldest_lapor_datetime'),
                    'm_ruangan.ruangan_nama as ruangan_nama',
                    'm_fasilitas.fasilitas_nama as fasilitas_nama'
                )
                ->groupBy(
                    't_fasilitas_ruang.fasilitas_ruang_id',
                    'm_ruangan.ruangan_nama',
                    'm_fasilitas.fasilitas_nama'
                );

            $totalData = $query->count();

            // Filter berdasarkan status
            if ($status === 'pending') {
                $query->where('t_laporan.is_verified', 0)->where('t_laporan.is_done', 0);
            } elseif ($status === 'processed') {
                $query->where('t_laporan.is_verified', 1)->where('t_laporan.is_done', 0); // Hanya diproses (is_verified = 1, is_done = 0)
            } elseif ($status === 'completed') {
                $query->where('t_laporan.is_verified', 1)->where('t_laporan.is_done', 1); // Selesai
            } elseif ($status === 'rejected') {
                $query->where('t_laporan.is_verified', 0)->where('t_laporan.is_done', 1); // Ditolak
            } elseif ($status === 'completed,rejected') {
                $query->where('t_laporan.is_done', 1); // Selesai dan Ditolak
            }

            // Filter fasilitas
            if ($request->has('fasilitas') && !empty($request->fasilitas)) {
                $query->where('t_fasilitas_ruang.fasilitas_ruang_id', 'like', '%' . $request->fasilitas . '%');
            }

            $totalFiltered = $query->count();

            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumn = $columns[$request->input('order.0.column', 2)]; // Default to oldest_lapor_datetime
            $orderDir = $request->input('order.0.dir', 'desc');

            $laporans = $query->offset($start)
                ->limit($limit)
                ->orderBy($orderColumn, $orderDir)
                ->get();

            $data = [];
            foreach ($laporans as $laporan) {
                $data[] = [
                    'fasilitas_ruang_id' => $laporan->fasilitas_ruang_id,
                    'ruangan_nama' => $laporan->ruangan_nama,
                    'fasilitas_nama' => $laporan->fasilitas_nama,
                    'jumlah_laporan' => $laporan->jumlah_laporan,
                    'oldest_lapor_datetime' => $laporan->oldest_lapor_datetime,
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
            $laporan = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
                ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
                ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
                ->leftJoin('m_user', 't_laporan.user_id', '=', 'm_user.user_id')
                ->select(
                    'laporan_id',
                    't_laporan.user_id',
                    't_fasilitas_ruang.fasilitas_ruang_id',
                    'deskripsi_laporan',
                    'verifikasi_datetime',
                    'selesai_datetime',
                    'lapor_datetime',
                    'is_verified',
                    'is_done',
                    'm_ruangan.ruangan_nama as ruangan_nama',
                    'm_fasilitas.fasilitas_nama as fasilitas_nama',
                    'm_user.fullname as user_nama',
                    't_laporan.lapor_foto as lapor_foto'
                )->where('t_fasilitas_ruang.fasilitas_ruang_id', $id)
                ->where('t_laporan.is_verified', 1)
                ->where('t_laporan.is_done', 0)
                ->where('spk_kerusakan', null)
                ->where('spk_dampak', null)
                ->where('spk_frekuensi', null)
                ->where('spk_waktu_perbaikan', null)
                ->get();

            foreach ($laporan as $item) {
                // Check if lapor_foto content exists in the database record
                if ($item->lapor_foto) {
                    $filePath = 'laporan/' . $item->laporan_id . '.jpg';
                    // Use Laravel's asset helper to generate the full URL
                    $item->lapor_foto_url = asset('storage/' . $filePath);

                    if (!Storage::disk('public')->exists('laporan/' . $item->laporan_id . '.jpg')) {
                        // Laravel's Storage facade automatically creates parent directories if they don't exist.
                        Storage::disk('public')->put($filePath, $item->lapor_foto);
                    }

                    $item->lapor_foto = null;
                }
            }

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

    public function detail($id)
    {
        $laporan = t_laporan::with('user', 'fasilitas_ruang.ruangan', 'fasilitas_ruang.fasilitas')->where('laporan_id', $id)->first();
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
    }

    public function kerjakan($id)
    {
        $laporan = t_laporan::findOrFail($id, 'laporan_id');
        $laporan->is_kerjakan = 1;
        $laporan->save();

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikerjakan'
        ]);
    }

    public function selesai($id)
    {
        $laporan = t_laporan::findOrFail($id, 'laporan_id');
        $laporan->is_done = 1;
        $laporan->selesai_datetime = now();
        $laporan->save();

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil diselesaikan'
        ]);
    }

    public function verify($id)
    {
        try {
            $laporan = t_laporan::findOrFail($id);
            $laporan->is_verified = 1;
            $laporan->verifikasi_datetime = now();
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
            $laporan->selesai_datetime = now();
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
            $laporan->selesai_datetime = now();
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

    public function penilaian(Request $request)
    {

        try {
            $fasilitas_ruang_id = t_laporan::where('laporan_id', $request->laporan_id)->first()->fasilitas_ruang_id;

            $laporans = t_laporan::where('fasilitas_ruang_id', $fasilitas_ruang_id)
                ->where('is_verified', 1)
                ->where('teknisi_id', null)
                ->where('is_done', 0)
                ->get();

            foreach ($laporans as $laporan) {
                $laporan->spk_kerusakan = $request->kerusakan;
                $laporan->spk_dampak = $request->dampak;
                $laporan->spk_frekuensi = $request->frekuensi;
                $laporan->spk_waktu_perbaikan = $request->waktu_perbaikan;
                $laporan->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Penilaian berhasil disimpan'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan penilaian: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan penilaian'
            ], 500);
        }
    }
}
