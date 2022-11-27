<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopTrxAnggota extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_trx_anggota';
    protected $fillable = ['id_trx_anggota', 'no_anggota', 'trx_date', 'flag_debet_credit', 'trx_type', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'id_trx_anggota' => 'required',
            'no_anggota' => 'required|numeric',
            'trx_date' => 'required',
            'flag_debet_credit' => 'required',
            'trx_type' => 'required|numeric',
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
