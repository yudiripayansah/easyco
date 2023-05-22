<?php

namespace App\Http\Controllers;

use App\Models\KopPengajuan;
use App\Models\KopUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    function member(Request $request)
    {
        $token = $request->header('token');

        $param = array('token' => $token);

        $get = KopUser::where($param)->first();

        $show = KopPengajuan::member($get->kode_cabang);

        $data = array();

        foreach ($show as $sh) {
            $no_anggota = $sh->no_anggota;
            $nama_anggota = $sh->nama_anggota;
            $no_ktp = $sh->no_ktp;
            $nama_rembug = $sh->nama_rembug;

            $data[] = array(
                'no_anggota' => $no_anggota,
                'nama_anggota' => $nama_anggota,
                'no_ktp' => $no_ktp,
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

    function fa(Request $request)
    {
        $token = $request->header('token');

        $param = array('token' => $token);

        $get = KopUser::where($param)->first();

        $show = KopPengajuan::fa($get->kode_cabang);

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
        $show = KopPengajuan::peruntukan('peruntukan');

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

    function create(Request $request)
    {
        $data = $request->all();

        $validate = KopPengajuan::validateAdd($data);

        $fileKtp = $request->doc_ktp;
        $fileKk = $request->doc_kk;
        $filePendukung = $request->doc_pendukung;
        $fileTtdAnggota = $request->ttd_anggota;
        $fileTtdSuami = $request->ttd_suami;
        $fileTtdKetuaMajelis = $request->ttd_ketua_majelis;
        $fileTtdTpl = $request->ttd_tpl;

        if (empty($fileKtp)) {
            $doc_ktp = NULL;
        } else {
            $name_ktp = 'ktp_' . $request->no_anggota . '.png';
            $path_ktp = 'document/' . $name_ktp;

            Storage::disk('public')->put($path_ktp, file_get_contents($fileKtp));

            $doc_ktp = $name_ktp;
        }

        if (empty($fileKk)) {
            $doc_kk = NULL;
        } else {
            $name_kk = 'kk_' . $request->no_anggota . '.png';
            $path_kk = 'document/' . $name_kk;

            Storage::disk('public')->put($path_kk, file_get_contents($fileKk));

            $doc_kk = $name_kk;
        }

        if (empty($filePendukung)) {
            $doc_pendukung = NULL;
        } else {
            $name_pendukung = 'pendukung_' . $request->no_anggota . '.png';
            $path_pendukung = 'document/' . $name_pendukung;

            Storage::disk('public')->put($path_pendukung, file_get_contents($filePendukung));

            $doc_pendukung = $name_pendukung;
        }

        if (empty($fileTtdAnggota)) {
            $ttd_anggota = NULL;
        } else {
            $name_ttd_anggota = 'ttd_anggota_' . $request->no_anggota . '.png';
            $path_ttd_anggota = 'document/' . $name_ttd_anggota;

            Storage::disk('public')->put($path_ttd_anggota, file_get_contents($fileTtdAnggota));

            $ttd_anggota = $name_ttd_anggota;
        }

        if (empty($fileTtdSuami)) {
            $ttd_suami = NULL;
        } else {
            $name_ttd_suami = 'ttd_suami_' . $request->no_anggota . '.png';
            $path_ttd_suami = 'document/' . $name_ttd_suami;

            Storage::disk('public')->put($path_ttd_suami, file_get_contents($fileTtdSuami));

            $ttd_suami = $name_ttd_suami;
        }

        if (empty($fileTtdKetuaMajelis)) {
            $ttd_ketua_majelis = NULL;
        } else {
            $name_ttd_ketua_majelis = 'ttd_ketua_majelis_' . $request->no_anggota . '.png';
            $path_ttd_ketua_majelis = 'document/' . $name_ttd_ketua_majelis;

            Storage::disk('public')->put($path_ttd_ketua_majelis, file_get_contents($fileTtdKetuaMajelis));

            $ttd_ketua_majelis = $name_ttd_ketua_majelis;
        }

        if (empty($fileTtdTpl)) {
            $ttd_tpl = NULL;
        } else {
            $name_ttd_tpl = 'ttd_tpl_' . $request->no_anggota . '.png';
            $path_ttd_tpl = 'document/' . $name_ttd_tpl;

            Storage::disk('public')->put($path_ttd_tpl, file_get_contents($fileTtdTpl));

            $ttd_tpl = $name_ttd_tpl;
        }

        $data['doc_ktp'] = $doc_ktp;
        $data['doc_kk'] = $doc_kk;
        $data['doc_pendukung'] = $doc_pendukung;
        $data['ttd_anggota'] = $ttd_anggota;
        $data['ttd_suami'] = $ttd_suami;
        $data['ttd_ketua_majelis'] = $ttd_ketua_majelis;
        $data['ttd_tpl'] = $ttd_tpl;
        $data['tanggal_pengajuan'] = date('Y-m-d', strtotime($request->tanggal_pengajuan));
        $data['rencana_droping'] = date('Y-m-d', strtotime($request->rencana_droping));

        $data['keterangan_peruntukan'] = strtoupper($request->keterangan_peruntukan);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopPengajuan::create($data);
                $find = KopPengajuan::find($create->id);

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
        $sortBy = 'kop_pengajuan.tanggal_pengajuan';
        $search = NULL;
        $total = 0;
        $totalPage = 1;
        $jenis_pembiayaan = '~';
        $petugas = '~';
        $rembug = '~';
        $status = '~';
        $from = NULL;
        $to = NULL;

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

        if ($request->search) {
            $search = strtoupper($request->search);
        }

        if ($request->cabang) {
            $cabang = $request->cabang;
        }

        if ($request->rembug) {
            $rembug = $request->rembug;
        }

        if ($request->status) {
            $status = $request->status;
        }

        if ($request->jenis_pembiayaan) {
            $jenis_pembiayaan = $request->jenis_pembiayaan;
        }

        if ($request->petugas) {
            $petugas = $request->petugas;
        }

        if ($request->from) {
            $from = str_replace('/', '-', $request->from);
            $from = date('Y-m-d', strtotime($from));
        }

        if ($request->to) {
            $to = str_replace('/', '-', $request->to);
            $to = date('Y-m-d', strtotime($to));
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopPengajuan::select('kop_pengajuan.*', 'kop_cabang.nama_cabang', 'kop_rembug.nama_rembug', 'kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kop_anggota.no_ktp', 'kop_anggota.tempat_lahir', 'kop_anggota.tgl_lahir', 'kop_anggota.no_telp', 'kop_kas_petugas.nama_kas_petugas')
            ->orderBy($sortBy, $sortDir)
            ->join('kop_anggota', 'kop_anggota.no_anggota', 'kop_pengajuan.no_anggota')
            ->join('kop_cabang', 'kop_cabang.kode_cabang', 'kop_anggota.kode_cabang')
            ->leftjoin('kop_rembug', 'kop_rembug.kode_rembug', 'kop_anggota.kode_rembug')
            ->join('kop_kas_petugas', 'kop_kas_petugas.kode_petugas', 'kop_rembug.kode_petugas');

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($status && $status != '~') {
            $read->whereIn('kop_pengajuan.status_pengajuan', $status);
        }

        if ($cabang != '00000') {
            $read->where('kop_cabang.kode_cabang', $cabang);
        }

        if ($jenis_pembiayaan && $jenis_pembiayaan != '~') {
            $read->where('kop_pengajuan.jenis_pembiayaan', $jenis_pembiayaan);
        }

        if ($petugas && $petugas != '~') {
            $read->where('kop_kas_petugas.kode_petugas', $petugas);
        }

        if ($rembug && $rembug != '~') {
            $read->where('kop_rembug.kode_rembug', $rembug);
        }

        if ($search) {
            $read->where('kop_pengajuan.no_anggota', 'LIKE', '%' . $search . '%')
                ->orWhere('kop_pengajuan.no_pengajuan', 'LIKE', '%' . $search . '%')
                ->orWhere('kop_anggota.nama_anggota', 'LIKE', '%' . $search . '%');
        }

        if ($from && $to) {
            $read->whereBetween('kop_pengajuan.tanggal_pengajuan', [$from, $to]);
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $cabang || $jenis_pembiayaan || $petugas || $rembug || $status || ($from && $to)) {
            $total = KopPengajuan::orderBy($sortBy, $sortDir)
                ->join('kop_anggota', 'kop_anggota.no_anggota', 'kop_pengajuan.no_anggota')
                ->join('kop_cabang', 'kop_cabang.kode_cabang', 'kop_anggota.kode_cabang');

            if ($search) {
                $total->where('kop_pengajuan.no_anggota', 'LIKE', '%' . $search . '%')
                    ->orWhere('kop_pengajuan.no_pengajuan', 'LIKE', '%' . $search . '%');
            }

            if ($status && $status != '~') {
                $total->whereIn('kop_pengajuan.status_pengajuan', $status);
            }

            if ($cabang != '00000') {
                $total->where('kop_cabang.kode_cabang', $cabang);
            }

            if ($jenis_pembiayaan && $jenis_pembiayaan != '~') {
                $total->where('kop_pengajuan.jenis_pembiayaan', $jenis_pembiayaan);
            }

            if ($petugas && $petugas != '~') {
                $total->where('kop_kas_petugas.kode_petugas', $petugas);
            }

            if ($rembug && $rembug != '~') {
                $total->where('kop_rembug.kode_rembug', $rembug);
            }

            if ($from && $to) {
                $total->whereBetween('kop_pengajuan.tanggal_pengajuan', [$from, $to]);
            }

            $total = $total->count();
        } else {
            $total = KopPengajuan::all()->count();
        }

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        foreach ($read as $row) {
            $row->tgl_gabung = date('d-F-Y', strtotime($row->tgl_gabung));
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
        $get->jangka_waktu = $request->jangka_waktu;
        $get->jenis_pembiayaan = $request->jenis_pembiayaan;
        $get->sumber_pengembalian = $request->sumber_pengembalian;

        if (empty($request->doc_ktp)) {
            $doc_ktp = $get->doc_ktp;
        } else {
            $name_ktp = 'ktp_' . $get->no_anggota . '.png';
            $path = 'document/' . $name_ktp;
            $old = 'document/' . $get->doc_ktp;

            Storage::disk('public')->delete($old);
            Storage::disk('public')->put($path, file_get_contents($request->doc_ktp));

            $doc_ktp = $name_ktp;
        }

        if (empty($request->doc_kk)) {
            $doc_kk = $get->doc_kk;
        } else {
            $name_kk = 'kk_' . $get->no_anggota . '.png';
            $path = 'document/' . $name_kk;
            $old = 'document/' . $get->doc_kk;

            Storage::disk('public')->delete($old);
            Storage::disk('public')->put($path, file_get_contents($request->doc_kk));

            $doc_kk = $name_kk;
        }

        if (empty($request->doc_pendukung)) {
            $doc_pendukung = $get->doc_pendukung;
        } else {
            $name_pendukung = 'pendukung_' . $get->no_anggota . '.png';
            $path = 'document/' . $name_pendukung;
            $old = 'document/' . $get->doc_pendukung;

            Storage::disk('public')->delete($old);
            Storage::disk('public')->put($path, file_get_contents($request->doc_pendukung));

            $doc_pendukung = $name_pendukung;
        }

        if (empty($request->ttd_anggota)) {
            $ttd_anggota = $get->ttd_anggota;
        } else {
            $name_ttd_anggota = 'ttd_anggota_' . $get->no_anggota . '.png';
            $path = 'document/' . $name_ttd_anggota;
            $old = 'document/' . $get->ttd_anggota;

            Storage::disk('public')->delete($old);
            Storage::disk('public')->put($path, file_get_contents($request->ttd_anggota));

            $ttd_anggota = $name_ttd_anggota;
        }

        if (empty($request->ttd_suami)) {
            $ttd_suami = $get->ttd_suami;
        } else {
            $name_ttd_suami = 'ttd_suami_' . $get->no_anggota . '.png';
            $path = 'document/' . $name_ttd_suami;
            $old = 'document/' . $get->ttd_suami;

            Storage::disk('public')->delete($old);
            Storage::disk('public')->put($path, file_get_contents($request->ttd_suami));

            $ttd_suami = $name_ttd_suami;
        }

        if (empty($request->ttd_ketua_majelis)) {
            $ttd_ketua_majelis = $get->ttd_ketua_majelis;
        } else {
            $name_ttd_ketua_majelis = 'ttd_ketua_majelis_' . $get->no_anggota . '.png';
            $path = 'document/' . $name_ttd_ketua_majelis;
            $old = 'document/' . $get->ttd_ketua_majelis;

            Storage::disk('public')->delete($old);
            Storage::disk('public')->put($path, file_get_contents($request->ttd_ketua_majelis));

            $ttd_ketua_majelis = $name_ttd_ketua_majelis;
        }

        if (empty($request->ttd_tpl)) {
            $ttd_tpl = $get->ttd_tpl;
        } else {
            $name_ttd_tpl = 'ttd_tpl_' . $get->no_anggota . '.png';
            $path = 'document/' . $name_ttd_tpl;
            $old = 'document/' . $get->ttd_tpl;

            Storage::disk('public')->delete($old);
            Storage::disk('public')->put($path, file_get_contents($request->ttd_tpl));

            $ttd_tpl = $name_ttd_tpl;
        }

        $get->doc_ktp = $doc_ktp;
        $get->doc_kk = $doc_kk;
        $get->doc_pendukung = $doc_pendukung;
        $get->ttd_anggota = $ttd_anggota;
        $get->ttd_suami = $ttd_suami;
        $get->ttd_ketua_majelis = $ttd_ketua_majelis;
        $get->ttd_tpl = $ttd_tpl;

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

    public function update_komite(Request $request)
    {
        $get = KopPengajuan::find($request->id);

        $get->status_pengajuan = $request->status_pengajuan;

        DB::beginTransaction();

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

        $response = response()->json($res, 200);

        return $response;
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $data = KopPengajuan::find($id);

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
                'msg' => 'Maaf! Pengajuan tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
