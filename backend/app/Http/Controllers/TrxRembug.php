<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KopAnggota;
use App\Models\KopKartuAngsuran;
use App\Models\KopPembiayaan;
use App\Models\KopTabungan;
use App\Models\KopTrxAnggota;
use App\Models\KopTrxRembug;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxRembug extends Controller
{
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    function read(Request $request)
    {
        $branch_code = $request->branch_code;

        if ($request->from_date) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($request->thru_date) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $data = array();

        $show = KopTrxRembug::get_all_transaction($branch_code, $from_date, $thru_date);

        foreach ($show as $sh) {
            $kas_awal = KopTrxAnggota::total_droping($sh['id_trx_rembug']);
            $penerimaan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'C');
            $penarikan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'D');

            $data[] = array(
                'id_trx_rembug' => $sh['id_trx_rembug'],
                'nama_rembug' => $sh['nama_rembug'],
                'nama_cabang' => $sh['nama_cabang'],
                'trx_date' => $sh['trx_date'],
                'nama_kas_petugas' => $sh['nama_kas_petugas'],
                'kas_awal' => $kas_awal['kas_awal'],
                'infaq' => $sh['infaq'],
                'total_penerimaan' => $penerimaan['amount'],
                'total_penarikan' => $penarikan['amount']
            );
        }

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function verifikasi(Request $request)
    {
        $id_trx_rembug = $request->id_trx_rembug;

        $data = KopTrxRembug::get_rembug_verification($id_trx_rembug);
        $penerimaan = KopTrxRembug::total_cashflow_verification($id_trx_rembug, 'C');
        $penarikan = KopTrxRembug::total_cashflow_verification($id_trx_rembug, 'D');
        $detail = KopTrxRembug::get_detail($id_trx_rembug);

        $data['penerimaan'] = $penerimaan['amount'];
        $data['penarikan'] = $penarikan['amount'];

        $res = array(
            'status' => true,
            'data' => $data,
            'detail' => $detail
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function proses_verifikasi(Request $request)
    {
        $id_trx_rembug = $request->id_trx_rembug;

        $param = array('id_trx_rembug' => $id_trx_rembug);

        $show = KopTrxAnggota::where($param)->get();
        $trx_rembug = KopTrxRembug::where($param)->first();

        foreach ($show as $sh) {
            $id = $sh['id'];
            $id_trx_anggota = $sh['id_trx_anggota'];
            $no_anggota = $sh['no_anggota'];
            $no_rekening = $sh['no_rekening'];
            $trx_date = $sh['trx_date'];
            $amount = $sh['amount'];
            $flag_debet_credit = $sh['flag_debet_credit'];
            $trx_type = $sh['trx_type'];

            $param_anggota = array('no_anggota' => $no_anggota);
            $anggota = KopAnggota::where($param_anggota)->first();

            $param_tabungan = array('no_rekening' => $no_rekening);
            $tabungan = KopTabungan::where($param_tabungan)->first();

            $param_pembiayaan = array('no_rekening' => $no_rekening);
            $pembiayaan = KopPembiayaan::where($param_pembiayaan)->first();

            // SETORAN SIMPOK
            if ($trx_type == 11) {
                if ($amount > 0) {
                    $get = KopAnggota::find($anggota['id']);
                    $simpok = $anggota['simpok'] + $amount;
                    $get->simpok = $simpok;
                    $get->save();
                }
            }

            // SETORAN SIMWA
            if ($trx_type == 12) {
                if ($amount > 0) {
                    $get = KopAnggota::find($anggota['id']);
                    $simwa = $anggota['simwa'] + $amount;
                    $get->simwa = $simwa;
                    $get->save();
                }
            }

            // SETORAN SUKARELA
            if ($trx_type == 13) {
                if ($amount > 0) {
                    $get = KopAnggota::find($anggota['id']);
                    $simsuk = $anggota['simsuk'] + $amount;
                    $get->simsuk = $simsuk;
                    $get->save();
                }
            }

            // SETORAN TABER
            if ($trx_type == 21) {
                if ($amount > 0) {
                    $get = KopTabungan::find($tabungan['id']);
                    $saldo = $tabungan['saldo'] + $amount;
                    $get->saldo = $saldo;
                    $get->save();
                }
            }

            // PENARIKAN SUKARELA
            if ($trx_type == 22) {
                if ($amount > 0) {
                    $get = KopAnggota::find($anggota['id']);
                    $simsuk = $anggota['simsuk'] - $amount;
                    $get->simsuk = $simsuk;
                    $get->save();
                }
            }

            // PENCAIRAN PEMBIAYAAN
            if ($trx_type == 31) {
                if ($amount > 0) {
                    $get = KopPembiayaan::find($pembiayaan['id']);
                    $get->status_droping = 1;
                    $get->droping_by = $trx_rembug['kode_petugas'];
                    $get->droping_at = date('Y-m-d H:i:s');
                    $get->save();
                }
            }

            // SETORAN ANGSURAN POKOK
            if ($trx_type == 32) {
                if ($amount > 0) {
                    $freq = $amount / $pembiayaan['angsuran_pokok'];
                    $get = KopPembiayaan::find($pembiayaan['id']);
                    $get->jtempo_angsuran_last = $pembiayaan['jtempo_angsuran_next'];
                    $get->counter_angsuran = $pembiayaan['counter_angsuran'] + $freq;
                    $get->saldo_pokok = $pembiayaan['saldo_pokok'] - $amount;
                    $get->jtempo_angsuran_next = date('Y-m-d', strtotime($pembiayaan['jtempo_angsuran_next'] . ' + ' . $freq . ' WEEKS'));
                    $get->save();

                    $param_angsuran = array(
                        'no_rekening' => $no_rekening,
                        'tgl_angsuran' => $pembiayaan['jtempo_angsuran_next']
                    );

                    $angsuran = KopKartuAngsuran::where($param_angsuran)->first();
                    $get2 = KopKartuAngsuran::find($angsuran['id']);
                    $get2->flag_bayar = 1;
                    $get2->tgl_bayar = $trx_date;
                    $get2->save();
                }
            }

            // SETORAN ANGSURAN MARGIN
            if ($trx_type == 33) {
                if ($amount > 0) {
                    $get = KopPembiayaan::find($pembiayaan['id']);
                    $get->saldo_margin = $pembiayaan['saldo_margin'] - $amount;
                    $get->save();
                }
            }

            // SETORAN ANGSURAN CATAB
            if ($trx_type == 34) {
                if ($amount > 0) {
                    $get = KopPembiayaan::find($pembiayaan['id']);
                    $get->saldo_catab = $pembiayaan['angsuran_catab'] + $amount;
                    $get->save();
                }
            }

            $upd = KopTrxAnggota::find($id);
            $upd->verified_by = $trx_rembug['kode_petugas'];
            $upd->verified_at = date('Y-m-d H:i:s');
            $upd->save();
        }

        try {
            $update = KopTrxRembug::find($trx_rembug['id']);
            $update->verified_by = $trx_rembug['kode_petugas'];
            $update->verified_at = date('Y-m-d H:i:s');
            $update->save();

            $res = array(
                'status' => TRUE,
                'data' => NULL,
                'msg' => 'Berhasil!'
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $res = array(
                'status' => FALSE,
                'data' => $show,
                'msg' => $e->getMessage()
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
