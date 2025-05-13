<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
});

// Group untuk Admin
// Route::middleware('auth.refresh')->prefix('admin')->group(function () {
Route::prefix('admin')->group(function () {
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
Route::prefix('civitas')->group(function () {
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

// Group untuk Teknisi
Route::prefix('teknisi')->group(function () {
    Route::get('/dashboard', function () {
        return view('teknisi.index');
    });

    Route::get('/tugas', function () {
        return view('teknisi.tugas');
    });

    Route::get('/riwayat', function () {
        return view('teknisi.riwayat');
    });
});