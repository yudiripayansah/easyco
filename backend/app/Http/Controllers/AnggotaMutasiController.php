<?php

namespace App\Http\Controllers;

use App\Models\KopAnggota;
use App\Models\KopAnggotaMutasi;
use App\Models\KopUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaMutasiController extends Controller
{
    function saldo_anggota(Request $request)
    {
        $data = KopAnggotaMutasi::get_saldo_keluar($request->no_anggota);

        $saldo = array(
            'saldo_pokok' => (int)$data['saldo_pokok'],
            'saldo_margin' => (int)$data['saldo_margin'],
            'saldo_catab' => (int)$data['saldo_catab'],
            'saldo_minggon' => (int)$data['saldo_minggon'],
            'simpok' => (int)$data['simpok'],
            'simwa' => (int)$data['simwa'],
            'simsuk' => (int)$data['simsuk'],
            'saldo_tabungan' => (int)$data['saldo_tabungan'],
            'saldo_deposito' => (int)$data['saldo_deposito'],
            'bonus_bagihasil' => (int)$data['bonus_bagihasil']
        );

        $res = array(
            'status' => TRUE,
            'data' => $saldo,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function create(Request $request)
    {
        $data = $request->all();

        $data['keterangan_mutasi'] = strtoupper($request->keterangan_mutasi);
        $data['tanggal_mutasi'] = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_mutasi)));
        $data['saldo_simwa'] = $request->simwa;
        $data['saldo_simpok'] = $request->simpok;
        $data['saldo_sukarela'] = $request->simsuk;
        $data['saldo_tab_berencaa=na'] = $request->tabungan;

        $validate = KopAnggotaMutasi::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopAnggotaMutasi::create($data);
                $find = KopAnggotaMutasi::find($create->id);

                $param = array('no_anggota' => $request->no_anggota);
                $anggota = KopAnggota::where($param)->first();
                $get = KopAnggota::find($anggota->id);
                $get->status = 3;
                $get->save();

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
        $sortBy = 'ka.no_anggota';
        $search = NULL;
        $total = 0;
        $totalPage = 1;
        $type = NULL;
        $rembug = '~';

        $token = $request->header('token');
        $param = array('token' => $token);
        $get = KopUser::where($param)->first();
        $cabang = $get->kode_cabang;

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

        if ($request->cabang) {
            $cabang = $request->cabang;
        }

        if ($request->rembug) {
            $rembug = $request->rembug;
        }

        if ($request->search) {
            $search = strtoupper($request->search);
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopAnggotaMutasi::select('kop_anggota_mutasi.*', 'ka.nama_anggota', 'kr.nama_rembug')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kop_anggota_mutasi.no_anggota')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'ka.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
            ->where('status_mutasi', $request->status)
            ->orderBy($sortBy, $sortDir);

        if ($cabang != '00000') {
            $read->where('ka.kode_cabang', $cabang);
        }

        if ($rembug != '~') {
            $read->where('ka.kode_rembug', $rembug);
        }

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($search != NULL) {
            $read->whereRaw("(ka.no_anggota LIKE '%" . $search . "%')");
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $rembug || $type) {
            $total = KopAnggotaMutasi::where('status_mutasi', $request->status)
                ->join('kop_anggota AS ka', 'ka.no_anggota', 'kop_anggota_mutasi.no_anggota')
                ->join('kop_cabang AS kc', 'kc.kode_cabang', 'ka.kode_cabang')
                ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
                ->orderBy($sortBy, $sortDir);

            if ($cabang != '00000') {
                $total->where('ka.kode_cabang', $cabang);
            }

            if ($rembug != '~') {
                $total->where('ka.kode_rembug', $rembug);
            }

            if ($search) {
                $total->whereRaw("(ka.no_anggota LIKE '%" . $search . "%')");
            }

            $total = $total->count();
        } else {
            $total = KopAnggotaMutasi::all()->count();
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
        $get->keterangan_mutasi = strtoupper($request->keterangan_mutasi);
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
            $data = KopAnggotaMutasi::find($id);

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
                'msg' => 'Maaf! Anggota Mutasi tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function approve(Request $request)
    {
        $get = KopAnggotaMutasi::find($request->id);

        $get->status_mutasi = 1;

        $get->save();

        $res = array(
            'status' => TRUE,
            'data' => NULL,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    public function reject(Request $request)
    {
        $get = KopAnggotaMutasi::find($request->id);

        $anggota = KopAnggota::where('no_anggota', $get->no_anggota)->first();
        $getAnggota = KopAnggota::find($anggota->id);
        $getAnggota->status = 1;

        $get->delete();
        $getAnggota->save();

        $res = array(
            'status' => TRUE,
            'data' => NULL,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }
}
