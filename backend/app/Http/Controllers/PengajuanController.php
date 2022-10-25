<?php

namespace App\Http\Controllers;

use App\Models\KopPengajuan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $validate = KopPengajuan::validateAdd($data);

        $data['keterangan_peruntukan'] = strtoupper($request->keterangan_peruntukan);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopPengajuan::create($data);
                $id = KopPengajuan::find($create->id);

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
        $sortBy = 'no_pengajuan';
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

        $read = KopPengajuan::select('*')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($search != NULL) {
            $read->whereRaw("(no_anggota LIKE '%" . $search . "%' OR no_pengajuan LIKE '%" . $search . "%')");
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $id_cabang || $type) {
            $total = KopPengajuan::orderBy($sortBy, $sortDir);

            if ($search) {
                $total->whereRaw("(no_anggota LIKE '%" . $search . "%' OR no_pengajuan LIKE '%" . $search . "%')");
            }

            $total = $total->count();
        } else {
            $total = KopPengajuan::all()->count();
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
            $get = KopPengajuan::find($id);

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
                'msg' => 'Maaf! Pengajuan tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopPengajuan::find($request->id);
        $validate = KopPengajuan::validateUpdate($request->all());

        $get->kode_petugas = $request->kode_petugas;
        $get->tanggal_pengajuan = $request->tanggal_pengajuan;
        $get->jumlah_pengajuan = $request->jumlah_pengajuan;
        $get->pengajuan_ke = $request->pengajuan_ke;
        $get->peruntukan = $request->peruntukan;
        $get->keterangan_peruntukan = strtoupper($request->keterangan_peruntukan);
        $get->rencana_droping = $request->rencana_droping;
        $get->rencana_periode_jwaktu = $request->rencana_periode_jwaktu;
        $get->jenis_pembiayaan = $request->jenis_pembiayaan;
        $get->sumber_pengembalian = $request->sumber_pengembalian;
        $get->doc_ktp = $request->doc_ktp;
        $get->doc_kk = $request->doc_kk;
        $get->doc_pendukung = $request->doc_pendukung;
        $get->ttd_anggota = $request->ttd_anggota;
        $get->ttd_suami = $request->ttd_suami;
        $get->ttd_ketua_majelis = $request->ttd_ketua_majelis;
        $get->ttd_tpl = $request->ttd_tpl;

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
            $data = KopPengajuan::find($id);

            try {
                $data->delete();

                $res = array(
                    'status' => TRUE,
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
                'msg' => 'Maaf! Pengajuan tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
