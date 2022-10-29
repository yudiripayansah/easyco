<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
            'tgl_gabung' => 'required',
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
            'no_ktp' => 'required|numeric',
            'tgl_gabung' => 'required'
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
}
