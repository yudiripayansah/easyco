<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\GlController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KotKabController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('authenticate')->group(function () {
  Route::post('/login', [AuthController::class, 'authentication']);
});

Route::prefix('cabang')->middleware('checkToken')->group(function () {
  Route::post('/create', [CabangController::class, 'create']);
  Route::post('/read', [CabangController::class, 'read']);
  Route::get('/detail', [CabangController::class, 'detail']);
  Route::post('/update', [CabangController::class, 'update']);
  Route::get('/delete', [CabangController::class, 'delete']);
});

Route::prefix('pegawai')->middleware('checkToken')->group(function () {
  Route::post('/create', [PegawaiController::class, 'create']);
  Route::post('/read', [PegawaiController::class, 'read']);
  Route::get('/detail', [PegawaiController::class, 'detail']);
  Route::post('/update', [PegawaiController::class, 'update']);
  Route::get('/delete', [PegawaiController::class, 'delete']);
});

Route::prefix('user')->middleware('checkToken')->group(function () {
  Route::post('/create', [UserController::class, 'create']);
  Route::post('/read', [UserController::class, 'read']);
  Route::get('/detail', [UserController::class, 'detail']);
  Route::post('/update', [UserController::class, 'update']);
  Route::get('/delete', [UserController::class, 'delete']);
});

Route::prefix('kotakab')->middleware('checkToken')->group(function () {
  Route::post('/create', [KotKabController::class, 'create']);
  Route::post('/read', [KotKabController::class, 'read']);
  Route::get('/detail', [KotKabController::class, 'detail']);
  Route::post('/update', [KotKabController::class, 'update']);
  Route::get('/delete', [KotKabController::class, 'delete']);
});

Route::prefix('kecamatan')->middleware('checkToken')->group(function () {
  Route::post('/create', [KecamatanController::class, 'create']);
  Route::post('/read', [KecamatanController::class, 'read']);
  Route::get('/detail', [KecamatanController::class, 'detail']);
  Route::post('/update', [KecamatanController::class, 'update']);
  Route::get('/delete', [KecamatanController::class, 'delete']);
});

Route::prefix('desa')->middleware('checkToken')->group(function () {
  Route::post('/create', [DesaController::class, 'create']);
  Route::post('/read', [DesaController::class, 'read']);
  Route::get('/detail', [DesaController::class, 'detail']);
  Route::post('/update', [DesaController::class, 'update']);
  Route::get('/delete', [DesaController::class, 'delete']);
});

Route::prefix('gl')->middleware('checkToken')->group(function () {
  Route::post('/create', [GlController::class, 'create']);
  Route::post('/read', [GlController::class, 'read']);
  Route::get('/detail', [GlController::class, 'detail']);
  Route::post('/update', [GlController::class, 'update']);
  Route::get('/delete', [GlController::class, 'delete']);
});
