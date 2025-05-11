<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/home', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/admin/dashboard', function () {
    return view('admin.index');
});

Route::get('/hai', function () {
    return view('admin.index');
});



Route::get('/admin/admin', function () {
    return view('admin.mahasiswa.index');
});


Route::get('/admin/datapengguna', function () {
    return view('admin.datapengguna.index');
});

Route::get('/admin/fasilitas', function () {
    return view('admin.fasilitas.index');
});

Route::get('/admin/ruangan', function () {
    return view('admin.ruangan.index');
});

Route::get('/civitas', function () {
    return view('civitas.index');
});

Route::get('/civitas/laporkan', function () {
    return view('civitas.laporkan');
});

Route::get('/civitas/status', function () {
    return view('civitas.status');
});

Route::get('/civitas/rating', function () {
    return view('civitas.rating');
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
