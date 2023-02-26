<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KopTrxRembug;
use Illuminate\Http\Request;

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
            $penerimaan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'C');
            $penarikan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'D');

            $data[] = array(
                'id_trx_rembug' => $sh['id_trx_rembug'],
                'nama_rembug' => $sh['nama_rembug'],
                'nama_cabang' => $sh['nama_cabang'],
                'trx_date' => $sh['trx_date'],
                'nama_kas_petugas' => $sh['nama_kas_petugas'],
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
}
