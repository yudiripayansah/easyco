<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopTrxRembug extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_trx_rembug';
    protected $fillable = ['id_trx_rembug', 'kode_rembug', 'kode_petugas', 'trx_date', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'id_trx_rembug' => 'required',
            'kode_rembug' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'trx_date' => 'required',
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
}
