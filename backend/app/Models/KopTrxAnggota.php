<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
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

    function tpl_cashflow_credit($no_anggota, $trx_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(amount),0) AS total_penerimaan'))
            ->where('no_anggota', $no_anggota)
            ->where('trx_date', $trx_date)
            ->where('flag_debet_credit', 'C')
            ->get();

        return $show;
    }

    function tpl_cashflow_debet($no_anggota, $trx_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(amount),0) AS total_penarikan'))
            ->where('no_anggota', $no_anggota)
            ->where('trx_date', $trx_date)
            ->where('flag_debet_credit', 'D')
            ->get();

        return $show;
    }

    function get_credit_member($no_anggota, $jenis_trx, $from_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(kop_trx_anggota.amount),0) AS amount'))
            ->join('kop_list_kode AS klk', 'klk.kode_value', 'kop_trx_anggota.trx_type')
            ->where('kop_trx_anggota.no_anggota', $no_anggota)
            ->where('klk.kode_value', $jenis_trx)
            ->where('kop_trx_anggota.flag_debet_credit', 'C')
            ->where('kop_trx_anggota.trx_date', '<', $from_date)
            ->groupBy('kop_trx_anggota.no_anggota')
            ->first();

        return $show;
    }

    function get_debet_member($no_anggota, $jenis_trx, $from_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(kop_trx_anggota.amount),0) AS amount'))
            ->join('kop_list_kode AS klk', 'klk.kode_value', 'kop_trx_anggota.trx_type')
            ->where('kop_trx_anggota.no_anggota', $no_anggota)
            ->where('klk.kode_value', $jenis_trx)
            ->where('kop_trx_anggota.flag_debet_credit', 'D')
            ->where('kop_trx_anggota.trx_date', '<', $from_date)
            ->groupBy('kop_trx_anggota.no_anggota')
            ->first();

        return $show;
    }

    function get_history_member($no_anggota, $jenis_trx, $from_date, $thru_date)
    {
        $show = KopTrxAnggota::select('kop_trx_anggota.trx_date', DB::raw('COALESCE(kop_trx_anggota.amount,0) AS amount'), 'kop_trx_anggota.flag_debet_credit', 'kop_trx_anggota.description')
            ->join('kop_list_kode AS klk', 'klk.kode_value', 'kop_trx_anggota.trx_type')
            ->where('kop_trx_anggota.no_anggota', $no_anggota)
            ->where('kop_trx_anggota.amount', '>', 0)
            ->whereIn('klk.kode_value', $jenis_trx)
            ->whereBetween('kop_trx_anggota.trx_date', [$from_date, $thru_date])
            ->orderBy('kop_trx_anggota.trx_date', 'ASC')
            ->get();

        return $show;
    }
}
