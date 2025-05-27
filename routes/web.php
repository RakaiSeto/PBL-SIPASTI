<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
// Halaman utama
Route::get('/', function () {
    return view('index');
})->name('home');

// Autentikasi
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::post('/update-profile', [ProfileController::class, 'update'])->name('profile.update');

// Group Admin
Route::group(['middleware' => ['auth.refresh', 'role:Admin'], 'prefix' => 'admin'], function () {

    Route::post('/update-profile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/ganti-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
// Route::post('/ganti-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');


    Route::get('/', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Route::get('/mahasiswa', function () {
    //     return view('admin.mahasiswa.index');
    // })->name('admin.mahasiswa');

    Route::get('/datapengguna', function () {
        return view('admin.datapengguna.index');
    })->name('admin.datapengguna');

    Route::get('/datarole', function () {
        return view('admin.datarole.index');
    })->name('admin.datarole');

    Route::get('datarole/export_pdf', [RoleController::class, 'exportPDF'])->name('admin.datarole.export_pdf');
    Route::get('datarole/export_excel', [RoleController::class, 'exportExcel'])->name('admin.datarole.export_excel');

    Route::get('datapengguna/export_pdf', [UserController::class, 'exportPDF'])->name('admin.datapengguna.export_pdf');
    Route::get('datapengguna/export_excel', [UserController::class, 'exportExcel'])->name('admin.datapengguna.export_excel');

    Route::get('fasilitas/export_pdf', [FasilitasController::class, 'exportPDF'])->name('admin.fasilitas.export_pdf');
    Route::get('fasilitas/export_excel', [FasilitasController::class, 'exportExcel'])->name('admin.fasilitas.export_excel');

    Route::get('/fasilitas', function () {
        return view('admin.fasilitas.index');
    })->name('admin.fasilitas');

    Route::get('/ruangan', function () {
        return view('admin.ruangan.index');
    })->name('admin.ruangan');

    Route::get('/roleruangan', function () {
        return view('admin.roleruangan.index');
    })->name('admin.roleruangan');

     Route::get('/ruanganfasilitas', function () {
        return view('admin.ruanganfasilitas.index');
    })->name('admin.ruanganfasilitas');

    Route::get('/laporanstatistik', function () {
        return view('admin.laporanstatistik.index');
    })->name('admin.laporanstatistik');

     Route::get('/datalaporan', function () {
        return view('admin.datalaporan.index');
    })->name('admin.datalaporan');

});

// Route tambahan admin (duplikat dashboard)
Route::get('/hai', function () {
    return view('admin.index');
})->name('admin.hai');

// Group Civitas
Route::group(['middleware' => ['auth.refresh', 'role:Civitas'], 'prefix' => 'civitas'], function () {
    Route::get('/', function () {
        return view('civitas.index');
    })->name('civitas.dashboard');

    Route::get('/laporkan', function () {
        return view('civitas.laporkan');
    })->name('civitas.laporkan');

    Route::get('/status', function () {
        return view('civitas.status');
    })->name('civitas.status');

    Route::get('/rating', function () {
        return view('civitas.rating');
    })->name('civitas.rating');
});

// Group Sarpras
Route::group(['middleware' => ['auth.refresh', 'role:Sarpras'], 'prefix' => 'sarpras'], function () {
    Route::get('/', function () {
        return view('sarpras.index');
    })->name('sarpras.dashboard');

    Route::get('/kelolaLaporan', function () {
        return view('sarpras.kelolaLaporan');
    })->name('sarpras.kelolaLaporan');

    Route::get('/proses_spk', function () {
        return view('sarpras.proses_spk');
    })->name('sarpras.proses_spk');

    Route::get('/statistik', function () {
        return view('sarpras.statistik');
    })->name('sarpras.statistik');

    Route::get('/status', function () {
        return view('sarpras.status');
    })->name('sarpras.status');

    Route::get('/tugaskan', function () {
        return view('sarpras.tugaskan');
    })->name('sarpras.tugaskan');

    Route::get('/rekomendasi', function () {
        return view('sarpras.rekomendasi');
    })->name('sarpras.rekomendasi');

    Route::get('/kategorisasi', function () {
        return view('sarpras.kategorisasi');
    })->name('sarpras.kategorisasi');
});

// Group Teknisi
Route::group(['middleware' => ['auth.refresh', 'role:Teknisi'], 'prefix' => 'teknisi'], function () {
    Route::get('/', function () {
        return view('teknisi.index');
    })->name('teknisi.dashboard');

    Route::get('/tugas', function () {
        return view('teknisi.tugas');
    })->name('teknisi.tugas');

    Route::get('/perbarui', function () {
        return view('teknisi.perbarui');
    })->name('teknisi.perbarui');

    Route::get('/riwayat', function () {
        return view('teknisi.riwayat');
    })->name('teknisi.riwayat');
});