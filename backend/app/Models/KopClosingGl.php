<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class KopClosingGl extends Model
{
    use SoftDeletes;

    protected $table = 'kop_closing_gl';

    function get_closing_date()
    {
        $show = KopClosingGl::select('thru_date_closing')->groupBy('thru_date_closing')->orderBy('thru_date_closing')->get();

        return $show;
    }

    function closing_balance_data($id, $from_date, $thru_date, $created_by)
    {
        DB::select("SELECT fn_insert_closing_balance_data('" . $id . "','" . $from_date . "','" . $thru_date . "','" . $created_by . "')");
    }

    function closing_financing_data($id, $from_date, $thru_date, $created_by)
    {
        DB::select("SELECT fn_insert_closing_financing_data('" . $id . "','" . $from_date . "','" . $thru_date . "','" . $created_by . "')");
    }

    function closing_saving_data($id, $from_date, $thru_date, $created_by)
    {
        DB::select("SELECT fn_insert_closing_saving_data('" . $id . "','" . $from_date . "','" . $thru_date . "','" . $created_by . "')");
    }

    function closing_ledger_data($branch_code, $from_date_lm, $from_date, $thru_date, $id, $created_by, $flag_akhir_tahun, $bulan_lama)
    {
        DB::select("SELECT fn_insert_closing_ledger_data('" . $branch_code . "','" . $from_date_lm . "','" . $from_date . "','" . $thru_date . "','" . $id . "','" . $created_by . "','" . $flag_akhir_tahun . "','" . $bulan_lama . "')");
    }
}
