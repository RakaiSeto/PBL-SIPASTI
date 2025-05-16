<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('welcome');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');

// hanya jika belum login
Route::post('/login', [AuthController::class, 'doLogin']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout']);

// Group untuk Admin
Route::group(['middleware' => ['auth.refresh', 'role:Admin'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    });

    Route::get('/admin', function () {
        return view('admin.mahasiswa.index');
    });

    Route::get('/datapengguna', function () {
        return view('admin.datapengguna.index');
    });

    Route::get('/fasilitas', function () {
        return view('admin.fasilitas.index');
    });

    Route::get('/ruangan', function () {
        return view('admin.ruangan.index');
    });

});

// Route tambahan menuju admin (duplikat dashboard)
Route::get('/hai', function () {
    return view('admin.index');
});

// Group untuk Civitas
Route::group(['middleware' => ['auth.refresh', 'role:Civitas'], 'prefix' => 'civitas'], function () {
    Route::get('/', function () {
        return view('civitas.index');
    });

    Route::get('/laporkan', function () {
        return view('civitas.laporkan');
    });

    Route::get('/status', function () {
        return view('civitas.status');
    });

    Route::get('/rating', function () {
        return view('civitas.rating');
    });
});

Route::group(['middleware' => ['auth.refresh', 'role:Sarpras'], 'prefix' => 'sarpras'], function () {
    Route::get('/', function () {
        return view('sarpras.index');
    });

    Route::get('/kelolaLaporkan', function () {
        return view('sarpras.kelolaLaporan');
    });
});

// Group untuk Teknisi
Route::group(['middleware' => ['auth.refresh', 'role:Teknisi'], 'prefix' => 'teknisi'], function () {
    Route::get('/dashboard', function () {
        return view('teknisi.index');
    });

    Route::get('/tugas', function () {
        return view('teknisi.tugas');
    });

    Route::get('/riwayat', function () {
        return view('teknisi.riwayat');
    });

    Route::get('/admin/fasilitas', function () {
        return view('admin.fasilitas.index');
    });

 


    Route::get('/civitas', function () {
        return view('civitas.index');
    });

    Route::get('/civitas/laporkan', function () {
        return view('civitas.laporkan');
    });

    Route::get('/teknisi/dashboard', function () {
        return view('teknisi.index');
    });

    Route::get('/teknisi/tugas', function () {
        return view('teknisi.tugas');
    });

    Route::get('/teknisi/riwayat', function () {
        return view('teknisi.riwayat');
    });

    Route::get('/admin/ruangan', function () {
        return view('admin.ruangan.index');
    });


      Route::get('/civitas', function () {
        return view('civitas.index');
    });

    Route::get('/sarpras/kelolaLaporan', function () {
        return view('sarpras.kelolaLaporan');
    });

    Route::get('/teknisi/dashboard', function () {
        return view('teknisi.index');
    });

    Route::get('/teknisi/tugas', function () {
        return view('teknisi.tugas');
    });

    Route::get('/teknisi/riwayat', function () {
        return view('teknisi.riwayat');
    });

    Route::get('/admin/ruangan', function () {
        return view('admin.ruangan.index');
    });


});
