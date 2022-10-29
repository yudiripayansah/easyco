<?php

namespace App\Http\Controllers;

use App\Models\KopPembiayaan;
use App\Models\KopPengajuan;
use App\Models\KopUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrasiAkadController extends Controller
{
    function rembug(Request $request)
    {
        $token = $request->header('token');

        $param = array('token' => $token);

        $get = KopUser::where($param)->first();

        $show = KopPembiayaan::rembug($get->kode_cabang);

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

    function pengajuan(Request $request)
    {
        $kode_rembug = $request->kode_rembug;

        $show = KopPembiayaan::pengajuan($kode_rembug);

        $data = array();

        foreach ($show as $sh) {
            $no_pengajuan = $sh->no_pengajuan;
            $nama_anggota = $sh->nama_anggota;
            $jumlah_pengajuan = $sh->jumlah_pengajuan;
            $tanggal_pengajuan = $sh->tanggal_pengajuan;
            $rencana_droping = $sh->rencana_droping;
            $peruntukan = $sh->peruntukan;

            $data[] = array(
                'no_pengajuan' => $no_pengajuan,
                'nama_anggota' => $nama_anggota,
                'jumlah_pengajuan' => str_replace('.00', '', $jumlah_pengajuan),
                'tanggal_pengajuan' => date('d/m/Y', strtotime($tanggal_pengajuan)),
                'rencana_droping' => date('d/m/Y', strtotime($rencana_droping)),
                'peruntukan' => $peruntukan
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

    function fa(Request $request)
    {
        $token = $request->header('token');

        $param = array('token' => $token);

        $get = KopUser::where($param)->first();

        $show = KopPembiayaan::fa($get->kode_cabang);

        $data = array();

        foreach ($show as $sh) {
            $kode_petugas = $sh->kode_petugas;
            $nama_kas_petugas = $sh->nama_kas_petugas;

            $data[] = array(
                'kode_petugas' => $kode_petugas,
                'nama_kas_petugas' => $nama_kas_petugas
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

    function peruntukan()
    {
        $show = KopPembiayaan::peruntukan('peruntukan');

        $data = array();

        foreach ($show as $sh) {
            $kode_value = $sh->kode_value;
            $kode_display = $sh->kode_display;

            $data[] = array(
                'kode_value' => $kode_value,
                'kode_display' => $kode_display
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

    function product()
    {
        $show = KopPembiayaan::product();

        $data = array();

        foreach ($show as $sh) {
            $kode_produk = $sh->kode_produk;
            $kode_akad = $sh->kode_akad;
            $nama_produk = $sh->nama_produk;

            $data[] = array(
                'kode_produk' => $kode_produk,
                'kode_akad' => $kode_akad,
                'nama_produk' => $nama_produk
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

    function create(Request $request)
    {
        $data = $request->all();

        $validate = KopPembiayaan::validateAdd($data);

        $param = array('no_pengajuan' => $request->no_pengajuan);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopPembiayaan::create($data);
                $find = KopPembiayaan::find($create->id);

                $update = KopPengajuan::where($param)->first();
                $update->status_pengajuan = 1;
                $update->save();

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
        $sortBy = 'tanggal_akad';
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

        $read = KopPembiayaan::select('*')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($search != NULL) {
            $read->whereRaw("status_rekening = '0' AND (no_rekening LIKE '%" . $search . "%')");
        } else {
            $read->whereRaw("status_rekening = '0'");
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $id_cabang || $type) {
            $total = KopPembiayaan::orderBy($sortBy, $sortDir);

            if ($search) {
                $total->whereRaw("status_rekening = '0' AND (no_rekening LIKE '%" . $search . "%')");
            } else {
                $read->whereRaw("status_rekening = '0'");
            }

            $total = $total->count();
        } else {
            $total = KopPembiayaan::all()->count();
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
            $get = KopPembiayaan::find($id);

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
                'msg' => 'Maaf! Registrasi Akad tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopPembiayaan::find($request->id);
        $validate = KopPembiayaan::validateUpdate($request->all());

        $get->kode_produk = $request->kode_produk;
        $get->kode_akad = $request->kode_akad;
        $get->kode_petugas = $request->kode_petugas;
        $get->pokok = $request->pokok;
        $get->margin = $request->margin;
        //$get->nisbah_bagihasil => $request->nisbah_bagihasil;
        $get->periode_jangka_waktu = $request->periode_jangka_waktu;
        $get->jangka_waktu = $request->jangka_waktu;
        $get->angsuran_pokok = $request->angsuran_pokok;
        $get->angsuran_margin = $request->angsuran_margin;
        $get->angsuran_catab = $request->angsuran_catab;
        //$get->angsuran_minggon = $request->angsuran_minggon;
        $get->biaya_administrasi = $request->biaya_administrasi;
        $get->biaya_asuransi_jiwa = $request->biaya_asuransi_jiwa;
        //$get->biaya_asuransi_jaminan = $request->biaya_asuransi_jaminan;
        //$get->biaya_notaris = $request->biaya_notaris;
        //$get->tabungan_persen = $request->tabungan_persen;
        $get->dana_kebajikan = $request->dana_kebajikan;
        $get->tanggal_registrasi = $request->tanggal_registrasi;
        $get->tanggal_akad = $request->tanggal_akad;
        $get->tanggal_mulai_angsur = $request->tanggal_mulai_angsur;
        $get->tanggal_jtempo = $request->tanggal_jtempo;
        $get->saldo_pokok = $request->saldo_pokok;
        $get->saldo_margin = $request->saldo_margin;
        $get->saldo_catab = $request->saldo_catab;
        //$get->saldo_minggon = $request->saldo_minggon;
        //$get->jtempo_angsuran_last = $request->jtempo_angsuran_last;
        $get->jtempo_angsuran_next = $request->jtempo_angsuran_next;
        $get->sumber_dana = $request->sumber_dana;
        //$get->dana_sendiri = $request->dana_sendiri;
        //$get->dana_kreditur = $request->dana_kreditur;
        //$get->kode_kreditur = $request->kode_kreditur;
        //$get->ujroh_kreditur = $request->ujroh_kreditur;
        //$get->ujroh_kreditur_persen = $request->ujroh_kreditur_persen;
        //$get->ujroh_kreditur_nominal = $request->ujroh_kreditur_nominal;
        //$get->ujroh_kreditur_carabayar = $request->ujroh_kreditur_carabayar;
        //$get->angsuran_jadwal_khusus = $request->angsuran_jadwal_khusus;
        $get->peruntukan = $request->peruntukan;
        $get->norek_tabungan = $request->norek_tabungan;

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
            $data = KopPembiayaan::find($id);

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
                'msg' => 'Maaf! Registrasi Akad tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}