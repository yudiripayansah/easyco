<?php

namespace App\Http\Controllers;

use App\Models\KopAnggotaMutasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaMutasiController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $validate = KopAnggotaMutasi::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] == TRUE) {
            try {
                $create = KopAnggotaMutasi::create($data);
                $id = KopAnggotaMutasi::find($create->id);

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
        $sortBy = 'no_anggota';
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

        $read = KopAnggotaMutasi::select('*')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($search != NULL) {
            $read->whereRaw("(no_anggota LIKE '%" . $search . "%')");
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $id_cabang || $type) {
            $total = KopAnggotaMutasi::orderBy($sortBy, $sortDir);

            if ($search) {
                $total->whereRaw("(no_anggota LIKE '%" . $search . "%')");
            }

            $total = $total->count();
        } else {
            $total = KopAnggotaMutasi::all()->count();
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
            $get = KopAnggotaMutasi::find($id);

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
                'msg' => 'Maaf! Anggota Mutasi tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopAnggotaMutasi::find($request->id);
        $validate = KopAnggotaMutasi::validateUpdate($request->all());

        $get->jenis_mutasi = $request->jenis_mutasi;
        $get->alasan_mutasi = $request->alasan_mutasi;
        $get->keterangan_mutasi = $request->keterangan_mutasi;
        $get->kode_rembug = $request->kode_rembug;
        $get->kode_rembug_baru = $request->kode_rembug_baru;
        $get->tanggal_mutasi = $request->tanggal_mutasi;
        $get->saldo_pokok = $request->saldo_pokok;
        $get->saldo_margin = $request->saldo_margin;
        $get->saldo_catab = $request->saldo_catab;
        $get->saldo_minggon = $request->saldo_minggon;
        $get->saldo_sukarela = $request->saldo_sukarela;
        $get->saldo_tab_berencana = $request->saldo_tab_berencana;
        $get->saldo_deposito = $request->saldo_deposito;
        $get->saldo_simpok = $request->saldo_simpok;
        $get->saldo_simwa = $request->saldo_simwa;
        $get->bonus_bagihasil = $request->bonus_bagihasil;
        $get->setoran_tambahan = $request->setoran_tambahan;
        $get->penarikan_sukarela = $request->penarikan_sukarela;
        $get->flag_saldo_margin = $request->flag_saldo_margin;
        $get->flag_saldo_catab = $request->flag_saldo_catab;
        $get->status_mutasi = $request->status_mutasi;
        $get->kode_petugas = $request->kode_petugas;

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
            $data = KopAnggotaMutasi::find($id);

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
                'msg' => 'Maaf! Anggota Mutasi tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
