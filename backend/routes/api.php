<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AnggotaMutasiController;
use App\Http\Controllers\AnggotaUkController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\GlController;
use App\Http\Controllers\KasPetugasController;
use App\Http\Controllers\KatgoriParController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KotKabController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\ListKodeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PrdDepositoController;
use App\Http\Controllers\PrdPembiayaanController;
use App\Http\Controllers\PrdTabunganController;
use App\Http\Controllers\RembugController;
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

Route::prefix('kaspetugas')->middleware('checkToken')->group(function () {
  Route::post('/create', [KasPetugasController::class, 'create']);
  Route::post('/read', [KasPetugasController::class, 'read']);
  Route::get('/detail', [KasPetugasController::class, 'detail']);
  Route::post('/update', [KasPetugasController::class, 'update']);
  Route::get('/delete', [KasPetugasController::class, 'delete']);
});

Route::prefix('rembug')->middleware('checkToken')->group(function () {
  Route::post('/create', [RembugController::class, 'create']);
  Route::post('/read', [RembugController::class, 'read']);
  Route::get('/detail', [RembugController::class, 'detail']);
  Route::post('/update', [RembugController::class, 'update']);
  Route::get('/delete', [RembugController::class, 'delete']);
});

Route::prefix('anggota')->middleware('checkToken')->group(function () {
  Route::post('/create', [AnggotaController::class, 'create']);
  Route::post('/read', [AnggotaController::class, 'read']);
  Route::get('/detail', [AnggotaController::class, 'detail']);
  Route::post('/update', [AnggotaController::class, 'update']);
  Route::get('/delete', [AnggotaController::class, 'delete']);
});

Route::prefix('anggotauk')->middleware('checkToken')->group(function () {
  Route::post('/create', [AnggotaUkController::class, 'create']);
  Route::post('/read', [AnggotaUkController::class, 'read']);
  Route::get('/detail', [AnggotaUkController::class, 'detail']);
  Route::post('/update', [AnggotaUkController::class, 'update']);
  Route::get('/delete', [AnggotaUkController::class, 'delete']);
});

Route::prefix('anggotamutasi')->middleware('checkToken')->group(function () {
  Route::post('/create', [AnggotaMutasiController::class, 'create']);
  Route::post('/read', [AnggotaMutasiController::class, 'read']);
  Route::get('/detail', [AnggotaMutasiController::class, 'detail']);
  Route::post('/update', [AnggotaMutasiController::class, 'update']);
  Route::get('/delete', [AnggotaMutasiController::class, 'delete']);
});

Route::prefix('katgoripar')->middleware('checkToken')->group(function () {
  Route::post('/create', [KatgoriParController::class, 'create']);
  Route::post('/read', [KatgoriParController::class, 'read']);
  Route::get('/detail', [KatgoriParController::class, 'detail']);
  Route::post('/update', [KatgoriParController::class, 'update']);
  Route::get('/delete', [KatgoriParController::class, 'delete']);
});

Route::prefix('lembaga')->middleware('checkToken')->group(function () {
  Route::post('/create', [LembagaController::class, 'create']);
  Route::post('/read', [LembagaController::class, 'read']);
  Route::get('/detail', [LembagaController::class, 'detail']);
  Route::post('/update', [LembagaController::class, 'update']);
  Route::get('/delete', [LembagaController::class, 'delete']);
});

Route::prefix('listkode')->middleware('checkToken')->group(function () {
  Route::post('/create', [ListKodeController::class, 'create']);
  Route::post('/read', [ListKodeController::class, 'read']);
  Route::get('/detail', [ListKodeController::class, 'detail']);
  Route::post('/update', [ListKodeController::class, 'update']);
  Route::get('/delete', [ListKodeController::class, 'delete']);
});

Route::prefix('prddeposito')->middleware('checkToken')->group(function () {
  Route::post('/create', [PrdDepositoController::class, 'create']);
  Route::post('/read', [PrdDepositoController::class, 'read']);
  Route::get('/detail', [PrdDepositoController::class, 'detail']);
  Route::post('/update', [PrdDepositoController::class, 'update']);
  Route::get('/delete', [PrdDepositoController::class, 'delete']);
});

Route::prefix('prdpembiayaan')->middleware('checkToken')->group(function () {
  Route::post('/create', [PrdPembiayaanController::class, 'create']);
  Route::post('/read', [PrdPembiayaanController::class, 'read']);
  Route::get('/detail', [PrdPembiayaanController::class, 'detail']);
  Route::post('/update', [PrdPembiayaanController::class, 'update']);
  Route::get('/delete', [PrdPembiayaanController::class, 'delete']);
});

Route::prefix('prdtabungan')->middleware('checkToken')->group(function () {
  Route::post('/create', [PrdTabunganController::class, 'create']);
  Route::post('/read', [PrdTabunganController::class, 'read']);
  Route::get('/detail', [PrdTabunganController::class, 'detail']);
  Route::post('/update', [PrdTabunganController::class, 'update']);
  Route::get('/delete', [PrdTabunganController::class, 'delete']);
});
