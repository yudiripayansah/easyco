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
            ->whereNotIN('trx_type', [41, 44])
            ->where('verified_by', null)
            ->get();

        return $show;
    }

    function tpl_cashflow_debet($no_anggota, $trx_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(amount),0) AS total_penarikan'))
            ->where('no_anggota', $no_anggota)
            ->where('trx_date', $trx_date)
            ->where('flag_debet_credit', 'D')
            ->whereNotIN('trx_type', [41, 42, 43, 44])
            ->where('verified_by', null)
            ->get();

        return $show;
    }

    function get_history_dc_member($no_rekening, $flag_debet_credit, $trx_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(amount),0) AS amount'))
            ->where('no_rekening', $no_rekening)
            ->where('flag_debet_credit', $flag_debet_credit)
            ->where('trx_date', '<', $trx_date)
            ->first();

        return $show;
    }

    function get_credit_member($no_anggota, $jenis_trx, $from_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(kop_trx_anggota.amount),0) AS amount'))
            ->join('kop_list_trx_anggota AS klk', 'klk.kode_trx', 'kop_trx_anggota.trx_type')
            ->where('kop_trx_anggota.no_anggota', $no_anggota)
            ->whereIn('klk.kode_trx', $jenis_trx)
            ->where('kop_trx_anggota.flag_debet_credit', 'C')
            ->where('kop_trx_anggota.trx_date', '<', $from_date)
            ->groupBy('kop_trx_anggota.no_anggota')
            ->first();

        return $show;
    }

    function get_debet_member($no_anggota, $jenis_trx, $from_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(kop_trx_anggota.amount),0) AS amount'))
            ->join('kop_list_trx_anggota AS klk', 'klk.kode_trx', 'kop_trx_anggota.trx_type')
            ->where('kop_trx_anggota.no_anggota', $no_anggota)
            ->whereIn('klk.kode_trx', $jenis_trx)
            ->where('kop_trx_anggota.flag_debet_credit', 'D')
            ->where('kop_trx_anggota.trx_date', '<', $from_date)
            ->groupBy('kop_trx_anggota.no_anggota')
            ->first();

        return $show;
    }

    function get_pinbuk_member($no_anggota, $jenis_trx, $from_date)
    {
        $show = KopTrxAnggota::select(DB::raw('COALESCE(SUM(kop_trx_anggota.amount),0) AS amount'))
            ->join('kop_list_trx_anggota AS klk', 'klk.kode_trx', 'kop_trx_anggota.trx_type')
            ->where('kop_trx_anggota.no_anggota', $no_anggota)
            ->whereIn('klk.kode_trx', $jenis_trx)
            ->where('kop_trx_anggota.flag_debet_credit', 'D')
            ->where('kop_trx_anggota.trx_date', '<', $from_date)
            ->groupBy('kop_trx_anggota.no_anggota')
            ->first();

        return $show;
    }

    function get_history_savingplan($no_rekening, $from_date, $thru_date)
    {
        $show = KopTrxAnggota::select('trx_date', DB::raw('COALESCE(amount,0) AS amount'), 'flag_debet_credit', 'description', 'trx_type')
            ->where('no_rekening', $no_rekening)
            ->where('amount', '>', 0)
            ->where('trx_type', 21)
            ->whereBetween('trx_date', [$from_date, $thru_date])
            ->orderBy('trx_date', 'ASC')
            ->get();

        return $show;
    }

    function get_history_member($no_anggota, $jenis_trx, $from_date, $thru_date)
    {
        $show = KopTrxAnggota::select('kop_trx_anggota.trx_date', DB::raw('COALESCE(kop_trx_anggota.amount,0) AS amount'), 'kop_trx_anggota.flag_debet_credit', 'kop_trx_anggota.description', 'kop_trx_anggota.trx_type')
            ->join('kop_list_trx_anggota AS klk', 'klk.kode_trx', 'kop_trx_anggota.trx_type')
            ->where('kop_trx_anggota.no_anggota', $no_anggota)
            ->where('kop_trx_anggota.amount', '>', 0)
            ->whereIn('klk.kode_trx', $jenis_trx)
            ->whereBetween('kop_trx_anggota.trx_date', [$from_date, $thru_date])
            ->orderBy('kop_trx_anggota.trx_date', 'ASC')
            ->get();

        return $show;
    }

    function get_exist($no_anggota, $trx_date, $id_trx_rembug)
    {
        $show = KopTrxAnggota::select(DB::raw('COUNT(*) AS jumlah'))
            ->where('no_anggota', $no_anggota)
            ->where('trx_date', $trx_date)
            ->where('id_trx_rembug', $id_trx_rembug)
            ->first();

        return $show;
    }

    function total_droping($id_trx_rembug)
    {
        $show = KopTrxAnggota::select(DB::raw('SUM(amount::INTEGER) AS kas_awal'))
            ->where('id_trx_rembug', $id_trx_rembug)
            ->where('trx_type', 31)
            ->first();

        return $show;
    }

    function check_transaction($kode_cabang, $trx_date)
    {
        $show = KopTrxAnggota::select('e.kode_cabang', 'kop_trx_anggota.trx_date', 'kop_trx_anggota.trx_type', 'b.nama_trx', DB::raw('kop_trx_anggota.flag_debet_credit AS d_c'), 'b.gl_debit', DB::raw('c.nama_gl AS nama_gl_debit'), 'b.gl_credit', DB::raw('d.nama_gl AS nama_gl_credit'), DB::raw('SUM(kop_trx_anggota.amount) AS amount'))
            ->join('kop_anggota AS e', 'e.no_anggota', 'kop_trx_anggota.no_anggota')
            ->leftjoin('kop_list_trx_anggota AS b', 'b.kode_trx', 'kop_trx_anggota.trx_type')
            ->leftjoin('kop_gl AS c', 'c.kode_gl', 'b.gl_debit')
            ->leftjoin('kop_gl AS d', 'd.kode_gl', 'b.gl_credit')
            ->where('e.kode_cabang', $kode_cabang)
            ->where('kop_trx_anggota.trx_date', $trx_date)
            ->groupBy('e.kode_cabang', 'kop_trx_anggota.trx_date', 'kop_trx_anggota.trx_type', 'b.nama_trx', 'kop_trx_anggota.flag_debet_credit', 'b.gl_debit', 'c.nama_gl', 'b.gl_credit', 'd.nama_gl')
            ->orderBy('kop_trx_anggota.trx_date', 'ASC')
            ->orderBy('kop_trx_anggota.trx_type', 'ASC')
            ->get();

        return $show;
    }

    function buat_jurnal($kode_cabang, $voucher_date)
    {
        DB::select("SELECT fn_insert_jurnal_trx_anggota('" . $kode_cabang . "','" . $voucher_date . "')");
    }
}
