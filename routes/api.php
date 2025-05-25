<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KelolaPengguna;
use App\Http\Controllers\Api\KelolaRole;
use App\Http\Controllers\Api\KelolaRuangan;
use App\Http\Controllers\Api\KelolaRuanganRole;
use App\Http\Controllers\Api\KelolaFasilitas;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/test', TestController::class);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth.refresh')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth.refresh.api', 'role.api:Admin']], function () {
    Route::post('/kelola-pengguna', [KelolaPengguna::class, 'list']);
    Route::put('/kelola-pengguna/{id}', [KelolaPengguna::class, 'update']);
    Route::get('/kelola-pengguna/{id}', [KelolaPengguna::class, 'detail']);
    Route::post('/kelola-pengguna/create', [KelolaPengguna::class, 'create']);
    Route::delete('/kelola-pengguna/{id}', [KelolaPengguna::class, 'delete']);
    
    Route::post('/kelola-role', [KelolaRole::class, 'list']);
    Route::put('/kelola-role/{id}', [KelolaRole::class, 'update']);
    Route::get('/kelola-role/{id}', [KelolaRole::class, 'detail']);
    Route::post('/kelola-role/create', [KelolaRole::class, 'create']);
    Route::delete('/kelola-role/{id}', [KelolaRole::class, 'delete']);

    Route::post('/kelola-ruangan', [KelolaRuangan::class, 'list']);
    Route::put('/kelola-ruangan/{id}', [KelolaRuangan::class, 'update']);
    Route::get('/kelola-ruangan/{id}', [KelolaRuangan::class, 'detail']);
    Route::post('/kelola-ruangan/create', [KelolaRuangan::class, 'create']);
    Route::delete('/kelola-ruangan/{id}', [KelolaRuangan::class, 'delete']);

    Route::post('/kelola-ruangan-role', [KelolaRuanganRole::class, 'list']);
    Route::put('/kelola-ruangan-role/{id}', [KelolaRuanganRole::class, 'update']);
    Route::get('/kelola-ruangan-role/{id}', [KelolaRuanganRole::class, 'detail']);
    Route::post('/kelola-ruangan-role/create', [KelolaRuanganRole::class, 'create']);
    Route::delete('/kelola-ruangan-role/{id}', [KelolaRuanganRole::class, 'delete']);

    Route::post('/kelola-fasilitas', [KelolaFasilitas::class, 'list']);
    Route::put('/kelola-fasilitas/{id}', [KelolaFasilitas::class, 'update']);
    Route::get('/kelola-fasilitas/{id}', [KelolaFasilitas::class, 'detail']);
    Route::post('/kelola-fasilitas/create', [KelolaFasilitas::class, 'create']);
    Route::delete('/kelola-fasilitas/{id}', [KelolaFasilitas::class, 'delete']);
});
