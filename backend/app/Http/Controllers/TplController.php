<?php

namespace App\Http\Controllers;

use App\Models\KopAnggota;
use App\Models\KopPembiayaan;
use App\Models\KopRembug;
use App\Models\KopTabungan;
use App\Models\KopTrxAnggota;
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

        $read = KopAnggota::tpl_member($kode_rembug);

        $count = $read->count();

        if ($count > 0) {
            $data = array();

            foreach ($read as $rd) {
                $data[] = array(
                    'no_anggota' => $rd->no_anggota,
                    'nama_anggota' => $rd->nama_anggota,
                    'kode_rembug' => $rd->kode_rembug,
                    'nama_rembug' => $rd->nama_rembug
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

    function deposit(Request $request)
    {
        $no_anggota = $request->no_anggota;

        // ANGSURAN
        $getFinancing = KopPembiayaan::tpl_deposit($no_anggota)->first();
        $no_rekening = (isset($getFinancing->no_rekening) ? $getFinancing->no_rekening : '');
        $angsuran = (isset($getFinancing->angsuran) ? $getFinancing->angsuran : 0);
        $angsuran_pokok = (isset($getFinancing->angsuran_pokok) ? $getFinancing->angsuran_pokok : 0);
        $angsuran_margin = (isset($getFinancing->angsuran_margin) ? $getFinancing->angsuran_margin : 0);
        $angsuran_catab = (isset($getFinancing->angsuran_catab) ? $getFinancing->angsuran_catab : 0);
        $freq = (isset($getFinancing->angsuran) ? 1 : 0);

        // PENCAIRAN
        $getDroping = KopPembiayaan::tpl_droping($no_anggota)->first();
        $pokok = (isset($getDroping->pokok) ? $getDroping->pokok : 0);
        $biaya_administrasi = (isset($getDroping->biaya_administrasi) ? $getDroping->biaya_administrasi : 0);
        $biaya_asuransi_jiwa = (isset($getDroping->biaya_asuransi_jiwa) ? $getDroping->biaya_asuransi_jiwa : 0);
        $biaya_asuransi_jaminan = (isset($getDroping->biaya_asuransi_jaminan) ? $getDroping->biaya_asuransi_jaminan : 0);
        $biaya_notaris = (isset($getDroping->biaya_notaris) ? $getDroping->biaya_notaris : 0);
        $tabungan_persen = (isset($getDroping->tabungan_persen) ? $getDroping->tabungan_persen : 0);
        $dana_kebajikan = (isset($getDroping->dana_kebajikan) ? $getDroping->dana_kebajikan : 0);

        // SIMPANAN WAJIB
        $param = array('no_anggota' => $no_anggota);
        $getMember = KopAnggota::where($param)->first();
        $simwa = $getMember->simwa;

        // BERENCANA
        $read = KopTabungan::tpl_saving($no_anggota);

        $count = $read->count();

        $saving = array();

        if ($count > 0) {
            foreach ($read as $rd) {
                $saving[] = array(
                    'nama_produk' => $rd['nama_singkat'],
                    'no_rekening' => $rd['no_rekening'],
                    'setoran' => str_replace('.', '', number_format($rd['setoran'], 0, ',', '.')),
                    'freq_saving' => (isset($rd['setoran']) ? 1 : 0),
                    'counter_angsuran' => $rd['counter_angsuran'],
                    'jangka_waktu' => $rd['jangka_waktu']
                );
            }
        } else {
            $saving[] = array(
                'nama_produk' => NULL,
                'no_rekening' => NULL,
                'setoran' => 0,
                'freq_saving' => 0
            );
        }

        $data = array(
            'no_rekening' => $no_rekening,
            'angsuran' => [
                'amount' => str_replace('.', '', number_format($angsuran, 0, ',', '.')),
                'detail' => [
                    [
                        'id' => '32',
                        'nama' => 'angsuran pokok',
                        'amount' => str_replace('.', '', number_format($angsuran_pokok, 0, ',', '.'))
                    ],
                    [
                        'id' => '33',
                        'nama' => 'angsuran margin',
                        'amount' => str_replace('.', '', number_format($angsuran_margin, 0, ',', '.'))
                    ],
                    [
                        'id' => '34',
                        'nama' => 'angsuran catab',
                        'amount' => str_replace('.', '', number_format($angsuran_catab, 0, ',', '.'))
                    ]
                ]
            ],
            'frekuensi' => $freq,
            'simwa' => str_replace('.', '', number_format($simwa, 0, ',', '.')),
            'berencana' => $saving,
            'pokok' => str_replace('.', '', number_format($pokok, 0, ',', '.')),
            'biaya_administrasi' => str_replace('.', '', number_format($biaya_administrasi, 0, ',', '.')),
            'biaya_asuransi_jiwa' => str_replace('.', '', number_format($biaya_asuransi_jiwa, 0, ',', '.')),
            'biaya_asuransi_jaminan' => str_replace('.', '', number_format($biaya_asuransi_jaminan, 0, ',', '.')),
            'biaya_notaris' => str_replace('.', '', number_format($biaya_notaris, 0, ',', '.')),
            'tabungan_persen' => str_replace('.', '', number_format($tabungan_persen, 0, ',', '.')),
            'dana_kebajikan' => str_replace('.', '', number_format($dana_kebajikan, 0, ',', '.'))
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
        $uuid = collect(DB::select('SELECT uuid() AS id_trx_rembug'))->first()->id_trx_rembug;

        $kode_cabang = $request->kode_cabang;
        $kode_rembug = $request->kode_rembug;
        $kode_petugas = $request->kode_petugas;
        $kode_kas_petugas = $request->kode_kas_petugas;
        $trx_date = str_replace('/', '-', $request->trx_date);
        $trx_date = date('Y-m-d', strtotime($trx_date));
        $no_anggota = $request->no_anggota;
        $no_rekening = $request->no_rekening;
        $angsuran = $request->angsuran;
        $setoran_sukarela = $request->setoran_sukarela;
        $setoran_simpanan_wajib = $request->setoran_simpanan_wajib;
        $penarikan_sukarela = $request->penarikan_sukarela;

        $no_rekening_tabungan = $request->no_rekening_tabungan;
        $amount_tabungan = $request->amount_tabungan;

        $pokok = $request->pokok;

        $count = count($no_rekening_tabungan);

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

        // PENCAIRAN
        if ($pokok > 0) {
            $data_droping = array(
                'status_droping' => 1,
                'droping_by' => $kode_petugas,
                'droping_at' => $trx_date
            );
        } else {
            $data_droping = array(
                'status_droping' => 0,
                'droping_by' => NULL,
                'droping_at' => NULL
            );
        }

        // SETORAN SUKARELA
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

        // SETORAN SIMPANAN WAJIB
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

        // PENARIKAN SUKARELA
        $data_trx_anggota[] = array(
            'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
            'id_trx_rembug' => $uuid,
            'no_anggota' => $no_anggota,
            'no_rekening' => NULL,
            'trx_date' => $trx_date,
            'amount' => $penarikan_sukarela,
            'flag_debet_credit' => 'C',
            'trx_type' => '22',
            'description' => 'Penarikan Tabungan',
            'created_by' => $kode_petugas
        );

        for ($i = 0; $i < $count; $i++) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => $no_rekening_tabungan[$i],
                'trx_date' => $trx_date,
                'amount' => $amount_tabungan[$i],
                'flag_debet_credit' => 'C',
                'trx_type' => '21',
                'description' => 'Setoran Tabungan',
                'created_by' => $kode_petugas
            );
        }

        $validate = KopTrxRembug::validateAdd($data_trx_rembug);
        $validate2 = KopTrxAnggota::validateAdd($data_trx_anggota);

        DB::beginTransaction();

        if ($validate['status'] === TRUE or $validate2['status'] === TRUE) {
            try {
                KopTrxRembug::create($data_trx_rembug);
                KopTrxAnggota::insert($data_trx_anggota);
                KopPembiayaan::where('no_rekening', '=', $no_rekening)->update($data_droping);

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
}
