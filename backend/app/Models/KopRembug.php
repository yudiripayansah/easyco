<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopRembug extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_rembug';
    protected $fillable = ['kode_rembug', 'kode_cabang', 'kode_desa', 'kode_petugas', 'nama_rembug', 'tgl_pembentukan', 'hari_transaksi', 'jam_transaksi', 'status_aktif', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_rembug' => 'required|numeric|unique:kop_rembug',
            'kode_cabang' => 'required|numeric',
            'kode_desa' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'nama_rembug' => 'required',
            'tgl_pembentukan' => 'required|date',
            'hari_transaksi' => 'required|numeric',
            'jam_transaksi' => 'required|date_format:H:i',
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
            'kode_desa' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'nama_rembug' => 'required',
            'tgl_pembentukan' => 'required|date',
            'hari_transaksi' => 'required|numeric',
            'jam_transaksi' => 'required|date_format:H:i'
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
