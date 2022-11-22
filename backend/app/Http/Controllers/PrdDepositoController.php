<?php

namespace App\Http\Controllers;

use App\Models\KopPrdDeposito;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrdDepositoController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $validate = KopPrdDeposito::validateAdd($data);

        $data['nama_produk'] = strtoupper($request->nama_produk);
        $data['nama_singkat'] = strtoupper($request->nama_singkat);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopPrdDeposito::create($data);
                $find = KopPrdDeposito::find($create->id);

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

    public function read(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'kode_produk';
        $search = NULL;
        $total = 0;
        $totalPage = 1;

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

        if ($request->search) {
            $search = strtoupper($request->search);
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopPrdDeposito::read($search, $sortBy, $sortDir, $offset, $perPage);

        $data = array();

        foreach ($read as $rd) {
            $data[] = array(
                'id' => $rd->id,
                'kode_produk' => $rd->kode_produk,
                'kode_gl' => $rd->kode_gl,
                'nama_produk' => $rd->nama_produk,
                'nama_singkat' => $rd->nama_singkat,
                'periode_setoran' => $rd->periode_setoran,
                'jangka_waktu' => $rd->jangka_waktu,
                'minimal_setoran' => $rd->minimal_setoran,
                'nisbah' => $rd->nisbah,
                'persen_pajak' => $rd->persen_pajak
            );
        }

        $total = $read->count();

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'page' => $page,
            'perPage' => $perPage,
            'sortDir' => $sortDir,
            'sortBy' => $sortBy,
            'search' => $search,
            'total' => $total,
            'totalPage' => $totalPage,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $get = KopPrdDeposito::find($id);

            if ($get) {
                $res = array(
                    'status' => TRUE,
                    'data' => $get,
                    'msg' => 'Berhasil!'
                );
            } else {
                $res = array(
                    'status' => FALSE,
                    'msg' => 'Maaf! Data tidak ditemukan'
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'msg' => 'Maaf! Produk Deposito tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopPrdDeposito::find($request->id);
        $validate = KopPrdDeposito::validateUpdate($request->all());

        $get->kode_gl = $request->kode_gl;
        $get->nama_produk = strtoupper($request->nama_produk);
        $get->nama_singkat = strtoupper($request->nama_singkat);
        $get->periode_setoran = $request->periode_setoran;
        $get->jangka_waktu = $request->jangka_waktu;
        $get->minimal_setoran = $request->minimal_setoran;
        $get->nisbah = $request->nisbah;
        $get->persen_pajak = $request->persen_pajak;

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $get->save();

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
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $data = KopPrdDeposito::find($id);

            DB::beginTransaction();

            try {
                $data->delete();

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
        } else {
            $res = array(
                'status' => FALSE,
                'msg' => 'Maaf! Produk Deposito tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
