<?php

namespace App\Http\Controllers;

use App\Models\KopLembaga;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LembagaController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $data['nama_kop'] = strtoupper($request->nama_kop);
        $data['alamat_kop'] = strtoupper($request->alamat_kop);
        $data['tagline_kop'] = strtoupper($request->tagline_kop);

        $validate = KopLembaga::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopLembaga::create($data);
                $find = KopLembaga::find($create->id);

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
        $sortBy = 'kode_kop';
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

        $read = KopLembaga::read($search, $sortBy, $sortDir, $offset, $perPage);

        $data = array();

        foreach ($read as $rd) {
            $data[] = array(
                'id' => $rd->id,
                'kode_kop' => $rd->kode_kop,
                'nama_kop' => $rd->nama_kop,
                'alamat_kop' => $rd->alamat_kop,
                'nik_kop' => $rd->nik_kop,
                'simpok' => $rd->simpok,
                'simwa' => $rd->simwa,
                'gl_simpok' => $rd->gl_simpok,
                'gl_simwa' => $rd->gl_simwa,
                'gl_simsuk' => $rd->gl_simsuk,
                'tagline_kop' => $rd->tagline_kop
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
            $get = KopLembaga::find($id);

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
                'msg' => 'Maaf! Lembaga tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopLembaga::find($request->id);
        $validate = KopLembaga::validateUpdate($request->all());

        $get->nama_kop = strtoupper($request->nama_kop);
        $get->alamat_kop = strtoupper($request->alamat_kop);
        $get->nik_kop = $request->nik_kop;
        $get->simpok = $request->simpok;
        $get->simwa = $request->simwa;
        $get->gl_simpok = $request->gl_simpok;
        $get->gl_simwa = $request->gl_simwa;
        $get->gl_simsuk = $request->gl_simsuk;
        $get->tagline_kop = strtoupper($request->tagline_kop);

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
            $data = KopLembaga::find($id);

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
                'msg' => 'Maaf! Lembaga tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
