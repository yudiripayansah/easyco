<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopPrdPembiayaan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_prd_pembiayaan';
    protected $fillable = ['kode_produk', 'kode_akad', 'kode_gl', 'nama_produk', 'nama_singkat', 'periode_angsuran', 'jangka_waktu', 'biaya_adm', 'flag_wakalah', 'flag_pdd', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_produk' => 'required|numeric',
            'kode_akad' => 'required|numeric',
            'kode_gl' => 'required|numeric',
            'nama_produk' => 'required',
            'nama_singkat' => 'required',
            'periode_angsuran' => 'required|numeric',
            'jangka_waktu' => 'required|numeric',
            'biaya_adm' => 'numeric',
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
            'kode_akad' => 'required|numeric',
            'kode_gl' => 'required|numeric',
            'nama_produk' => 'required',
            'nama_singkat' => 'required',
            'periode_angsuran' => 'required|numeric',
            'jangka_waktu' => 'required|numeric',
            'biaya_adm' => 'numeric'
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
