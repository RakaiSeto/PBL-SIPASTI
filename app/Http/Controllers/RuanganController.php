<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_ruangan_role as RoleRuangan;

class RuanganController extends Controller
{
    public function index()
    {
        $roleRuangan = RoleRuangan::all();

        return view('admin.ruangan.index', compact('roleRuangan'));
    }
}
