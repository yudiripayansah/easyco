<?php

namespace App\Http\Controllers;

use App\Models\KopPar;
use Illuminate\Http\Request;

class ParController extends Controller
{
    function get_par_date(Request $request)
    {
        $kode_cabang = $request->kode_cabang;

        $get = KopPar::get_par_date($kode_cabang);

        $data = array();

        foreach ($get as $gt) {
            $data[] = array('tanggal_hitung' => $gt['tanggal_hitung']);
        }

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function get_kolektibilitas(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $tanggal_hitung = $request->tanggal_hitung;
        $tanggal_hitung = str_replace('/', '-', $tanggal_hitung);
        $tanggal_hitung = date('Y-m-d', strtotime($tanggal_hitung));

        $get = KopPar::get_kolektibilitas($kode_cabang, $tanggal_hitung);

        $data = array();

        foreach ($get as $gt) {
            $data[] = array(
                'nama_cabang' => $gt['nama_cabang'],
                'no_rekening' => $gt['no_rekening'],
                'nama_rembug' => $gt['nama_rembug'],
                'no_anggota' => $gt['no_anggota'],
                'nama_anggota' => $gt['nama_anggota'],
                'pokok' => (int) $gt['pokok'],
                'margin' => (int) $gt['margin'],
                'jangka_waktu' => $gt['jangka_waktu'],
                'tanggal_akad' => $gt['tanggal_akad'],
                'tanggal_mulai_angsur' => $gt['tanggal_mulai_angsur'],
                'pengajuan_ke' => $gt['pengajuan_ke'],
                'angsuran_pokok' => (int) $gt['angsuran_pokok'],
                'angsuran_margin' => (int) $gt['angsuran_margin'],
                'angsuran_terbayar' => $gt['angsuran_terbayar'],
                'seharusnya' => $gt['seharusnya'],
                'saldo_pokok' => (int) $gt['saldo_pokok'],
                'saldo_margin' => (int) $gt['saldo_margin'],
                'hari_nunggak' => $gt['hari_nunggak'],
                'freq_tunggakan' => $gt['freq_tunggakan'],
                'tunggakan_pokok' => (int) $gt['tunggakan_pokok'],
                'tunggakan_margin' => (int) $gt['tunggakan_margin'],
                'par_desc' => $gt['par_desc'],
                'cpp' => $gt['cpp'],
                'cadangan_piutang' => (int) $gt['cadangan_piutang'],
                'nama_pgw' => $gt['nama_pgw']
            );
        }

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }
}
