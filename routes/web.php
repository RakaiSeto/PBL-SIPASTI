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



Route::get('/admin/mahasiswa', function () {
    return view('admin.mahasiswa.index');
});



Route::get('/admin/sarpras', function () {
    return view('admin.sarpras.index');
});

Route::get('/admin/teknisi', function () {
    return view('admin.teknisi.index');
});

Route::get('/admin/dosen', function () {
    return view('admin.dosen.index');
});

Route::get('/admin/fasilitas', function () {
    return view('admin.fasilitas.index');
});

Route::get('/admin/gedung', function () {
    return view('admin.gedung.index');
});
