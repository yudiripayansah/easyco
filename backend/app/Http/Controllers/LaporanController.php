<?php

namespace App\Http\Controllers;

use App\Exports\ListAnggotaMasukExport;
use App\Exports\ListPengajuanExport;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    function list_excel_anggota_masuk(Request $request)
    {
        $list = new ListAnggotaMasukExport($request->kode_cabang, $request->kode_rembug, $request->from_date, $request->thru_date);

        return $list->download('list_anggota_masuk_' . $request->kode_cabang . '_' . $request->kode_rembug . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_excel_pengajuan(Request $request)
    {
        $list = new ListPengajuanExport($request->kode_cabang, $request->jenis_pembiayaan, $request->kode_petugas, $request->kode_rembug, $request->from_date, $request->thru_date);

        return $list->download('list_pengajuan_' . $request->kode_cabang . '_' . $request->kode_rembug . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_excel_regis_akad(Request $request)
    {
        //
    }
}
