<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopAnggota extends Model
{
    use SoftDeletes;

    protected $table = 'kop_anggota';
    protected $fillable = ['kode_cabang', 'kode_rembug', 'no_anggota', 'nama_anggota', 'jenis_kelamin', 'ibu_kandung', 'tempat_lahir', 'tgl_lahir', 'alamat', 'desa', 'kecamatan', 'kabupaten', 'kodepos', 'no_ktp', 'no_npwp', 'no_telp', 'pendidikan', 'status_perkawinan', 'nama_pasangan', 'pekerjaan', 'ket_pekerjaan', 'pendapatan_perbulan', 'simpok', 'simwa', 'simsuk', 'tgl_gabung', 'status', 'tanggal_keluar', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_cabang' => 'required|numeric',
            'nama_anggota' => 'required',
            'jenis_kelamin' => 'required',
            'ibu_kandung' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'no_ktp' => 'required|numeric',
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
            'nama_anggota' => 'required',
            'jenis_kelamin' => 'required',
            'ibu_kandung' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'no_ktp' => 'required|numeric'
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

    function rembug($kode_cabang)
    {
        $show = DB::table('kop_rembug')->where('kode_cabang', $kode_cabang)->orderBy('id', 'ASC')->get();

        return $show;
    }

    function tpl_member($kode_rembug)
    {
        $show = KopAnggota::select('kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kr.kode_rembug', 'kr.nama_rembug')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', '=', 'kop_anggota.kode_rembug')
            ->where('kr.kode_rembug', $kode_rembug)
            ->orderBy('kop_anggota.no_anggota', 'ASC')
            ->get();

        return $show;
    }

    function report_list($kode_cabang, $kode_rembug, $from_date, $thru_date)
    {
        $show = KopAnggota::select('kc.nama_cabang', 'kr.nama_rembug', 'kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kop_anggota.jenis_kelamin', 'kop_anggota.ibu_kandung', 'kop_anggota.tempat_lahir', 'kop_anggota.tgl_lahir', 'kop_anggota.alamat', 'kop_anggota.desa', 'kop_anggota.kecamatan', 'kop_anggota.kabupaten', 'kop_anggota.no_ktp', 'kop_anggota.no_telp', 'kop_anggota.pendidikan', 'kop_anggota.status_perkawinan', 'kop_anggota.nama_pasangan', 'kop_anggota.pekerjaan', 'kop_anggota.ket_pekerjaan', 'kop_anggota.pendapatan_perbulan', 'kop_anggota.tgl_gabung')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', '=', 'kop_anggota.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', '=', 'kop_anggota.kode_rembug');

        if ($kode_cabang <> '~') {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($kode_rembug <> '~') {
            $show->where('kr.kode_rembug', $kode_rembug);
        }

        $show->whereBetween('kop_anggota.tgl_gabung', [$from_date, $thru_date])
            ->orderBy('kc.kode_cabang', 'ASC')
            ->orderBy('kr.kode_rembug', 'ASC')
            ->orderBy('kop_anggota.no_anggota', 'ASC');

        $show = $show->get();

        return $show;
    }
}
