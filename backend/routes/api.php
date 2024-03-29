<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AnggotaMutasiController;
use App\Http\Controllers\AnggotaUkController;
use App\Http\Controllers\AnggotaUser;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ClosingGlController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\GlController;
use App\Http\Controllers\KasPetugasController;
use App\Http\Controllers\KatgoriParController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KotKabController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\ListKodeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ParController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PrdDepositoController;
use App\Http\Controllers\PrdPembiayaanController;
use App\Http\Controllers\PrdTabunganController;
use App\Http\Controllers\RegistrasiAkadController;
use App\Http\Controllers\RembugController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TplController;
use App\Http\Controllers\TrxAnggota;
use App\Http\Controllers\TrxGl;
use App\Http\Controllers\TrxRembug;
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

/* BEGIN BACK OFFICE */

Route::prefix('authenticate')->group(function () {
  Route::post('/login', [AuthController::class, 'authentication']);
});

Route::prefix('dashboard')->middleware('checkToken')->group(function () {
  Route::get('/saldosaldo', [AnggotaController::class, 'saldosaldo']);
});

Route::prefix('cabang')->middleware('checkToken')->group(function () {
  Route::post('/create', [CabangController::class, 'create']);
  Route::post('/read', [CabangController::class, 'read']);
  Route::get('/detail', [CabangController::class, 'detail']);
  Route::get('/dashboard', [CabangController::class, 'dashboard']);
  Route::post('/update', [CabangController::class, 'update']);
  Route::get('/delete', [CabangController::class, 'delete']);
});

Route::prefix('pegawai')->middleware('checkToken')->group(function () {
  Route::post('/generate', [PegawaiController::class, 'generate_kode_pegawai']);
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
  Route::post('/generate', [KecamatanController::class, 'generate_kode_kecamatan']);
  Route::post('/create', [KecamatanController::class, 'create']);
  Route::post('/read', [KecamatanController::class, 'read']);
  Route::get('/detail', [KecamatanController::class, 'detail']);
  Route::post('/update', [KecamatanController::class, 'update']);
  Route::get('/delete', [KecamatanController::class, 'delete']);
});

Route::prefix('desa')->middleware('checkToken')->group(function () {
  Route::post('/generate', [DesaController::class, 'generate_kode_desa']);
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
  Route::post('/generate', [RembugController::class, 'generate_kode_rembug']);
  Route::post('/read', [RembugController::class, 'read']);
  Route::get('/detail', [RembugController::class, 'detail']);
  Route::post('/update', [RembugController::class, 'update']);
  Route::get('/delete', [RembugController::class, 'delete']);
});

