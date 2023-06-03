<?php

namespace App\Http\Controllers;

use App\Models\KopAnggota;
use App\Models\KopCabang;
use App\Models\KopPembiayaan;
use App\Models\KopTabungan;
use App\Models\KopUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    protected $user;

    public function create(Request $request)
    {
        $data = $request->all();

        $data['nama_cabang'] = strtoupper($request->nama_cabang);
        $data['pimpinan_cabang'] = strtoupper($request->pimpinan_cabang);

        $validate = KopCabang::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopCabang::create($data);
                $find = KopCabang::find($create->id);

                $res = array(
                    'status' => TRUE,
                    'data' => $find,
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

    public function dashboard(Request $request)
    {
        $token = $request->header('token');
        $param = array('token' => $token);
        $get = KopUser::where($param)->first();
        $cabang = $get->kode_cabang;

        $param_anggota['status'] = 1;
        $param_outstanding['status_rekening'] = 1;
        $param_tabungan['status_rekening'] = 1;

        $pembiayaan = KopPembiayaan::select(DB::raw('SUM(saldo_pokok) AS saldo_outstanding'));
        $tabungan = KopTabungan::select(DB::raw('SUM(saldo) AS saldo_tabungan'));

        if ($cabang <> '00000') {
            $param_anggota['kode_cabang'] = $cabang;
            $pembiayaan = $pembiayaan->where(DB::raw('LEFT(no_rekening,5)'), $cabang);
            $tabungan = $tabungan->where(DB::raw('LEFT(no_rekening,5)'), $cabang);
        }

        $anggota = KopAnggota::where($param_anggota)->get();
        $pembiayaan = $pembiayaan->where($param_outstanding)->first();
        $tabungan = $tabungan->where($param_outstanding)->first();

        $hasil = array(
            'total_anggota' => $anggota->count(),
            'total_outstanding' => $pembiayaan['saldo_outstanding'] * 1,
            'total_tabungan' => $tabungan['saldo_tabungan'] * 1
        );

        $res = array(
            'status' => TRUE,
            'data' => $hasil,
            'msg' => 'Berhasil!',
            'error' => NULL
        );

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

        $token = $request->header('token');
        $param = array('token' => $token);
        $get = KopUser::where($param)->first();
        $cabang = $get->kode_cabang;

        if (isset($request->page)) {
            $page = $request->page;
        }

        if (isset($request->perPage)) {
            $perPage = $request->perPage;
        }

        if (isset($request->sortDir)) {
            $sortDir = $request->sortDir;
        }

        if (isset($request->sortBy)) {
            $sortBy = $request->sortBy;
        }

        if (isset($request->search)) {
            $search = strtoupper($request->search);
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopCabang::read($search, $cabang, $sortBy, $sortDir, $offset, $perPage);

        $data = array();

        foreach ($read as $rd) {
            $data[] = array(
                'id' =>  $rd->id,
                'kode_cabang' =>  $rd->kode_cabang,
                'nama_cabang' =>  $rd->nama_cabang,
                'induk_cabang' =>  $rd->induk_cabang,
                'jenis_cabang' =>  $rd->jenis_cabang,
                'pimpinan_cabang' =>  $rd->pimpinan_cabang
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

        $get->nama_cabang = strtoupper($request->nama_cabang);
        $get->induk_cabang = $request->induk_cabang;
        $get->jenis_cabang = $request->jenis_cabang;
        $get->pimpinan_cabang = strtoupper($request->pimpinan_cabang);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
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

            DB::beginTransaction();

            try {
                $data->delete();

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
                'msg' => 'Maaf! Cabang tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
