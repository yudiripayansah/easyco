<?php

namespace App\Http\Controllers;

use App\Models\KopCabang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    protected $user;

    public function create(Request $request)
    {
        $data = $request->all();

        $validate = KopCabang::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] == TRUE) {
            try {
                $create = KopCabang::create($data);
                $id = KopCabang::find($create->id);

                $res = array(
                    'status' => TRUE,
                    'data' => $id,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => $e->getMessage(),
                    'error' => NULL
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
        $sortBy = 'kode_cabang';
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

        $read = KopCabang::select('*')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($search != NULL) {
            $read->whereRaw("(kode_cabang LIKE '%" . $search . "%' OR nama_cabang LIKE '%" . $search . "%')");
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $id_cabang || $type) {
            $total = KopCabang::orderBy($sortBy, $sortDir);

            if ($search) {
                $total->whereRaw("(kode_cabang LIKE '%" . $search . "%' OR nama_cabang LIKE '%" . $search . "%')");
            }

            $total = $total->count();
        } else {
            $total = KopCabang::all()->count();
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
            $get = KopCabang::find($id);

            if ($get) {
                $res = array(
                    'status' => TRUE,
                    'data' => $get,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => 'Maaf! Data tidak ditemukan',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => 'Maaf! Cabang tidak bisa ditampilkan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopCabang::find($request->id);
        $validate = KopCabang::validateUpdate($request->all());

        $get->nama_cabang = $request->nama_cabang;
        $get->pimpinan_cabang = $request->pimpinan_cabang;

        DB::beginTransaction();

        if ($validate['status'] == TRUE) {
            try {
                $get->save();

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => $e->getMessage(),
                    'error' => NULL
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
            $data = KopCabang::find($id);

            try {
                $data->delete();

                $res = array(
                    'status' => true,
                    'data' => NULL,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => $e->getMessage(),
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => 'Maaf! Cabang tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
