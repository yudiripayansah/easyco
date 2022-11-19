<?php

namespace App\Http\Controllers;

use App\Models\KopPrdTabungan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrdTabunganController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $validate = KopPrdTabungan::validateAdd($data);

        $data['nama_produk'] = strtoupper($request->nama_produk);
        $data['nama_singkat'] = strtoupper($request->nama_singkat);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopPrdTabungan::create($data);
                $find = KopPrdTabungan::find($create->id);

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
            $search = strtoupper($request->search);
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopPrdTabungan::select('*')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($search != NULL) {
            $read->whereRaw("(kode_produk LIKE '%" . $search . "%' OR nama_produk LIKE '%" . $search . "%' OR nama_singkat LIKE '%" . $search . "%')");
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $id_cabang || $type) {
            $total = KopPrdTabungan::orderBy($sortBy, $sortDir);

            if ($search) {
                $total->whereRaw("(kode_produk LIKE '%" . $search . "%' OR nama_produk LIKE '%" . $search . "%' OR nama_singkat LIKE '%" . $search . "%')");
            }

            $total = $total->count();
        } else {
            $total = KopPrdTabungan::all()->count();
        }

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        $res = array(
            'status' => TRUE,
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
            $get = KopPrdTabungan::find($id);

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
                'msg' => 'Maaf! Produk Tabungan tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopPrdTabungan::find($request->id);
        $validate = KopPrdTabungan::validateUpdate($request->all());

        $get->kode_gl = $request->kode_gl;
        $get->nama_produk = strtoupper($request->nama_produk);
        $get->nama_singkat = strtoupper($request->nama_singkat);
        $get->jenis_akad = $request->jenis_akad;
        $get->saldo_minimal = $request->saldo_minimal;
        $get->biaya_adm = $request->biaya_adm;
        $get->jenis_tabungan = $request->jenis_tabungan;
        $get->minimal_setoran = $request->minimal_setoran;
        $get->periode_setoran = $request->periode_setoran;
        $get->minimal_kontrak = $request->minimal_kontrak;
        $get->nisbah = $request->nisbah;

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
            $data = KopPrdTabungan::find($id);

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
                'msg' => 'Maaf! Produk Tabungan tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
