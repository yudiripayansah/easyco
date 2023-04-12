<?php

namespace App\Http\Controllers;

use App\Models\KopPegawai;
use App\Models\KopUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();

        $data['nama_pgw'] = strtoupper($request->nama_pgw);
        $data['alamat_pgw'] = strtoupper($request->alamat_pgw);
        $data['jabatan'] = strtoupper($request->jabatan);

        $validate = KopPegawai::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopPegawai::create($data);
                $find = KopPegawai::find($create->id);

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

    public function generate_kode_pegawai(Request $request)
    {
        $kode_cabang = $request->kode_cabang;

        $maximum = KopPegawai::generateKodePegawai($kode_cabang);

        $format = '0000';

        if ($maximum->count() == 0) {
            $val = 1;
        } else {
            $val = $maximum['kode_pgw'] + 1;
        }

        $kode = $format . $val;
        $kode = substr($kode, -4);

        $data = array('kode_pegawai' => $kode_cabang . $kode);

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
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
        $sortBy = 'tgl_gabung';
        $search = NULL;
        $total = 0;
        $totalPage = 1;

        $token = $request->header('token');
        $param = array('token' => $token);
        $get = KopUser::where($param)->first();
        $kode_cabang = $get->kode_cabang;

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

        if ($request->kode_cabang) {
            $kode_cabang = $request->kode_cabang;
        }

        if ($request->search) {
            $search = strtoupper($request->search);
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopPegawai::read($search, $sortBy, $sortDir, $offset, $perPage, $kode_cabang);

        $data = array();

        foreach ($read as $rd) {
            $data[] = array(
                'id' => $rd->id,
                'kode_cabang' => $rd->kode_cabang,
                'kode_pgw' => $rd->kode_pgw,
                'nama_pgw' => $rd->nama_pgw,
                'jenis_kelamin' => $rd->jenis_kelamin,
                'alamat_pgw' => $rd->alamat_pgw,
                'no_ktp' => $rd->no_ktp,
                'no_hp' => $rd->no_hp,
                'jabatan' => strtoupper($rd->kode_display),
                'tgl_gabung' => $rd->tgl_gabung
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
            $get = KopPegawai::find($id);

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
                'msg' => 'Maaf! Pegawai tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopPegawai::find($request->id);
        $validate = KopPegawai::validateUpdate($request->all());

        $get->kode_cabang = $request->kode_cabang;
        $get->nama_pgw = strtoupper($request->nama_pgw);
        $get->jenis_kelamin = $request->jenis_kelamin;
        $get->alamat_pgw = strtoupper($request->alamat_pgw);
        $get->no_ktp = $request->no_ktp;
        $get->no_hp = $request->no_hp;
        $get->jabatan = strtoupper($request->jabatan);
        $get->tgl_gabung = $request->tgl_gabung;

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
            $data = KopPegawai::find($id);

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
                'msg' => 'Maaf! Pegawai tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
