<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopKasPetugas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_kas_petugas';
    protected $fillable = ['id_user', 'kode_kas_petugas', 'kode_petugas', 'kode_gl', 'nama_kas_petugas', 'saldo', 'jenis_kas_petugas', 'status_kas_petugas', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'id_user' => 'required',
            'kode_kas_petugas' => 'required|unique:kop_kas_petugas',
            'kode_petugas' => 'required|numeric|unique:kop_kas_petugas',
            'kode_gl' => 'required|numeric',
            'nama_kas_petugas' => 'required',
            'jenis_kas_petugas' => 'required|numeric',
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
            'id_user' => 'required',
            'kode_gl' => 'required|numeric',
            'nama_kas_petugas' => 'required',
            'jenis_kas_petugas' => 'required|numeric'
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
