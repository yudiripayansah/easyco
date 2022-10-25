<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopPrdTabungan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_prd_tabungan';
    protected $fillable = ['kode_produk', 'kode_gl', 'nama_produk', 'nama_singkat', 'jenis_akad', 'saldo_minimal', 'biaya_adm', 'jenis_tabungan', 'minimal_setoran', 'periode_setoran', 'minimal_kontrak', 'nisbah', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_produk' => 'required|numeric',
            'kode_gl' => 'required|numeric',
            'nama_produk' => 'required',
            'nama_singkat' => 'required',
            'jenis_akad' => 'numeric',
            'saldo_minimal' => 'numeric',
            'biaya_adm' => 'numeric',
            'jenis_tabungan' => 'numeric',
            'minimal_setoran' => 'numeric',
            'periode_setoran' => 'numeric',
            'minimal_kontrak' => 'numeric',
            'nisbah' => 'numeric',
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
            'kode_gl' => 'required|numeric',
            'nama_produk' => 'required',
            'nama_singkat' => 'required',
            'jenis_akad' => 'numeric',
            'saldo_minimal' => 'numeric',
            'biaya_adm' => 'numeric',
            'jenis_tabungan' => 'numeric',
            'minimal_setoran' => 'numeric',
            'periode_setoran' => 'numeric',
            'minimal_kontrak' => 'numeric',
            'nisbah' => 'numeric',
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
