<?php

namespace App\Http\Controllers;

use App\Models\KopAnggotaUk;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaUkController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $data['p_nama'] = strtoupper($request->p_nama);
        $data['p_tmplahir'] = strtoupper($request->p_tmplahir);
        $data['p_ketpekerjaan'] = strtoupper($request->p_ketpekerjaan);
        $data['ush_komoditi'] = strtoupper($request->ush_komoditi);
        $data['ush_lokasi'] = strtoupper($request->ush_lokasi);

        $validate = KopAnggotaUk::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopAnggotaUk::create($data);
                $id = KopAnggotaUk::find($create->id);

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
            $search = strtoupper($request->search);
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopAnggotaUk::select('*')->orderBy($sortBy, $sortDir);

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
            $total = KopAnggotaUk::orderBy($sortBy, $sortDir);

            if ($search) {
                $total->whereRaw("(no_anggota LIKE '%" . $search . "%')");
            }

            $total = $total->count();
        } else {
            $total = KopAnggotaUk::all()->count();
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
            $get = KopAnggotaUk::find($id);

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
                'msg' => 'Maaf! Anggota UK tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopAnggotaUk::find($request->id);
        $validate = KopAnggotaUk::validateUpdate($request->all());

        $get->p_nama = strtoupper($request->p_nama);
        $get->p_tmplahir = strtoupper($request->p_tmplahir);
        $get->p_tglahir = $request->p_tglahir;
        $get->usia = $request->usia;
        $get->p_noktp = $request->p_noktp;
        $get->p_nohp = $request->p_nohp;
        $get->p_pendidikan = $request->p_pendidikan;
        $get->p_pekerjaan = $request->p_pekerjaan;
        $get->p_ketpekerjaan = strtoupper($request->p_ketpekerjaan);
        $get->p_pendapatan = $request->p_pendapatan;
        $get->jml_anak = $request->jml_anak;
        $get->jml_tanggungan = $request->jml_tanggungan;
        $get->rumah_status = $request->rumah_status;
        $get->rumah_ukuran = $request->rumah_ukuran;
        $get->rumah_atap = $request->rumah_atap;
        $get->rumah_dinding = $request->rumah_dinding;
        $get->rumah_lantai = $request->rumah_lantai;
        $get->rumah_jamban = $request->rumah_jamban;
        $get->rumah_air = $request->rumah_air;
        $get->lahan_sawah = $request->lahan_sawah;
        $get->lahan_kebun = $request->lahan_kebun;
        $get->lahan_pekarangan = $request->lahan_pekarangan;
        $get->ternak_sapi = $request->ternak_sapi;
        $get->ternak_domba = $request->ternak_domba;
        $get->ternak_unggas = $request->ternak_unggas;
        $get->elc_kulkas = $request->elc_kulkas;
        $get->elc_tv = $request->elc_tv;
        $get->elc_hp = $request->elc_hp;
        $get->kend_sepeda = $request->kend_sepeda;
        $get->kend_motor = $request->kend_motor;
        $get->ush_rumahtangga = $request->ush_rumahtangga;
        $get->ush_komoditi = strtoupper($request->ush_komoditi);
        $get->ush_lokasi = strtoupper($request->ush_lokasi);
        $get->ush_omset = $request->ush_omset;
        $get->by_beras = $request->by_beras;
        $get->by_dapur = $request->by_dapur;
        $get->by_listrik = $request->by_listrik;
        $get->by_telpon = $request->by_telpon;
        $get->by_sekolah = $request->by_sekolah;
        $get->by_lain = $request->by_lain;

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
            $data = KopAnggotaUk::find($id);

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
                'msg' => 'Maaf! Anggota UK tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
