<?php

namespace App\Http\Controllers;

use App\Models\KopPrdPembiayaan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrdPembiayaanController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $validate = KopPrdPembiayaan::validateAdd($data);

        $data['nama_produk'] = strtoupper($request->nama_produk);
        $data['nama_singkat'] = strtoupper($request->nama_singkat);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopPrdPembiayaan::create($data);
                $find = KopPrdPembiayaan::find($create->id);

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

        $read = KopPrdPembiayaan::read($search, $sortBy, $sortDir, $offset, $perPage);

        $data = array();

        foreach ($read as $rd) {
            $data[] = array(
                'id' => $rd->id,
                'kode_produk' => $rd->kode_produk,
                'kode_akad' => $rd->kode_akad,
                'kode_gl' => $rd->kode_gl,
                'nama_produk' => $rd->nama_produk,
                'nama_singkat' => $rd->nama_singkat,
                'periode_angsuran' => $rd->periode_angsuran,
                'jangka_waktu' => $rd->jangka_waktu,
                'biaya_adm' => $rd->biaya_adm,
                'flag_wakalah' => $rd->flag_wakalah,
                'flag_pdd' => $rd->flag_pdd
            );
        }

        $total = $read->count();

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
            $get = KopPrdPembiayaan::find($id);

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
                'msg' => 'Maaf! Produk Pembiayaan tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopPrdPembiayaan::find($request->id);
        $validate = KopPrdPembiayaan::validateUpdate($request->all());

        $get->kode_akad = $request->kode_akad;
        $get->kode_gl = $request->kode_gl;
        $get->nama_produk = strtoupper($request->nama_produk);
        $get->nama_singkat = strtoupper($request->nama_singkat);
        $get->periode_angsuran = $request->periode_angsuran;
        $get->jangka_waktu = $request->jangka_waktu;
        $get->biaya_adm = $request->biaya_adm;
        $get->flag_wakalah = $request->flag_wakalah;
        $get->flag_pdd = $request->flag_pdd;

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
            $data = KopPrdPembiayaan::find($id);

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
                'msg' => 'Maaf! Produk Pembiayaan tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
