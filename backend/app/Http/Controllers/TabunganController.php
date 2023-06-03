<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KopTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    function registrasi(Request $request)
    {
        $data = $request->all();

        $sequence = KopTabungan::get_seq_rekening($request->no_anggota, $request->kode_produk);

        $format = '00';

        if ($sequence['jumlah'] == 0) {
            $tabungan_ke = 1;
        } else {
            $tabungan_ke = $sequence['jumlah'] + 1;
        }

        $tabungan_ke = substr($format . $tabungan_ke, '-2');

        $data['flag_taber'] = $request->jenis_tabungan;
        $data['tanggal_buka'] = date('Y-m-d');
        $data['no_rekening'] = $request->no_anggota . $request->kode_produk . $tabungan_ke;

        $validate = KopTabungan::validateAdd($data);

        if ($validate['status'] === TRUE) {
            try {
                $create = KopTabungan::create($data);
                $find = KopTabungan::find($create->id);

                $res = array(
                    'status' => TRUE,
                    'data' => $find,
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
