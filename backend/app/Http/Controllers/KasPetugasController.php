<?php

namespace App\Http\Controllers;

use App\Models\KopKasPetugas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasPetugasController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $validate = KopKasPetugas::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] == TRUE) {
            try {
                $create = KopKasPetugas::create($data);
                $id = KopKasPetugas::find($create->id);

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
        $sortBy = 'kode_kas_petugas';
        $search = NULL;
        $total = 0;
        $totalPage = 1;
        $type = NULL;
        $id_cabang = NULL;

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
            $search = $request->search;
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopKasPetugas::select('*')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($search != NULL) {
            $read->whereRaw("(kode_kas_petugas LIKE '%" . $search . "%' OR kode_petugas LIKE '%" . $search . "%' OR nama_kas_petugas LIKE '%" . $search . "%')");
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $id_cabang || $type) {
            $total = KopKasPetugas::orderBy($sortBy, $sortDir);

            if ($search) {
                $total->whereRaw("(kode_kas_petugas LIKE '%" . $search . "%' OR kode_petugas LIKE '%" . $search . "%' OR nama_kas_petugas LIKE '%" . $search . "%')");
            }

            $total = $total->count();
        } else {
            $total = KopKasPetugas::all()->count();
        }

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        $res = array(
            'status' => true,
            'data' => $read,
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
            $get = KopKasPetugas::find($id);

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
                'msg' => 'Maaf! Kas Petugas tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopKasPetugas::find($request->id);
        $validate = KopKasPetugas::validateUpdate($request->all());

        $get->id_user = $request->id_user;
        $get->kode_kas_petugas = $request->kode_kas_petugas;
        $get->kode_petugas = $request->kode_petugas;
        $get->kode_gl = $request->kode_gl;
        $get->nama_kas_petugas = $request->nama_kas_petugas;
        $get->jenis_kas_petugas = $request->jenis_kas_petugas;

        DB::beginTransaction();

        if ($validate['status'] == TRUE) {
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
            $data = KopKasPetugas::find($id);

            try {
                $data->delete();

                $res = array(
                    'status' => true,
                    'data' => NULL,
                    'msg' => 'Berhasil!'
                );
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
                'msg' => 'Maaf! GL tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
