<?php

namespace App\Http\Controllers;

use App\Models\m_user;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{
    public function exportPDF()
    {
        // Ambil data pengguna beserta relasi role
        $pengguna = m_user::select('fullname', 'username', 'email', 'role_id')
            ->orderBy('fullname')
            ->with('role') // pastikan relasi role ada di model User
            ->get();

        // Load view untuk PDF dan kirim data pengguna
        $pdf = Pdf::loadView('admin.datapengguna.export_pdf', ['pengguna' => $pengguna]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);

        return $pdf->stream('Data Pengguna ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
