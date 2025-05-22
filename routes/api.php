<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KelolaPengguna;
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
});