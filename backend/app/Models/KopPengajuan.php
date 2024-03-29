<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopPengajuan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_pengajuan';
    protected $fillable = ['no_anggota', 'kode_petugas', 'no_pengajuan', 'tanggal_pengajuan', 'jumlah_pengajuan', 'pengajuan_ke', 'peruntukan', 'keterangan_peruntukan', 'rencana_droping', 'jangka_waktu', 'rencana_periode_jwaktu', 'status_pengajuan', 'jenis_pembiayaan', 'sumber_pengembalian', 'doc_ktp', 'doc_kk', 'doc_pendukung', 'ttd_anggota', 'ttd_suami', 'ttd_ketua_majelis', 'ttd_tpl', 'no_pengajuan_o', 'no_anggota_o', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'no_anggota' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'tanggal_pengajuan' => 'required',
            'jumlah_pengajuan' => 'numeric',
            'pengajuan_ke' => 'required|numeric',
            'peruntukan' => 'required|numeric',
            'keterangan_peruntukan' => 'required',
            'rencana_droping' => 'required',
            'jangka_waktu' => 'required|numeric',
            'rencana_periode_jwaktu' => 'numeric',
            'jenis_pembiayaan' => 'numeric',
            'sumber_pengembalian' => 'numeric',
            'created_by' => 'required'
        ];

        $validator = Validator::make($validate, $rule);

        if ($validator->fails()) {
            $errors =  $validator->errors()->all();

            $res = [
                'status' => FALSE,
                'errors' => $errors,
                'msg' => 'Validation Error'
            ];
        } else {
            $res = [
                'status' => TRUE,
                'errors' => NULL,
                'msg' => 'Validation OK'
            ];
        }

        return $res;
    }

    public function validateUpdate($validate)
    {
        $rule = [
            'id' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'tanggal_pengajuan' => 'required',
            'jumlah_pengajuan' => 'numeric',
            'pengajuan_ke' => 'required|numeric',
            'peruntukan' => 'required|numeric',
            'keterangan_peruntukan' => 'required',
            'rencana_droping' => 'required',
            'jangka_waktu' => 'required|numeric',
            'rencana_periode_jwaktu' => 'numeric',
            'jenis_pembiayaan' => 'numeric',
            'sumber_pengembalian' => 'numeric'
        ];

        $validator = Validator::make($validate, $rule);

        if ($validator->fails()) {
            $errors =  $validator->errors()->all();

            $res = [
                'status' => FALSE,
                'errors' => $errors,
                'msg' => 'Validation Error'
            ];
        } else {
            $res = [
                'status' => TRUE,
                'errors' => NULL,
                'msg' => 'Validation OK'
            ];
        }

        return $res;
    }

    function member($kode_cabang, $kode_rembug)
    {
        $show = KopAnggota::select('kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kop_anggota.no_ktp', 'kr.nama_rembug', DB::raw('COUNT(kp.*) AS pembiayaan_ke'))
            ->leftJoin('kop_pengajuan AS kp', 'kp.no_anggota', 'kop_anggota.no_anggota')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'kop_anggota.kode_rembug')
            ->where('kop_anggota.status', 1)
            ->where('kr.kode_rembug', $kode_rembug);

        if ($kode_cabang <> '00000') {
            $show->where('kop_anggota.kode_cabang', $kode_cabang);
        }

        $show->groupBy('kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kop_anggota.no_ktp', 'kr.nama_rembug');

        $show = $show->get();

        return $show;
    }

    function fa($kode_cabang)
    {
        $param = array();

        if ($kode_cabang <> '00000') {
            $param['kc.kode_cabang'] = $kode_cabang;
        }

        $param['kkp.status_kas_petugas'] = 1;

        $show = DB::table('kop_kas_petugas AS kkp')
            ->select('kkp.kode_petugas', 'kkp.nama_kas_petugas')
            ->join('kop_user AS ku', 'ku.id_user', '=', 'kkp.id_user')
            ->leftJoin('kop_cabang AS kc', 'kc.kode_cabang', '=', 'ku.kode_cabang')
            ->where($param)
            ->get();

        return $show;
    }

    function peruntukan($nama_kode)
    {
        $show = DB::table('kop_list_kode')->where('nama_kode', $nama_kode)->orderBy('id', 'ASC')->get();

        return $show;
    }

    function report_list($kode_cabang, $jenis_pembiayaan, $kode_petugas, $kode_rembug, $from_date, $thru_date)
    {
        $show = KopPengajuan::select('kc.nama_cabang', 'kr.nama_rembug', 'kop_pengajuan.no_pengajuan', 'ka.no_anggota', 'ka.nama_anggota', 'ka.no_ktp', 'ka.tempat_lahir', 'ka.tgl_lahir', 'ka.no_telp', 'kkp.nama_kas_petugas', 'kop_pengajuan.jenis_pembiayaan', 'kop_pengajuan.tanggal_pengajuan', 'kop_pengajuan.rencana_droping', 'kop_pengajuan.jumlah_pengajuan', 'kop_pengajuan.status_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', '=', 'kop_pengajuan.no_anggota')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', '=', 'ka.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', '=', 'ka.kode_rembug')
            ->join('kop_kas_petugas AS kkp', 'kkp.kode_petugas', '=', 'kr.kode_petugas')
            ->whereIn('kop_pengajuan.status_pengajuan', [0, 1]);

        if ($kode_cabang <> '~') {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($jenis_pembiayaan <> '9') {
            $show->where('kop_pengajuan.jenis_pembiayaan', $jenis_pembiayaan);
        }

        if ($kode_petugas <> '~') {
            $show->where('kkp.kode_petugas', $kode_petugas);
        }

        if ($kode_rembug <> '~') {
            $show->where('kr.kode_rembug', $kode_rembug);
        }

        $show->whereBetween('kop_pengajuan.tanggal_pengajuan', [$from_date, $thru_date])
            ->orderBy('kc.kode_cabang', 'ASC')
            ->orderBy('kr.kode_rembug', 'ASC')
            ->orderBy('kop_pengajuan.tanggal_pengajuan', 'ASC');

        $show = $show->get();

        return $show;
    }

    function rekap_pengajuan($kode_cabang, $rekap_by, $from_date, $thru_date)
    {
        $show = KopPengajuan::join('kop_anggota AS ka', 'ka.no_anggota', 'kop_pengajuan.no_anggota')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'ka.kode_cabang');

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($rekap_by == 1) {
            // CABANG
            $show->select(DB::raw('kc.nama_cabang AS keterangan'), DB::raw('COUNT(ka.*) AS jumlah_anggota'), DB::raw('COALESCE(SUM(kop_pengajuan.jumlah_pengajuan),0) AS nominal'))
                ->groupBy('kc.nama_cabang')
                ->orderBy('kc.nama_cabang');
        } elseif ($rekap_by == 2) {
            // PETUGAS
            $show->select(DB::raw('kp.nama_pgw AS keterangan'), DB::raw('COUNT(ka.*) AS jumlah_anggota'), DB::raw('COALESCE(SUM(kop_pengajuan.jumlah_pengajuan),0) AS nominal'))
                ->join('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
                ->join('kop_pegawai AS kp', 'kp.kode_pgw', 'kr.kode_petugas')
                ->groupBy('kp.nama_pgw')
                ->orderBy('kp.nama_pgw');
        } else {
            // MAJELIS
            $show->select(DB::raw('kr.nama_rembug AS keterangan'), DB::raw('COUNT(ka.*) AS jumlah_anggota'), DB::raw('COALESCE(SUM(kop_pengajuan.jumlah_pengajuan),0) AS nominal'))
                ->join('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
                ->groupBy('kr.nama_rembug')
                ->orderBy('kr.nama_rembug');
        }

        $show->whereBetween('kop_pengajuan.tanggal_pengajuan', [$from_date, $thru_date]);

        $show = $show->get();

        return $show;
    }
}
