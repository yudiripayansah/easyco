<?php

namespace App\Http\Controllers;

use App\Models\KopClosingGl;
use App\Http\Controllers\Controller;
use App\Models\KopCabang;
use App\Models\KopGl;
use App\Models\KopLembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClosingGlController extends Controller
{
    function get_closing_date()
    {
        $get = KopClosingGl::get_closing_date();

        $data = array();

        foreach ($get as $gt) {
            $data[] = array('thru_date_closing' => $gt['thru_date_closing']);
        }

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function closing(Request $request)
    {
        $periode = date('Y-m-d', strtotime(str_replace('/', '-', $request->periode_akhir)));

        $explode = explode('-', $periode);

        $from_date = $explode[0] . '-' . $explode[1] . '-01';
        $thru_date = $periode;

        $from_date_lm = date('Y-m-d', strtotime($from_date . ' - 1 MONTH'));

        $bulan_lama = substr($from_date_lm, 5, 2);

        $id_closing = collect(DB::select('SELECT uuid() AS id_closing'))->first()->id_closing;

        $created_by = 'SYSTEM';

        // DATE NEXT
        $next_from_date = date('Y-m-d', strtotime($from_date . ' + 1 MONTH'));
        $next_thru_date = date('Y-m-t', strtotime($from_date . ' + 1 MONTH'));

        $first_date_at_year = date('Y', strtotime($thru_date)) . '-01-01';
        $last_date_at_year = date('Y', strtotime($thru_date)) . '-12-' . date('t', strtotime($thru_date));

        // GET PERIODE
        $getPeriode = KopLembaga::first();
        $findPeriode = KopLembaga::find($getPeriode->id);

        $findPeriode->periode_awal = $next_from_date;
        $findPeriode->periode_akhir = $next_thru_date;

        $branchs = KopCabang::branch_gl();

        $month_of_date = date('m', strtotime($thru_date));

        if ($month_of_date == '12') {
            $getBranchAkhirTahun = KopCabang::branch_akhir_tahun($first_date_at_year, $last_date_at_year);
        }

        DB::beginTransaction();

        try {
            KopClosingGl::closing_balance_data($id_closing, $from_date, $thru_date, $created_by);
            KopClosingGl::closing_financing_data($id_closing, $from_date, $thru_date, $created_by);
            KopClosingGl::closing_saving_data($id_closing, $from_date, $thru_date, $created_by);

            foreach ($branchs as $br) {
                KopClosingGl::closing_ledger_data($br->kode_cabang, $from_date_lm, $from_date, $thru_date, $id_closing, $created_by, 'T', $bulan_lama);
            }

            if ($month_of_date == '12') {
                foreach ($getBranchAkhirTahun as $bat) {
                    // Tunggu fn dari Pak Amin
                }

                foreach ($branchs as $br) {
                    KopClosingGl::closing_ledger_data($br->kode_cabang, $from_date_lm, $from_date, $thru_date, $id_closing, $created_by, 'Y', $bulan_lama);
                }
            }

            $findPeriode->save();

            $res = array(
                'status' => TRUE,
                'data' => NULL,
                'msg' => 'Berhasil!'
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => $e->getMessage()
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
