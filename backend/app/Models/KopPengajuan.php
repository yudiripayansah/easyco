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

    public function member($kode_cabang)
    {
        $param = array();

        if ($kode_cabang <> '00000') {
            $param['kc.kode_cabang'] = $kode_cabang;
        }

        $param['ka.status'] = 1;

        $show = DB::table('kop_anggota AS ka')
            ->select('ka.no_anggota', 'ka.nama_anggota', 'ka.no_ktp', 'kr.nama_rembug')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', '=', 'ka.kode_cabang')
            ->leftJoin('kop_rembug AS kr', 'kr.kode_rembug', '=', 'ka.kode_rembug')
            ->where($param)
            ->get();

        return $show;
    }

    public function fa($kode_cabang)
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

    public function peruntukan($nama_kode)
    {
        $show = DB::table('kop_list_kode')->where('nama_kode', $nama_kode)->orderBy('id', 'ASC')->get();

        return $show;
    }
}
