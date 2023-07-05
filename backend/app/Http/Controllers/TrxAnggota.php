<?php

namespace App\Http\Controllers;

use App\Models\KopTrxAnggota;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxAnggota extends Controller
{
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    function check(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $voucher_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->voucher_date)));

        $get = KopTrxAnggota::check_transaction($kode_cabang, $voucher_date);

        $data = array();

        $total_debet = 0;
        $total_credit = 0;

        foreach ($get as $gt) {
            if ($gt['d_c'] == 'D') {
                $total_debet += $gt['amount'];
            } else {
                $total_credit += $gt['amount'];
            }

            $data[] = array(
                'kode_cabang' => $gt['kode_cabang'],
                'trx_date' => $gt['trx_date'],
                'trx_type' => $gt['trx_type'],
                'nama_trx' => $gt['nama_trx'],
                'flag_dc' => $gt['d_c'],
                'gl_debit' => $gt['gl_debit'],
                'nama_gl_debit' => $gt['nama_gl_debit'],
                'gl_credit' => $gt['gl_credit'],
                'nama_gl_credit' => $gt['nama_gl_credit'],
                'amount' => (int)$gt['amount']
            );
        }

        $res = array(
            'status' => true,
            'data' => $data,
            'total_kas_debit' => $total_debet,
            'total_kas_kredit' => $total_credit,
            'saldo_kas' => $total_debet - $total_credit
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function posting(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $voucher_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->voucher_date)));

        DB::beginTransaction();

        try {
            KopTrxAnggota::buat_jurnal($kode_cabang, $voucher_date);

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
                'data' => $request->all(),
                'msg' => $e->getMessage()
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
