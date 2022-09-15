<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopPegawai extends Model
{
    use SoftDeletes;

    protected $table = 'kop_pegawai';
    protected $fillable = ['kode_cabang', 'kode_pgw', 'nama_pgw', 'jenis_kelamin', 'alamat_pgw', 'no_ktp', 'no_hp', 'jabatan', 'tgl_gabung', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_pgw' => 'required|numeric|unique:kop_pegawai',
            'kode_cabang' => 'required|numeric',
            'nama_pgw' => 'required',
            'jenis_kelamin' => 'required',
            'no_ktp' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jabatan' => 'required',
            'tgl_gabung' => 'date',
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
            'kode_cabang' => 'required|numeric',
            'nama_pgw' => 'required',
            'jenis_kelamin' => 'required',
            'no_ktp' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jabatan' => 'required',
            'tgl_gabung' => 'date'
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
