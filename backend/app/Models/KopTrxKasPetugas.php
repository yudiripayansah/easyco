<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopTrxKasPetugas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_trx_kas_petugas';
    protected $fillable = ['id_trx_kas_petugas', 'kode_kas_petugas', 'jenis_trx', 'jumlah_trx', 'keterangan', 'debit_credit', 'trx_date', 'kode_kas_teller', 'voucher_date', 'created_by'];

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

    function get_saldo_awal($kode_kas_petugas, $from_date)
    {
        $show = DB::select("SELECT fn_get_saldoawal_kaspetugas('" . $kode_kas_petugas . "','" . $from_date . "') AS saldo_awal");

        return $show;
    }

    function get_history_cash($kode_kas_petugas, $from_date, $thru_date)
    {
        $show = KopTrxKasPetugas::select('*')
            ->where('kode_kas_petugas', $kode_kas_petugas)
            ->whereBetween('voucher_date', [$from_date, $thru_date])
            ->orderBy('trx_date')
            ->orderBy('jenis_trx')
            ->orderBy('created_at')
            ->get();

        return $show;
    }

    function get_detail_cash($kode_kas_petugas)
    {
        $show = KopTrxKasPetugas::select('kkp.*', 'kkp.nama_kas_petugas', 'kc.nama_cabang')
            ->join('kop_kas_petugas AS kkp', 'kkp.kode_kas_petugas', 'kop_trx_kas_petugas.kode_kas_petugas')
            ->join('kop_pegawai AS kp', 'kp.kode_pgw', 'kkp.kode_petugas')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'kp.kode_cabang')
            ->where('kop_trx_kas_petugas.kode_kas_petugas', $kode_kas_petugas)
            ->first();

        return $show;
    }
}
