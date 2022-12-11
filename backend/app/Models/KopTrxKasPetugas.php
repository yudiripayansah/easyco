<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopTrxKasPetugas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_trx_kas_petugas';
    protected $fillable = ['id_trx_kas_petugas', 'kode_kas_petugas', 'debit_credit', 'trx_date', 'voucher_date', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_kas_petugas' => 'required',
            'jenis_trx' => 'numeric',
            'jumlah_trx' => 'numeric',
            'voucher_date' => 'required',
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