Route::prefix('anggota')->middleware('checkToken')->group(function () {
  Route::post('/rembug', [AnggotaController::class, 'rembug']);
  Route::get('/simpanan_anggota', [AnggotaController::class, 'simpanan_anggota']);
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
  Route::get('/saldo_anggota', [AnggotaMutasiController::class, 'saldo_anggota']);
  Route::post('/create', [AnggotaMutasiController::class, 'create']);
  Route::post('/read', [AnggotaMutasiController::class, 'read']);
  Route::get('/detail', [AnggotaMutasiController::class, 'detail']);
  Route::post('/update', [AnggotaMutasiController::class, 'update']);
  Route::get('/delete', [AnggotaMutasiController::class, 'delete']);
  Route::get('/approve', [AnggotaMutasiController::class, 'approve']);
  Route::get('/reject', [AnggotaMutasiController::class, 'reject']);
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

Route::prefix('tabungan')->middleware('checkToken')->group(function () {
  Route::post('/registrasi', [TabunganController::class, 'registrasi']);
  Route::post('/read', [TabunganController::class, 'read']);
  Route::post('/tutup', [TabunganController::class, 'tutup']);
  Route::post('/verifikasi_tutup', [TabunganController::class, 'approve_tutup']);
  Route::post('/reject_tutup', [TabunganController::class, 'reject_tutup']);
  Route::post('/get_rekening', [TabunganController::class, 'get_rekening']);
});

Route::prefix('pengajuan')->middleware('checkToken')->group(function () {
  Route::post('/member', [PengajuanController::class, 'member']);
  Route::post('/fa', [PengajuanController::class, 'fa']);
  Route::post('/peruntukan', [PengajuanController::class, 'peruntukan']);
  Route::post('/create', [PengajuanController::class, 'create']);
  Route::post('/read', [PengajuanController::class, 'read']);
  Route::get('/detail', [PengajuanController::class, 'detail']);
  Route::post('/update', [PengajuanController::class, 'update']);
  Route::post('/update_komite', [PengajuanController::class, 'update_komite']);
  Route::get('/delete', [PengajuanController::class, 'delete']);
});

Route::prefix('map')->middleware('checkToken')->group(function () {
  Route::post('/create', [MapController::class, 'create']);
  Route::post('/read', [MapController::class, 'read']);
  Route::get('/detail', [MapController::class, 'detail']);
  Route::post('/update', [MapController::class, 'update']);
  Route::get('/delete', [MapController::class, 'delete']);
});

Route::prefix('registrasiakad')->middleware('checkToken')->group(function () {
  Route::post('/rembug', [RegistrasiAkadController::class, 'rembug']);
  Route::post('/pengajuan', [RegistrasiAkadController::class, 'pengajuan']);
  Route::post('/biaya', [RegistrasiAkadController::class, 'biaya']);
  Route::post('/fa', [RegistrasiAkadController::class, 'fa']);
  Route::post('/peruntukan', [RegistrasiAkadController::class, 'peruntukan']);
  Route::post('/product', [RegistrasiAkadController::class, 'product']);
  Route::post('/kreditur', [RegistrasiAkadController::class, 'kreditur']);
  Route::post('/create', [RegistrasiAkadController::class, 'create']);
  Route::post('/read', [RegistrasiAkadController::class, 'read']);
  Route::get('/detail', [RegistrasiAkadController::class, 'detail']);
  Route::post('/update', [RegistrasiAkadController::class, 'update']);
  Route::get('/delete', [RegistrasiAkadController::class, 'delete']);
  Route::post('/approve', [RegistrasiAkadController::class, 'approve']);
  Route::get('/reject', [RegistrasiAkadController::class, 'reject']);
  Route::post('/hitung_kolek', [RegistrasiAkadController::class, 'hitung_kolek']);
  Route::post('/koreksi_droping', [RegistrasiAkadController::class, 'koreksi_droping']);
  Route::post('/proses_koreksi_droping', [RegistrasiAkadController::class, 'proses_koreksi_droping']);
});

Route::prefix('general_ledger')->middleware('checkToken')->group(function () {
  Route::post('/create', [TrxGl::class, 'create']);
  Route::post('/check', [TrxAnggota::class, 'check']);
  Route::post('/posting', [TrxAnggota::class, 'posting']);
  Route::get('/check_unverified', [TrxRembug::class, 'check_unverified']);
  Route::post('/closing', [ClosingGlController::class, 'closing']);
});

Route::prefix('laporan')->group(function () {
  Route::prefix('list')->group(function () {
    Route::post('/transaksi_majelis', [TrxRembug::class, 'transaksi_majelis']);
    Route::post('/get_par_date', [ParController::class, 'get_par_date']);
    Route::post('/get_kolektibilitas', [ParController::class, 'get_kolektibilitas']);
    Route::post('/anggota_keluar', [LaporanController::class, 'anggota_keluar']);
    Route::post('/statement_tabungan', [LaporanController::class, 'statement_tabungan']);
    Route::post('/pelunasan', [LaporanController::class, 'list_pelunasan']);
    Route::post('/saldo_tabungan', [LaporanController::class, 'list_saldo_tabungan']);
    Route::post('/buka_tabungan', [LaporanController::class, 'list_buka_tabungan']);
    Route::post('/saldo_kas_petugas', [LaporanController::class, 'list_saldo_kas_petugas']);
    Route::post('/get_detail_saving', [TabunganController::class, 'get_detail_saving']);
    Route::get('/get_closing_date', [ClosingGlController::class, 'get_closing_date']);
    Route::get('/get_report_setup', [ListKodeController::class, 'get_report_setup']);
    Route::get('/get_rekap_by', [ListKodeController::class, 'get_rekap_by']);

    Route::prefix('excel')->group(function () {
      Route::get('/anggota_masuk', [LaporanController::class, 'list_excel_anggota_masuk']);
      Route::get('/pengajuan', [LaporanController::class, 'list_excel_pengajuan']);
      Route::get('/regis_akad', [LaporanController::class, 'list_excel_regis_akad']);
      Route::get('/pencairan', [LaporanController::class, 'list_excel_pencairan']);
      Route::get('/saldo_anggota', [LaporanController::class, 'list_excel_saldo_anggota']);
      Route::get('/saldo_outstanding', [LaporanController::class, 'list_excel_saldo_outstanding']);
      Route::get('/kartu_angsuran', [LaporanController::class, 'list_excel_kartu_angsuran']);
      Route::get('/kas_petugas', [LaporanController::class, 'list_excel_kas_petugas']);
      Route::get('/detail_transaksi_majelis', [LaporanController::class, 'list_excel_detail_transaksi_majelis']);
      Route::get('/jurnal_transaksi', [LaporanController::class, 'list_excel_jurnal_transaksi']);
      Route::get('/gl_inquiry', [LaporanController::class, 'list_excel_gl_inquiry']);
      Route::get('/anggota_keluar', [LaporanController::class, 'list_excel_anggota_keluar']);
      Route::get('/statement_tabungan', [LaporanController::class, 'list_excel_statement_tabungan']);
      Route::get('/kolektibilitas', [LaporanController::class, 'list_excel_kolektibilitas']);
      Route::get('/pelunasan', [LaporanController::class, 'list_excel_pelunasan']);
      Route::get('/saldo_tabungan', [LaporanController::class, 'list_excel_saldo_tabungan']);
      Route::get('/buka_tabungan', [LaporanController::class, 'list_excel_buka_tabungan']);
      Route::get('/saldo_kas_petugas', [LaporanController::class, 'list_excel_saldo_kas_petugas']);
    });

    Route::prefix('csv')->group(function () {
      Route::get('/anggota_masuk', [LaporanController::class, 'list_csv_anggota_masuk']);
      Route::get('/pengajuan', [LaporanController::class, 'list_csv_pengajuan']);
      Route::get('/regis_akad', [LaporanController::class, 'list_csv_regis_akad']);
      Route::get('/pencairan', [LaporanController::class, 'list_csv_pencairan']);
      Route::get('/saldo_anggota', [LaporanController::class, 'list_csv_saldo_anggota']);
      Route::get('/saldo_outstanding', [LaporanController::class, 'list_csv_saldo_outstanding']);
      Route::get('/kartu_angsuran', [LaporanController::class, 'list_csv_kartu_angsuran']);
      Route::get('/kas_petugas', [LaporanController::class, 'list_csv_kas_petugas']);
      Route::get('/gl_inquiry', [LaporanController::class, 'list_csv_gl_inquiry']);
      Route::get('/anggota_keluar', [LaporanController::class, 'list_csv_anggota_keluar']);
      Route::get('/statement_tabungan', [LaporanController::class, 'list_csv_statement_tabungan']);
      Route::get('/kolektibilitas', [LaporanController::class, 'list_csv_kolektibilitas']);
      Route::get('/pelunasan', [LaporanController::class, 'list_csv_pelunasan']);
      Route::get('/saldo_tabungan', [LaporanController::class, 'list_csv_saldo_tabungan']);
      Route::get('/buka_tabungan', [LaporanController::class, 'list_csv_buka_tabungan']);
      Route::get('/saldo_kas_petugas', [LaporanController::class, 'list_csv_saldo_kas_petugas']);
    });

    Route::prefix('pdf')->group(function () {
      Route::post('/profil_anggota', [LaporanController::class, 'list_pdf_profil_anggota']);
      Route::post('/detail_profil_anggota', [LaporanController::class, 'list_pdf_detail_profil_anggota']);
      Route::post('/detail_transaksi_majelis', [LaporanController::class, 'list_pdf_detail_transaksi_majelis']);
      Route::post('/jurnal_transaksi', [LaporanController::class, 'list_pdf_jurnal_transaksi']);
      Route::post('/neraca_berjalan', [LaporanController::class, 'list_pdf_neraca_berjalan']);
      Route::post('/gl_inquiry', [LaporanController::class, 'list_pdf_gl_inquiry']);
    });
  });

  Route::prefix('rekap')->group(function () {
    Route::post('/saldo_anggota', [LaporanController::class, 'rekap_saldo_anggota']);
    Route::post('/pengajuan', [LaporanController::class, 'rekap_pengajuan']);
    Route::post('/pencairan', [LaporanController::class, 'rekap_pencairan']);
    Route::post('/outstanding', [LaporanController::class, 'rekap_outstanding']);
    Route::post('/par', [LaporanController::class, 'rekap_par']);

    Route::prefix('excel')->group(function () {
      Route::get('/saldo_anggota', [LaporanController::class, 'rekap_excel_saldo_anggota']);
      Route::get('/pengajuan', [LaporanController::class, 'rekap_excel_pengajuan']);
      Route::get('/pencairan', [LaporanController::class, 'rekap_excel_pencairan']);
      Route::get('/outstanding', [LaporanController::class, 'rekap_excel_outstanding']);
      Route::get('/par', [LaporanController::class, 'rekap_excel_par']);
    });

    Route::prefix('csv')->group(function () {
      Route::get('/saldo_anggota', [LaporanController::class, 'rekap_csv_saldo_anggota']);
      Route::get('/pengajuan', [LaporanController::class, 'rekap_csv_pengajuan']);
      Route::get('/pencairan', [LaporanController::class, 'rekap_csv_pencairan']);
      Route::get('/outstanding', [LaporanController::class, 'rekap_csv_outstanding']);
      Route::get('/par', [LaporanController::class, 'rekap_csv_par']);
    });
  });
});

Route::prefix('trx_member')->middleware('checkToken')->group(function () {
  Route::post('/penerimaan_angsuran', [TplController::class, 'penerimaan_angsuran']);
  Route::post('/kartu_angsuran', [TplController::class, 'kartu_angsuran']);
  Route::post('/transaksi_majelis', [TplController::class, 'transaksi_majelis']);
});

Route::prefix('trx_rembug')->middleware('checkToken')->group(function () {
  Route::post('/read', [TrxRembug::class, 'read']);
  Route::post('/verifikasi', [TrxRembug::class, 'verifikasi']);
  Route::post('/proses_verifikasi', [TrxRembug::class, 'proses_verifikasi']);
  Route::post('/reject', [TrxRembug::class, 'reject']);
  Route::post('/read_trx_kas_petugas', [TrxRembug::class, 'read_trx_kas_petugas']);
  Route::post('/proses_kas_petugas', [TrxRembug::class, 'proses_kas_petugas']);
  Route::post('/proses_pinbuk_simsuk', [TrxRembug::class, 'proses_pinbuk_simsuk']);
});
/* END BACK OFFICE */

/* BEGIN APP ANGGOTA */
Route::prefix('member')->group(function () {
  Route::post('/authenticate/check_username', [AnggotaUser::class, 'check_username']);
  Route::post('/authenticate/check_password', [AnggotaUser::class, 'check_password']);

  Route::prefix('information')->middleware('checkToken')->group(function () {
    Route::post('/dashboard', [AnggotaUser::class, 'dashboard']);
    Route::post('/history_saving', [AnggotaUser::class, 'history_saving']);
    Route::post('/financing', [AnggotaUser::class, 'financing']);
    Route::post('/history_financing', [AnggotaUser::class, 'history_financing']);
  });
});
/* END APP ANGGOTA */

/* BEGIN APP TPL */
Route::prefix('tpl')->group(function () {
  Route::post('/authenticate/username', [TplController::class, 'check_username']);

  Route::prefix('information')->middleware('checkToken')->group(function () {
    Route::post('/rembug', [TplController::class, 'rembug']);
    Route::post('/member', [TplController::class, 'member']);
    Route::post('/member_droping', [TplController::class, 'member_droping']);
  });

  Route::prefix('transaction')->middleware('checkToken')->group(function () {
    Route::post('/deposit', [TplController::class, 'deposit']);
    Route::post('/process_deposit', [TplController::class, 'process_deposit']);
    Route::post('/process_cash', [TplController::class, 'process_cash']);
  });
});
/* END APP TPL */