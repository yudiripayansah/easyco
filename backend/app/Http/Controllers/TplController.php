<?php

namespace App\Http\Controllers;

use App\Models\KopAnggota;
use App\Models\KopAnggotaMutasi;
use App\Models\KopKartuAngsuran;
use App\Models\KopLembaga;
use App\Models\KopPembiayaan;
use App\Models\KopRembug;
use App\Models\KopTabungan;
use App\Models\KopTrxAnggota;
use App\Models\KopTrxKasPetugas;
use App\Models\KopTrxRembug;
use App\Models\KopUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TplController extends Controller
{
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    function check_username(Request $request)
    {
        $username = $request->nama_user;

        $param = array('nama_user' => $username);

        $get = KopUser::where($param);

        $count = $get->count();

        $get = $get->first();

        if ($count > 0) {
            if ($get->status_user == 1) {
                $data = array('nama_user' => $get->nama_user);

                $res = array(
                    'status' => TRUE,
                    'data' => $data,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => NULL,
                    'msg' => 'Maaf! Username sudah tidak aktif',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Username tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function rembug(Request $request)
    {
        $kode_petugas = $request->kode_petugas;
        $hari_transaksi = $request->hari_transaksi;

        $read = KopRembug::tpl_rembug($kode_petugas, $hari_transaksi);

        $count = $read->count();

        if ($count > 0) {
            $data = array();

            foreach ($read as $rd) {
                $data[] = array(
                    'kode_rembug' => $rd->kode_rembug,
                    'nama_rembug' => $rd->nama_rembug,
                    'nama_desa' => $rd->nama_desa,
                    'jumlah' => $rd->jumlah
                );
            }

            $res = array(
                'status' => TRUE,
                'data' => $data,
                'msg' => 'Berhasil!',
                'error' => NULL
            );
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Data tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function member(Request $request)
    {
        $kode_rembug = $request->kode_rembug;
        $today = $request->today;

        if ($today == '~' or $today == '' or empty($today)) {
            $trx_date = date('Y-m-d');
        } else {
            $trx_date = date('Y-m-d', strtotime(str_replace('/', '-', $today)));
        }

        $read = KopAnggota::tpl_trx_member($kode_rembug, $trx_date);

        $count = $read->count();

        if ($count > 0) {
            $data = array();

            foreach ($read as $rd) {
                $penerimaan = KopTrxAnggota::tpl_cashflow_credit($rd->no_anggota, $trx_date)->first();
                $penarikan = KopTrxAnggota::tpl_cashflow_debet($rd->no_anggota, $trx_date)->first();

                $data[] = array(
                    'no_anggota' => $rd->no_anggota,
                    'nama_anggota' => $rd->nama_anggota,
                    'kode_rembug' => $rd->kode_rembug,
                    'nama_rembug' => $rd->nama_rembug,
                    'total_penerimaan' => $penerimaan->total_penerimaan,
                    'total_penarikan' => $penarikan->total_penarikan
                );
            }

            $res = array(
                'status' => TRUE,
                'data' => $data,
                'msg' => 'Berhasil!',
                'error' => NULL
            );
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Data tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function member_droping(Request $request)
    {
        $kode_rembug = $request->kode_rembug;

        $read = KopPembiayaan::member_droping($kode_rembug);

        $count = $read->count();

        if ($count > 0) {
            $res = array(
                'status' => TRUE,
                'data' => $read,
                'msg' => 'Berhasil!',
                'error' => NULL
            );
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Data tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function deposit(Request $request)
    {
        $no_anggota = $request->no_anggota;

        $param = array('no_anggota' => $no_anggota);

        // KEANGGOTAAN
        $getAnggota = KopAnggota::where($param)->first();

        // ANGGOTA MUTASI
        $getAnggotaMutasi = KopAnggotaMutasi::where($param)->first();
        $penarikan_sukarela = (($getAnggota['status'] == 3) ? ($getAnggotaMutasi->saldo_minggon + $getAnggotaMutasi->saldo_sukarela + $getAnggotaMutasi->saldo_tab_berencana + $getAnggotaMutasi->saldo_deposito + $getAnggotaMutasi->saldo_simpok + $getAnggotaMutasi->saldo_simwa) : 0);

        // ANGSURAN
        $getFinancing = KopPembiayaan::tpl_deposit($no_anggota)->first();
        $jangka_waktu = (isset($getFinancing->jangka_waktu) ? $getFinancing->jangka_waktu : 0);
        $counter_angsuran = (isset($getFinancing->counter_angsuran) ? $getFinancing->counter_angsuran : 0);
        $rekening_angsuran = (isset($getFinancing->no_rekening) ? $getFinancing->no_rekening : '');
        $angsuran = (isset($getFinancing->angsuran) ? $getFinancing->angsuran : 0);
        $angsuran_pokok = (isset($getFinancing->angsuran_pokok) ? $getFinancing->angsuran_pokok : 0);
        $angsuran_margin = (isset($getFinancing->angsuran_margin) ? $getFinancing->angsuran_margin : 0);
        $angsuran_catab = (isset($getFinancing->angsuran_catab) ? $getFinancing->angsuran_catab : 0);
        $kdtrx_angspokok = (isset($getFinancing->kdtrx_angspokok) ? $getFinancing->kdtrx_angspokok : 0);
        $kdtrx_angsmargin = (isset($getFinancing->kdtrx_angsmargin) ? $getFinancing->kdtrx_angsmargin : 0);

        if ($getAnggota['status'] == 1) {
            $freq = (isset($getFinancing->angsuran) ? 1 : 0);
        } else {
            $freq = $jangka_waktu - $counter_angsuran;
            $angsuran_pokok *= $freq;

            if ($getAnggotaMutasi['flag_saldo_margin'] == 1) {
                $angsuran_margin *= $freq;
            } else {
                $angsuran_margin = 0;
            }

            $angsuran_catab = 0;
            $angsuran = $angsuran_pokok + $angsuran_margin;
        }

        // PENCAIRAN
        $getDroping = KopPembiayaan::tpl_droping($no_anggota)->first();
        $rekening_pencairan = (isset($getDroping->no_rekening) ? $getDroping->no_rekening : 0);
        $pokok = (isset($getDroping->pokok) ? $getDroping->pokok : 0);
        $biaya_administrasi = (isset($getDroping->biaya_administrasi) ? $getDroping->biaya_administrasi : 0);
        $biaya_asuransi_jiwa = (isset($getDroping->biaya_asuransi_jiwa) ? $getDroping->biaya_asuransi_jiwa : 0);
        $biaya_asuransi_jaminan = (isset($getDroping->biaya_asuransi_jaminan) ? $getDroping->biaya_asuransi_jaminan : 0);
        $biaya_notaris = (isset($getDroping->biaya_notaris) ? $getDroping->biaya_notaris : 0);
        $tabungan_persen = (isset($getDroping->tabungan_persen) ? $getDroping->tabungan_persen : 0);
        $dana_kebajikan = (isset($getDroping->dana_kebajikan) ? $getDroping->dana_kebajikan : 0);
        $dana_gotongroyong = (isset($getDroping->dana_gotongroyong) ? $getDroping->dana_gotongroyong : 0);
        $blokir_angsuran = (isset($getDroping->blokir_angsuran) ? $getDroping->blokir_angsuran : 0);
        $tab_sukarela = (isset($getDroping->tab_sukarela) ? $getDroping->tab_sukarela : 0);

        if ($rekening_angsuran == '') {
            $no_rekening = $rekening_pencairan;
        } else {
            $no_rekening = $rekening_angsuran;
        }

        // SIMPOK, SIMWA, SIMSUK
        $getMember = KopAnggota::where($param)->first();
        $simpok = (($getAnggota['status'] == 1) ? $getMember->simpok : 0);
        $simwa = (($getAnggota['status'] == 1) ? $getMember->simwa : 0);
        $simsuk = (($getAnggota['status'] == 1) ? $getMember->simsuk : 0);

        // SIMPOK LEMBAGA
        $getLembaga = KopLembaga::first();

        if ($getAnggota['status'] == 1) {
            if ($simpok == 0) {
                $setoran_simpanan_wajib = $getLembaga->simwa;
                $setoran_simpanan_pokok = $getLembaga->simpok;
                $setoran_administrasi = $getLembaga->adm;
            } else {
                $setoran_simpanan_wajib = 0;
                $setoran_simpanan_pokok = 0;
                $setoran_administrasi = 0;
            }
        } else {
            $setoran_simpanan_wajib = 0;
            $setoran_simpanan_pokok = 0;
            $setoran_administrasi = 0;
        }

        // PEMBIAYAAN
        $show = KopPembiayaan::tpl_financing($no_anggota);

        $hit = $show->count();

        $financing = array();

        if ($hit > 0) {
            foreach ($show as $sh) {
                $financing[] = array(
                    'nama_produk' => $sh['nama_singkat'],
                    'counter_angsuran' => $sh['counter_angsuran'],
                    'jangka_waktu' => $sh['jangka_waktu'],
                    'pokok' => (int)$sh['saldo_pokok']
                );
            }
        } else {
            $financing[] = array(
                'nama_produk' => NULL,
                'counter_angsuran' => 0,
                'jangka_waktu' => 0,
                'pokok' => 0
            );
        }

        // BERENCANA
        $read = KopTabungan::tpl_saving($no_anggota);

        $count = $read->count();

        $saving = array();

        if ($count > 0) {
            foreach ($read as $rd) {
                if ($rd->kode_produk == '099') {
                    $freq_saving = 0;
                } else {
                    $freq_saving = (isset($rd['setoran']) ? 1 : 0);
                }

                $saving[] = array(
                    'nama_produk' => $rd['nama_singkat'],
                    'no_rekening' => $rd['no_rekening'],
                    'setoran' => (($getAnggota['status'] == 1) ? (int)$rd['setoran'] : 0),
                    'saldo' => (($getAnggota['status'] == 1) ? (int)$rd['saldo'] : 0),
                    'freq_saving' => (($getAnggota['status'] == 1) ? $freq_saving : 0),
                    'counter_angsuran' => $rd['counter_angsuran'],
                    'jangka_waktu' => $rd['jangka_waktu'],
                    'kode_produk' => $rd['kode_produk']
                );
            }
        } else {
            $saving[] = array(
                'nama_produk' => NULL,
                'no_rekening' => NULL,
                'setoran' => 0,
                'freq_saving' => 0,
                'counter_angsuran' => 0,
                'jangka_waktu' => 0
            );
        }

        $data = array(
            'status_anggota' => $getAnggota['status'],
            'no_rekening' => $no_rekening,
            'angsuran' => [
                'amount' => (int)$angsuran,
                'detail' => [
                    [
                        'id' => $kdtrx_angspokok,
                        'nama' => 'angsuran pokok',
                        'amount' => (int)$angsuran_pokok
                    ],
                    [
                        'id' => $kdtrx_angsmargin,
                        'nama' => 'angsuran margin',
                        'amount' => (int)$angsuran_margin
                    ],
                    [
                        'id' => '34',
                        'nama' => 'angsuran catab',
                        'amount' => (int)$angsuran_catab
                    ]
                ]
            ],
            'frekuensi' => $freq,
            'setoran_simpanan_wajib' => (int)$setoran_simpanan_wajib,
            'setoran_simpanan_pokok' => (int)$setoran_simpanan_pokok,
            'setoran_administrasi' => (int)$setoran_administrasi,
            'penarikan_sukarela' => (int)$penarikan_sukarela,
            'simpok' => (int)$simpok,
            'simwa' => (int)$simwa,
            'simsuk' => (int)$simsuk,
            'pembiayaan' => $financing,
            'berencana' => $saving,
            'pokok' => (int)$pokok,
            'biaya_administrasi' => (int)$biaya_administrasi,
            'biaya_asuransi_jiwa' => (int)$biaya_asuransi_jiwa,
            'biaya_asuransi_jaminan' => (int)$biaya_asuransi_jaminan,
            'biaya_notaris' => (int)$biaya_notaris,
            'tabungan_persen' => (int)$tabungan_persen,
            'dana_kebajikan' => (int)$dana_kebajikan,
            'dana_gotongroyong' => (int)$dana_gotongroyong,
            'blokir_angsuran' => (int)$blokir_angsuran,
            'tab_sukarela' => (int)$tab_sukarela
        );

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!',
            'error' => NULL
        );
        $response = response()->json($res, 200);

        return $response;
    }

    function process_deposit(Request $request)
    {
        $kode_rembug = $request->kode_rembug;
        $kode_petugas = $request->kode_petugas;
        $trx_date = str_replace('/', '-', $request->trx_date);
        $trx_date = date('Y-m-d', strtotime($trx_date));
        $no_anggota = $request->no_anggota;
        $no_rekening = $request->no_rekening;
        $angsuran = $request->angsuran;
        $setoran_sukarela = $request->setoran_sukarela;
        $setoran_simpanan_wajib = $request->setoran_simpanan_wajib;
        $setoran_simpanan_pokok = $request->setoran_simpanan_pokok;
        $setoran_administrasi = $request->setoran_administrasi;
        $penarikan_sukarela = $request->penarikan_sukarela;

        $no_rekening_tabungan = $request->no_rekening_tabungan;
        $amount_tabungan = $request->amount_tabungan;

        $pokok = $request->pokok;
        $biaya_administrasi = $request->biaya_administrasi;
        $biaya_asuransi_jiwa = $request->biaya_asuransi_jiwa;
        $tabungan_persen = $request->tabungan_persen;
        $dana_kebajikan = $request->dana_kebajikan;
        $dana_gotongroyong = $request->dana_gotongroyong;
        $blokir_angsuran = $request->blokir_angsuran;

        $count = count($no_rekening_tabungan);

        $check = KopTrxRembug::get_exist($kode_rembug, $kode_petugas, $trx_date);
        $counts = KopTrxRembug::get_count($kode_rembug, $kode_petugas, $trx_date);
        $param2 = array(
            'no_anggota' => $no_anggota,
            'trx_date' => $trx_date
        );

        if ($counts['jumlah'] > 0) {
            $uuid = $check['id_trx_rembug'];
        } else {
            $uuid = collect(DB::select('SELECT uuid() AS id_trx_rembug'))->first()->id_trx_rembug;
        }

        $check2 = KopTrxAnggota::get_exist($no_anggota, $trx_date, $uuid);

        $data_trx_rembug = array(
            'id_trx_rembug' => $uuid,
            'kode_rembug' => $kode_rembug,
            'kode_petugas' => $kode_petugas,
            'trx_date' => $trx_date,
            'created_by' => $kode_petugas
        );

        $data_trx_anggota = array();

        // ANGSURAN PEMBIAYAAN
        for ($a = 0; $a < count($angsuran); $a++) {
            if ($angsuran[$a]['amount'] > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => $no_rekening,
                    'trx_date' => $trx_date,
                    'amount' => $angsuran[$a]['amount'],
                    'flag_debet_credit' => 'C',
                    'trx_type' => $angsuran[$a]['id'],
                    'description' => 'Bayar ' . $angsuran[$a]['nama'],
                    'created_by' => $kode_petugas
                );
            }
        }

        // SETORAN SUKARELA
        if ($setoran_sukarela > 0) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => NULL,
                'trx_date' => $trx_date,
                'amount' => $setoran_sukarela,
                'flag_debet_credit' => 'C',
                'trx_type' => '13',
                'description' => 'Bayar Simsuk',
                'created_by' => $kode_petugas
            );
        }

        // SETORAN SIMPANAN POKOK
        if ($setoran_simpanan_pokok > 0) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => NULL,
                'trx_date' => $trx_date,
                'amount' => $setoran_simpanan_pokok,
                'flag_debet_credit' => 'C',
                'trx_type' => '11',
                'description' => 'Bayar Simpok',
                'created_by' => $kode_petugas
            );
        }

        // SETORAN SIMPANAN WAJIB
        if ($setoran_simpanan_wajib > 0) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => NULL,
                'trx_date' => $trx_date,
                'amount' => $setoran_simpanan_wajib,
                'flag_debet_credit' => 'C',
                'trx_type' => '12',
                'description' => 'Bayar Simwa',
                'created_by' => $kode_petugas
            );
        }

        // SETORAN ADMINISTRASI
        if ($setoran_administrasi > 0) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => NULL,
                'trx_date' => $trx_date,
                'amount' => $setoran_administrasi,
                'flag_debet_credit' => 'C',
                'trx_type' => '16',
                'description' => 'Biaya Adm Anggota',
                'created_by' => $kode_petugas
            );
        }

        // PENARIKAN SUKARELA
        if ($penarikan_sukarela > 0) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => NULL,
                'trx_date' => $trx_date,
                'amount' => $penarikan_sukarela,
                'flag_debet_credit' => 'D',
                'trx_type' => '22',
                'description' => 'Penarikan Sukarela',
                'created_by' => $kode_petugas
            );
        }

        // SETORAN TABER
        for ($i = 0; $i < $count; $i++) {
            if ($amount_tabungan[$i] > 0) {
                $getSaving = KopTabungan::get_detail_saving($no_rekening_tabungan[$i]);
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => $no_rekening_tabungan[$i],
                    'trx_date' => $trx_date,
                    'amount' => $amount_tabungan[$i],
                    'flag_debet_credit' => 'C',
                    'trx_type' => $getSaving->kdtrx_setortunai,
                    'description' => 'Setoran Tabungan',
                    'created_by' => $kode_petugas
                );
            }
        }

        // PENCAIRAN PEMBIAYAAN
        if ($pokok > 0) {
            $getDroping = KopPembiayaan::tpl_droping($no_anggota)->first();
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => $no_rekening,
                'trx_date' => $trx_date,
                'amount' => $pokok,
                'flag_debet_credit' => 'D',
                'trx_type' => $getDroping->kdtrx_pencairan,
                'description' => 'Terima Pencairan Pembiayaan',
                'created_by' => $kode_petugas
            );

            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => $no_rekening,
                'trx_date' => $trx_date,
                'amount' => $biaya_administrasi,
                'flag_debet_credit' => 'C',
                'trx_type' => '35',
                'description' => 'Bayar By Admin Pembiayaan',
                'created_by' => $kode_petugas
            );

            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => $no_rekening,
                'trx_date' => $trx_date,
                'amount' => $biaya_asuransi_jiwa,
                'flag_debet_credit' => 'C',
                'trx_type' => '36',
                'description' => 'Bayar By Asuransi Pembiayaan',
                'created_by' => $kode_petugas
            );

            if ($tabungan_persen > 0) {
                $getRekeningTabungan = KopTabungan::get_rekening_tabungan($no_anggota, '099');
                $getCodeSaving = KopTabungan::get_detail_saving($getRekeningTabungan->no_rekening);
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => $getRekeningTabungan->no_rekening,
                    'trx_date' => $trx_date,
                    'amount' => $tabungan_persen,
                    'flag_debet_credit' => 'C',
                    'trx_type' => $getCodeSaving->kdtrx_setortunai,
                    'description' => 'Setoran Tabungan',
                    'created_by' => $kode_petugas
                );
            }

            if ($dana_kebajikan > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => NULL,
                    'trx_date' => $trx_date,
                    'amount' => $dana_kebajikan,
                    'flag_debet_credit' => 'C',
                    'trx_type' => '37',
                    'description' => 'Bayar By Dana Kebajikan Pembiayaan',
                    'created_by' => $kode_petugas
                );
            }

            if ($dana_gotongroyong > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => NULL,
                    'trx_date' => $trx_date,
                    'amount' => $dana_gotongroyong,
                    'flag_debet_credit' => 'C',
                    'trx_type' => '38',
                    'description' => 'Bayar By Gotong Royong Pembiayaan',
                    'created_by' => $kode_petugas
                );
            }

            if ($blokir_angsuran > 0) {
                $getRekeningTiar = KopTabungan::get_rekening_tabungan($no_anggota, '003');
                $getCodeSaving = KopTabungan::get_detail_saving($getRekeningTiar->no_rekening);
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => $getRekeningTiar->no_rekening,
                    'trx_date' => $trx_date,
                    'amount' => $blokir_angsuran,
                    'flag_debet_credit' => 'C',
                    'trx_type' => $getCodeSaving->kdtrx_setortunai,
                    'description' => 'Setoran Tabungan Tiar',
                    'created_by' => $kode_petugas
                );
            }

            /*
            if ($tab_sukarela > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => NULL,
                    'trx_date' => $trx_date,
                    'amount' => $tab_sukarela,
                    'flag_debet_credit' => 'C',
                    'trx_type' => '13',
                    'description' => 'Potongan Simsuk Pencairan',
                    'created_by' => $kode_petugas
                );
            }
            */
        }

        // ANGGOTA KELUAR
        $param3 = array(
            'no_anggota' => $no_anggota,
            'status_mutasi' => 1
        );
        $keluar = KopAnggotaMutasi::where($param3)->first();
        //$count_keluar = $keluar->count();

        if ($keluar) {
            if ($keluar->saldo_tab_berencana > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => null,
                    'trx_date' => $trx_date,
                    'amount' => $keluar->saldo_tab_berencana,
                    'flag_debet_credit' => 'D',
                    'trx_type' => '43',
                    'description' => 'Pinbuk Tabungan ke Sukarela',
                    'created_by' => $kode_petugas
                );
            }

            if ($keluar->saldo_simpok > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => null,
                    'trx_date' => $trx_date,
                    'amount' => $keluar->saldo_simpok,
                    'flag_debet_credit' => 'D',
                    'trx_type' => '41',
                    'description' => 'Pinbuk Simpok ke Sukarela',
                    'created_by' => $kode_petugas
                );
            }

            if ($keluar->saldo_simwa > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => null,
                    'trx_date' => $trx_date,
                    'amount' => $keluar->saldo_simwa,
                    'flag_debet_credit' => 'D',
                    'trx_type' => '44',
                    'description' => 'Pinbuk Simwa 5% - Sukarela',
                    'created_by' => $kode_petugas
                );
            }
        }

        /*
        echo '<pre>';
        echo $count_keluar;
        print_r($data_trx_anggota);
        echo '</pre>';
        die;
        */

        $validate = KopTrxRembug::validateAdd($data_trx_rembug);
        $validate2 = KopTrxAnggota::validateAdd($data_trx_anggota);

        DB::beginTransaction();

        if ($validate['status'] === TRUE or $validate2['status'] === TRUE) {
            try {
                if ($counts['jumlah'] == 0) {
                    KopTrxRembug::create($data_trx_rembug);
                }

                if ($check2['jumlah'] > 0) {
                    KopTrxAnggota::where($param2)->forceDelete();
                }

                KopTrxAnggota::insert($data_trx_anggota);

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data_trx_rembug,
                    'msg' => $e->getMessage(),
                    'error' => NULL
                );
            }
        } else {
            $msg = array(
                'validate' => $validate['msg'],
                'validate2' => $validate2['msg']
            );

            $error = array(
                'error' => $validate['errors'],
                'error2' => $validate2['errors']
            );

            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => $msg,
                'error' => $error
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function process_cash(Request $request)
    {
        $kode_kas_petugas = $request->kode_kas_petugas;
        $nama_rembug = $request->nama_rembug;
        $total_setoran = $request->total_setoran;
        $total_penarikan = $request->total_penarikan;
        $total_infaq = $request->total_infaq;
        $voucher_date = $request->voucher_date;
        $created_by = $request->kode_petugas;

        $validate_fill = array(
            'kode_kas_petugas' => $kode_kas_petugas,
            'nama_rembug' => $nama_rembug,
            'total_setoran' => $total_setoran,
            'total_penarikan' => $total_penarikan,
            'total_infaq' => $total_infaq,
            'voucher_date' => $voucher_date,
            'created_by' => $created_by
        );

        $data_trx_kas_petugas = array();

        $data_trx_kas_petugas[] = array(
            'kode_kas_petugas' => $kode_kas_petugas,
            'jenis_trx' => 2,
            'debit_credit' => 'D',
            'jumlah_trx' => ($total_setoran + $total_infaq),
            'trx_date' => date('Y-m-d'),
            'voucher_date' => $voucher_date,
            'keterangan' => 'PENERIMAAN MAJELIS ' . $nama_rembug,
            'created_by' => $created_by
        );

        $data_trx_kas_petugas[] = array(
            'kode_kas_petugas' => $kode_kas_petugas,
            'jenis_trx' => 3,
            'debit_credit' => 'C',
            'jumlah_trx' => $total_penarikan,
            'trx_date' => date('Y-m-d'),
            'voucher_date' => $voucher_date,
            'keterangan' => 'PENARIKAN MAJELIS ' . $nama_rembug,
            'created_by' => $created_by
        );

        $validate = KopTrxKasPetugas::validateAdd($validate_fill);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                KopTrxKasPetugas::insert($data_trx_kas_petugas);

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data_trx_kas_petugas,
                    'msg' => $e->getMessage(),
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function penerimaan_angsuran(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'kop_trx_anggota.trx_anggota';
        $total = 0;
        $totalPage = 1;
        $cabang = '~';
        $petugas = '~';
        $rembug = '~';
        $from = NULL;
        $to = NULL;

        if ($request->page) {
            $page = $request->page;
        }

        if ($request->perPage) {
            $perPage = $request->perPage;
        }

        if ($request->sortDir) {
            $sortDir = $request->sortDir;
        }

        if ($request->sortBy) {
            $sortBy = $request->sortBy;
        }

        if ($request->cabang) {
            $cabang = $request->cabang;
        }

        if ($request->petugas) {
            $petugas = $request->petugas;
        }

        if ($request->rembug) {
            $rembug = $request->rembug;
        }

        if ($request->from) {
            $from = str_replace('/', '-', $request->from);
            $from = date('Y-m-d', strtotime($from));
        }

        if ($request->to) {
            $to = str_replace('/', '-', $request->to);
            $to = date('Y-m-d', strtotime($to));
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopTrxAnggota::select('ktr.trx_date', 'kp.no_rekening', 'ka.nama_anggota', 'kr.nama_rembug', 'kp.angsuran_pokok', DB::raw('COALESCE(a.byr_pokok,0) AS byr_pokok'), DB::raw('COALESCE(b.byr_margin,0) AS byr_margin'))
            ->join('kop_trx_rembug AS ktr', 'ktr.id_trx_rembug', 'kop_trx_anggota.id_trx_rembug')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'ktr.kode_rembug')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kop_trx_anggota.no_anggota')
            ->join('kop_pembiayaan AS kp', 'kp.no_rekening', 'kop_trx_anggota.no_rekening')
            ->leftjoin(DB::raw("(SELECT no_rekening,trx_date,SUM(amount) AS byr_pokok FROM kop_trx_anggota WHERE trx_type = '32' AND flag_debet_credit = 'C' GROUP BY no_rekening,trx_date) AS a"), function ($join) {
                $join->on('a.no_rekening', 'kp.no_rekening')->where('a.trx_date', DB::raw('CAST(ktr.trx_date AS DATE)'));
            })
            ->leftjoin(DB::raw("(SELECT no_rekening,trx_date,SUM(amount) AS byr_margin FROM kop_trx_anggota WHERE trx_type = '33' AND flag_debet_credit = 'C' GROUP BY no_rekening,trx_date) AS b"), function ($join) {
                $join->on('b.no_rekening', 'kp.no_rekening')->where('b.trx_date', DB::raw('CAST(ktr.trx_date AS DATE)'));
            })
            ->whereBetween('ktr.trx_date', [$from, $to]);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($cabang <> '~') {
            $read->where('kr.kode_cabang', $cabang);
        }

        if ($petugas <> '~') {
            $read->where('kr.kode_petugas', $petugas);
        }

        if ($rembug <> '~') {
            $read->where('kr.kode_rembug', $rembug);
        }

        $read = $read->groupBy('ktr.trx_date', 'kp.no_rekening', 'ka.nama_anggota', 'kr.nama_rembug', 'kp.angsuran_pokok', 'a.byr_pokok', 'b.byr_margin')->get();

        $res = array(
            'status' => TRUE,
            'data' => $read,
            'page' => $page,
            'perPage' => $perPage,
            'sortDir' => $sortDir,
            'sortBy' => $sortBy,
            'total' => $total,
            'totalPage' => $totalPage,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function kartu_angsuran(Request $request)
    {
        $no_rekening = '~';

        if ($request->no_rekening) {
            $no_rekening = $request->no_rekening;
        }

        $read = KopPembiayaan::select('kop_pembiayaan.no_rekening', 'ka.nama_anggota', 'kr.nama_rembug', 'kd.nama_desa', 'kpp.nama_produk', 'kop_pembiayaan.tanggal_akad', 'kop_pembiayaan.tanggal_mulai_angsur', 'kop_pembiayaan.tanggal_jtempo', 'kop_pembiayaan.pokok', 'kop_pembiayaan.margin', 'kop_pembiayaan.jangka_waktu', 'kop_pembiayaan.periode_jangka_waktu', 'kop_pembiayaan.angsuran_pokok', 'kop_pembiayaan.angsuran_margin', 'kop_pembiayaan.angsuran_catab')
            ->join('kop_pengajuan AS kpg', 'kpg.no_pengajuan', 'kop_pembiayaan.no_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kpg.no_anggota')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
            ->join('kop_desa AS kd', 'kd.kode_desa', 'kr.kode_desa')
            ->join('kop_prd_pembiayaan AS kpp', 'kpp.kode_produk', 'kop_pembiayaan.kode_produk')
            ->where('kop_pembiayaan.no_rekening', $no_rekening)->where('kop_pembiayaan.status_rekening', 1)->get();

        $kartu = array();

        foreach ($read as $rd) {
            $card = KopKartuAngsuran::select('kop_kartu_angsuran.*', 'kpg.nama_pgw')
                ->leftjoin('kop_trx_rembug AS ktr', 'ktr.id_trx_rembug', 'kop_kartu_angsuran.id_trx_rembug')
                ->leftjoin('kop_pegawai AS kpg', 'kpg.kode_pgw', 'ktr.kode_petugas')
                ->where('no_rekening', $rd->no_rekening)
                ->orderBy('angsuran_ke', 'ASC')
                ->get();

            foreach ($card as $cd) {
                $kartu[] = array(
                    'trx_date' => $cd->tgl_angsuran,
                    'tgl_bayar' => $cd->tgl_bayar,
                    'angsuran_ke' => $cd->angsuran_ke,
                    'jumlah' => ($cd->angsuran_pokok + $cd->angsuran_margin + $cd->angsuran_catab),
                    'angsuran_pokok' => (int) $cd->angsuran_pokok,
                    'angsuran_margin' => (int) $cd->angsuran_margin,
                    'angsuran_catab' => (int) $cd->angsuran_catab,
                    'saldo_pokok' => (int) $cd->saldo_pokok,
                    'saldo_margin' => (int) $cd->saldo_margin,
                    'petugas' => $cd->nama_pgw
                );
            }

            $rd->detail = $kartu;
        }

        $res = array(
            'status' => TRUE,
            'data' => $read,
            'page' => NULL,
            'perPage' => NULL,
            'sortDir' => NULL,
            'sortBy' => NULL,
            'total' => NULL,
            'totalPage' => NUll,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function transaksi_majelis(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'kop_trx_rembug.trx_date';
        $total = 0;
        $totalPage = 1;
        $cabang = '~';
        $petugas = '~';
        $rembug = '~';
        $from = NULL;
        $to = NULL;

        if ($request->page) {
            $page = $request->page;
        }

        if ($request->perPage) {
            $perPage = $request->perPage;
        }

        if ($request->sortDir) {
            $sortDir = $request->sortDir;
        }

        if ($request->sortBy) {
            $sortBy = $request->sortBy;
        }

        if ($request->cabang) {
            $cabang = $request->cabang;
        }

        if ($request->petugas) {
            $petugas = $request->petugas;
        }

        if ($request->rembug) {
            $rembug = $request->rembug;
        }

        if ($request->from) {
            $from = str_replace('/', '-', $request->from);
            $from = date('Y-m-d', strtotime($from));
        }

        if ($request->to) {
            $to = str_replace('/', '-', $request->to);
            $to = date('Y-m-d', strtotime($to));
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopTrxRembug::select('kop_trx_rembug.trx_date', 'kr.nama_rembug', DB::raw('COALESCE(a.setoran,0) AS setoran'), DB::raw('COALESCE(b.penarikan,0) AS penarikan'), DB::raw('COALESCE(SUM(kta.amount),0) AS pencairan'))
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'kop_trx_rembug.kode_rembug')
            ->leftjoin('kop_trx_anggota AS kta', function ($join) {
                $join->on('kta.id_trx_rembug', 'kop_trx_rembug.id_trx_rembug')->where('kta.trx_type', 31);
            })
            ->leftjoin(DB::raw("(SELECT id_trx_rembug,SUM(amount) AS setoran FROM kop_trx_anggota WHERE flag_debet_credit = 'C' GROUP BY id_trx_rembug) AS a"), function ($join) {
                $join->on('a.id_trx_rembug', 'kop_trx_rembug.id_trx_rembug');
            })
            ->leftjoin(DB::raw("(SELECT id_trx_rembug,SUM(amount) AS penarikan FROM kop_trx_anggota WHERE flag_debet_credit = 'D' GROUP BY id_trx_rembug) AS b"), function ($join) {
                $join->on('b.id_trx_rembug', 'kop_trx_rembug.id_trx_rembug');
            })
            ->whereBetween('kop_trx_rembug.trx_date', [$from, $to]);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($cabang <> '~') {
            $read->where('kr.kode_cabang', $cabang);
        }

        if ($petugas <> '~') {
            $read->where('kr.kode_petugas', $petugas);
        }

        if ($rembug <> '~') {
            $read->where('kr.kode_rembug', $rembug);
        }

        $read = $read->groupBy('kop_trx_rembug.trx_date', 'kr.nama_rembug', 'a.setoran', 'b.penarikan')->get();

        $res = array(
            'status' => TRUE,
            'data' => $read,
            'page' => $page,
            'perPage' => $perPage,
            'sortDir' => $sortDir,
            'sortBy' => $sortBy,
            'total' => $total,
            'totalPage' => $totalPage,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }
}
