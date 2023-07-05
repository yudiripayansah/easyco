<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopTrxGl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_trx_gl';
    protected $fillable = ['id_trx_gl', 'kode_cabang', 'trx_date', 'voucher_date', 'voucher_no', 'description', 'trx_type', 'jurnal_id', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'id_trx_gl' => 'required',
            'kode_cabang' => 'required|numeric',
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

    public function validateUpdate($validate)
    {
        $rule = [
            'id' => 'required|numeric',
            'kode_cabang' => 'required|numeric',
            'voucher_date' => 'required'
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

    function get_ledger($kode_cabang, $from_date, $thru_date)
    {
        $show = KopTrxGl::select('*')
            ->where('kode_cabang', $kode_cabang)
            ->whereBetween('voucher_date', [$from_date, $thru_date])
            ->orderBy('voucher_date')
            ->get();

        return $show;
    }

    function get_saldo_awal($kode_gl, $from, $kode_cabang)
    {
        $show = DB::select("SELECT fn_get_saldoawal_gl('" . $kode_gl . "','" . $from . "','" . $kode_cabang . "') AS saldo_awal");

        return $show;
    }
}
