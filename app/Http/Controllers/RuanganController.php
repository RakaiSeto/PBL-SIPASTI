<?php

namespace App\Http\Controllers;

use App\Models\m_ruangan;
use Illuminate\Http\Request;
use App\Models\m_ruangan_role as RoleRuangan;

use Barryvdh\DomPDF\Facade\Pdf;


class RuanganController extends Controller
{
    public function index()
    {
        $roleRuangan = RoleRuangan::all();

        return view('admin.ruangan.index', compact('roleRuangan'));
    }

    public function exportPDF()
    {
        $ruangan = m_ruangan::select('ruangan_role_id', 'ruangan_nama', 'lantai')
            ->orderBy('ruangan_nama')
            ->with('ruangan_role')
            ->get();

        $pdf = Pdf::loadView('admin.ruangan.export_pdf', ['ruangan' => $ruangan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);

        return $pdf->stream('Data Ruangan ' . date('Y-m-d H:i:s') . '.pdf');
    }


}
