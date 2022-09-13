<?php

namespace App\Http\Controllers;

use App\Models\KopCabang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        $validate = KopCabang::validate($data);

        if ($validate['status'] == TRUE) {
            try {
                $create = KopCabang::create($data);
                $id = KopCabang::find($create->id);

                $res = array(
                    'status' => TRUE,
                    'data' => $id,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => 'Maaf! Jaringan Anda tidak stabil'
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
