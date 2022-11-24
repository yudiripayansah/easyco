<?php

namespace App\Http\Controllers;

use App\Models\KopAnggota;
use App\Models\KopAnggotaUk;
use App\Models\KopLembaga;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
    function rembug(Request $request)
    {
        $kode_cabang = $request->kode_cabang;

        $show = KopAnggota::rembug($kode_cabang);

        $data = array();

        foreach ($show as $sh) {
            $kode_rembug = $sh->kode_rembug;
            $nama_rembug = $sh->nama_rembug;

            $data[] = array(
                'kode_rembug' => $kode_rembug,
                'nama_rembug' => $nama_rembug
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function simpanan_anggota()
    {
        $show = KopLembaga::first();

        $data = array(
            'simpok' => $show->simpok,
            'simwa' => $show->simwa
        );

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function create(Request $request)
    {
        $data = $request->all();

        $data2 = array(
            'p_nama' => strtoupper($request->p_nama),
            'p_tmplahir' => strtoupper($request->p_tmplahir),
            'p_tglahir' => $request->p_tglahir,
            'usia' => $request->usia,
            'p_noktp' => $request->p_noktp,
            'p_nohp' => $request->p_nohp,
            'p_pendidikan' => $request->p_pendidikan,
            'p_pekerjaan' => $request->p_pekerjaan,
            'p_ketpekerjaan' => strtoupper($request->p_ketpekerjaan),
            'p_pendapatan' => $request->p_pendapatan,
            'jml_anak' => $request->jml_anak,
            'jml_tanggungan' => $request->jml_tanggungan,
            'rumah_status' => $request->rumah_status,
            'rumah_ukuran' => $request->rumah_ukuran,
            'rumah_atap' => $request->rumah_atap,
            'rumah_dinding' => $request->rumah_dinding,
            'rumah_lantai' => $request->rumah_lantai,
            'rumah_jamban' => $request->rumah_jamban,
            'rumah_air' => $request->rumah_air,
            'lahan_sawah' => $request->lahan_sawah,
            'lahan_kebun' => $request->lahan_kebun,
            'lahan_pekarangan' => $request->lahan_pekarangan,
            'ternak_sapi' => $request->ternak_sapi,
            'ternak_domba' => $request->ternak_domba,
            'ternak_unggas' => $request->ternak_unggas,
            'elc_kulkas' => $request->elc_kulkas,
            'elc_tv' => $request->elc_tv,
            'elc_hp' => $request->elc_hp,
            'kend_sepeda' => $request->kend_sepeda,
            'kend_motor' => $request->kend_motor,
            'ush_rumahtangga' => $request->ush_rumahtangga,
            'ush_komoditi' => strtoupper($request->ush_komoditi),
            'ush_lokasi' => strtoupper($request->ush_lokasi),
            'ush_omset' => $request->ush_omset,
            'by_beras' => $request->by_beras,
            'by_dapur' => $request->by_dapur,
            'by_listrik' => $request->by_listrik,
            'by_telpon' => $request->by_telpon,
            'by_sekolah' => $request->by_sekolah,
            'by_lain' => $request->by_lain
        );

        $data['nama_anggota'] = strtoupper($request->nama_anggota);
        $data['ibu_kandung'] = strtoupper($request->ibu_kandung);
        $data['tempat_lahir'] = strtoupper($request->tempat_lahir);
        $data['alamat'] = strtoupper($request->alamat);
        $data['desa'] = strtoupper($request->desa);
        $data['kecamatan'] = strtoupper($request->kecamatan);
        $data['kabupaten'] = strtoupper($request->kabupaten);
        $data['nama_pasangan'] = strtoupper($request->nama_pasangan);
        $data['ket_pekerjaan'] = strtoupper($request->ket_pekerjaan);
        $data['tgl_gabung'] = date('Y-m-d');

        $validate = KopAnggota::validateAdd($data);
        $validate2 = KopAnggotaUk::validateAdd($data2);

        DB::beginTransaction();

        if ($validate['status'] === TRUE or $validate2['status'] === TRUE) {
            try {
                $create = KopAnggota::create($data);
                $find = KopAnggota::find($create->id);

                $finds = array('find' => $find);

                $data2['no_anggota'] = $find->no_anggota;

                $create2 = KopAnggotaUk::create($data2);
                $find2 = KopAnggotaUk::find($create2->id);

                $finds['find2'] = $find2;

                $res = array(
                    'status' => TRUE,
                    'data' => $finds,
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
            $msg = array(
                'validate' => $validate['msg'],
                'validate2' => $validate2['msg']
            );

            $error = array(
                'error' => $validate['errors'],
                'error2' => $validate2['errors']
            );

            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => $msg,
                'error' => $error
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
        $sortBy = 'kop_anggota.no_anggota';
        $search = NULL;
        $total = 0;
        $totalPage = 1;
        $cabang = NULL;
        $status = NULL;
        $from = NULL;
        $to = NULL;

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

        if ($request->status) {
            $status = $request->status;
        }

        if ($request->type) {
            $type = $request->type;
        }

        if ($request->cabang) {
            $cabang = $request->cabang;
        }

        if ($request->from) {
            $from = $request->from;
        }

        if ($request->to) {
            $to = $request->to;
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopAnggota::select('kop_anggota.*','kop_cabang.nama_cabang','kop_rembug.nama_rembug')
                ->orderBy($sortBy, $sortDir)
                ->join('kop_cabang','kop_cabang.kode_cabang','kop_anggota.kode_cabang','left')
                ->join('kop_rembug','kop_rembug.kode_rembug','kop_anggota.kode_rembug','left');

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($status && $status != '~') {
            $read->where('kop_anggota.status', $status);
        }

        if ($cabang) {
            $read->where('kop_anggota.kode_cabang', $cabang);
        }

        if ($search) {
            $read->where('kop_anggota.no_anggota', 'LIKE', '%' . $search . '%')->orWhere('kop_anggota.nama_anggota', 'LIKE', '%' . $search . '%');
        }

        if($from && $to) {
            $read->whereBetween('kop_anggota.tgl_gabung', [$from, $to]);
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $cabang || $status || ($from && $to)) {
            $total = KopAnggota::orderBy($sortBy, $sortDir);

            if ($search && $search != NULL) {
                $total->where('kop_anggota.no_anggota', 'LIKE', '%' . $search . '%')->orWhere('kop_anggota.nama_anggota', 'LIKE', '%' . $search . '%');
            }

            if ($status && $status != NULL && $status != '~') {
                $total->where('kop_anggota.status', $status);
            }
    
            if ($cabang && $cabang != NULL) {
                $total->where('kop_anggota.kode_cabang', $cabang);
            }

            if($from && $to) {
                $total->whereBetween('kop_anggota.tgl_gabung', [$from, $to]);
            }

            $total = $total->count();
        } else {
            $total = KopAnggota::all()->count();
        }

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        foreach($read as $row) {
            $row->tgl_gabung = date('d-F-Y',strtotime($row->tgl_gabung));
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
            $get = KopAnggota::find($id);

            $param = array('no_anggota' => $get->no_anggota);

            $get2 = KopAnggotaUk::where($param)->first();

            $data = array(
                'anggota' => $get,
                'anggotauk' => $get2
            );

            if ($get) {
                $res = array(
                    'status' => TRUE,
                    'data' => $data,
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
                'msg' => 'Maaf! Anggota tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopAnggota::find($request->id);
        $validate = KopAnggota::validateUpdate($request->all());

        $get->nama_anggota = strtoupper($request->nama_anggota);
        $get->jenis_kelamin = $request->jenis_kelamin;
        $get->ibu_kandung = strtoupper($request->ibu_kandung);
        $get->tempat_lahir = strtoupper($request->tempat_lahir);
        $get->tgl_lahir = $request->tgl_lahir;
        $get->alamat = strtoupper($request->alamat);
        $get->desa = strtoupper($request->desa);
        $get->kecamatan = strtoupper($request->kecamatan);
        $get->kabupaten = strtoupper($request->kabupaten);
        $get->kodepos = $request->kodepos;
        $get->no_ktp = $request->no_ktp;
        $get->no_npwp = $request->no_npwp;
        $get->no_telp = $request->no_telp;
        $get->pendidikan = $request->pendidikan;
        $get->status_perkawinan = $request->status_perkawinan;
        $get->nama_pasangan = strtoupper($request->nama_pasangan);
        $get->pekerjaan = $request->pekerjaan;
        $get->ket_pekerjaan = $request->ket_pekerjaan;
        $get->pendapatan_perbulan = $request->pendapatan_perbulan;
        $get->tgl_gabung = $request->tgl_gabung;
        $get->simpok = $request->simpok;
        $get->simwa = $request->simwa;
        $get->status = $request->status;

        $param = array('no_anggota' => $get->no_anggota);

        $get2 = KopAnggotaUk::where($param)->first();

        $get2->id = $get2->id;
        $get2->p_nama = strtoupper($request->p_nama);
        $get2->p_tmplahir = strtoupper($request->p_tmplahir);
        $get2->p_tglahir = $request->p_tglahir;
        $get2->usia = $request->usia;
        $get2->p_noktp = $request->p_noktp;
        $get2->p_nohp = $request->p_nohp;
        $get2->p_pendidikan = $request->p_pendidikan;
        $get2->p_pekerjaan = $request->p_pekerjaan;
        $get2->p_ketpekerjaan = strtoupper($request->p_ketpekerjaan);
        $get2->p_pendapatan = $request->p_pendapatan;
        $get2->jml_anak = $request->jml_anak;
        $get2->jml_tanggungan = $request->jml_tanggungan;
        $get2->rumah_status = $request->rumah_status;
        $get2->rumah_ukuran = $request->rumah_ukuran;
        $get2->rumah_atap = $request->rumah_atap;
        $get2->rumah_dinding = $request->rumah_dinding;
        $get2->rumah_lantai = $request->rumah_lantai;
        $get2->rumah_jamban = $request->rumah_jamban;
        $get2->rumah_air = $request->rumah_air;
        $get2->lahan_sawah = $request->lahan_sawah;
        $get2->lahan_kebun = $request->lahan_kebun;
        $get2->lahan_pekarangan = $request->lahan_pekarangan;
        $get2->ternak_sapi = $request->ternak_sapi;
        $get2->ternak_domba = $request->ternak_domba;
        $get2->ternak_unggas = $request->ternak_unggas;
        $get2->elc_kulkas = $request->elc_kulkas;
        $get2->elc_tv = $request->elc_tv;
        $get2->elc_hp = $request->elc_hp;
        $get2->kend_sepeda = $request->kend_sepeda;
        $get2->kend_motor = $request->kend_motor;
        $get2->ush_rumahtangga = $request->ush_rumahtangga;
        $get2->ush_komoditi = strtoupper($request->ush_komoditi);
        $get2->ush_lokasi = strtoupper($request->ush_lokasi);
        $get2->ush_omset = $request->ush_omset;
        $get2->by_beras = $request->by_beras;
        $get2->by_dapur = $request->by_dapur;
        $get2->by_listrik = $request->by_listrik;
        $get2->by_telpon = $request->by_telpon;
        $get2->by_sekolah = $request->by_sekolah;
        $get2->by_lain = $request->by_lain;

        $data = array(
            'p_nama' => $request->p_nama,
            'p_tmplahir' => $request->p_tmplahir,
            'p_tglahir' => $request->p_tglahir,
            'usia' => $request->usia,
            'p_noktp' => $request->p_noktp,
            'p_nohp' => $request->p_nohp,
            'p_pendidikan' => $request->p_pendidikan,
            'p_pekerjaan' => $request->p_pekerjaan,
            'p_ketpekerjaan' => $request->p_ketpekerjaan,
            'p_pendapatan' => $request->p_pendapatan,
            'jml_anak' => $request->jml_anak,
            'jml_tanggungan' => $request->jml_tanggungan,
            'rumah_status' => $request->rumah_status,
            'rumah_ukuran' => $request->rumah_ukuran,
            'rumah_atap' => $request->rumah_atap,
            'rumah_dinding' => $request->rumah_dinding,
            'rumah_lantai' => $request->rumah_lantai,
            'rumah_jamban' => $request->rumah_jamban,
            'rumah_air' => $request->rumah_air,
            'lahan_sawah' => $request->lahan_sawah,
            'lahan_kebun' => $request->lahan_kebun,
            'lahan_pekarangan' => $request->lahan_pekarangan,
            'ternak_sapi' => $request->ternak_sapi,
            'ternak_domba' => $request->ternak_domba,
            'ternak_unggas' => $request->ternak_unggas,
            'elc_kulkas' => $request->elc_kulkas,
            'elc_tv' => $request->elc_tv,
            'elc_hp' => $request->elc_hp,
            'kend_sepeda' => $request->kend_sepeda,
            'kend_motor' => $request->kend_motor,
            'ush_rumahtangga' => $request->ush_rumahtangga,
            'ush_komoditi' => $request->ush_komoditi,
            'ush_lokasi' => $request->ush_lokasi,
            'ush_omset' => $request->ush_omset,
            'by_beras' => $request->by_beras,
            'by_dapur' => $request->by_dapur,
            'by_listrik' => $request->by_listrik,
            'by_telpon' => $request->by_telpon,
            'by_sekolah' => $request->by_sekolah,
            'by_lain' => $request->by_lain
        );

        $validate2 = KopAnggotaUk::validateUpdate($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE or $validate2['status'] === TRUE) {
            try {
                $get->save();
                $get2->save();

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
            $data = KopAnggota::find($id);

            $param = array('no_anggota' => $data->no_anggota);

            $data2 = KopAnggotaUk::where($param)->first();

            DB::beginTransaction();

            try {
                $data2->delete();
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
                'msg' => 'Maaf! Anggota tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
