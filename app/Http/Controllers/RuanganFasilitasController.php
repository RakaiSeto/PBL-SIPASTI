<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_ruangan as Ruangan;
use App\Models\m_fasilitas as Fasilitas;

class RuanganFasilitasController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();
        $fasilitas = Fasilitas::all();

        return view('admin.ruanganfasilitas.index', compact('ruangan', 'fasilitas'));
    }
}
