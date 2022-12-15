<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KopTrxGl;
use App\Models\KopTrxGlDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxGl extends Controller
{
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    function create(Request $request)
    {
        $data = $request->all();

        $id_trx_gl = collect(DB::select('SELECT uuid() AS id_trx_gl'))->first()->id_trx_gl;

        $data['id_trx_gl'] = $id_trx_gl;
        $data['trx_date'] = date('Y-m-d');
        $data['trx_type'] = 0;

        $detail = $request->detail;

        // JURNAL DETAIL
        $data_trx_gl_detail = array();
        $trx_sequence = 0;
        for ($i = 0; $i < count($detail); $i++) {
            $data_trx_gl_detail[] = array(
                'id_trx_gl' => $id_trx_gl,
                'kode_gl' => $detail[$i]['kode_gl'],
                'flag_dc' => $detail[$i]['flag_dc'],
                'amount' => $detail[$i]['amount'],
                'description' => $detail[$i]['description'],
                'trx_sequence' => $trx_sequence
            );

            $trx_sequence++;
        }

        $validate = KopTrxGl::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                KopTrxGl::create($data);
                KopTrxGlDetail::insert($data_trx_gl_detail);

                $res = array(
                    'status' => TRUE,
                    'data' => $data,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => $e->getMessage()
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
