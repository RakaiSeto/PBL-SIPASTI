<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_ruangan;
use App\Models\t_fasilitas_ruang;

class CivitasController extends Controller
{
    public function laporkan()
    {
        $ruang = m_ruangan::all();
        $fasilitas = t_fasilitas_ruang::all();

        return view('civitas.laporkan', compact('ruang', 'fasilitas'));
    }
}
