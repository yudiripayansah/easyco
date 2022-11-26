<?php

namespace App\Http\Controllers;

use App\Models\KopAnggota;
use App\Models\KopPembiayaan;
use App\Models\KopRembug;
use App\Models\KopTabungan;
use App\Models\KopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TplController extends Controller
{
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    function check_username(Request $request)
    {
        $username = $request->nama_user;

        $param = array('nama_user' => $username);

        $get = KopUser::where($param);

        $count = $get->count();

        $get = $get->first();

        if ($count > 0) {
            if ($get->status_user == 1) {
                $data = array('nama_user' => $get->nama_user);

                $res = array(
                    'status' => TRUE,
                    'data' => $data,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => NULL,
                    'msg' => 'Maaf! Username sudah tidak aktif',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Username tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function rembug(Request $request)
    {
        $kode_petugas = $request->kode_petugas;
        $hari_transaksi = $request->hari_transaksi;

        $read = KopRembug::tpl_rembug($kode_petugas, $hari_transaksi);

        $count = $read->count();

        if ($count > 0) {
            $data = array();

            foreach ($read as $rd) {
                $data[] = array(
                    'kode_rembug' => $rd->kode_rembug,
                    'nama_rembug' => $rd->nama_rembug,
                    'nama_desa' => $rd->nama_desa,
                    'jumlah' => $rd->jumlah
                );
            }

            $res = array(
                'status' => TRUE,
                'data' => $data,
                'msg' => 'Berhasil!',
                'error' => NULL
            );
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Data tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function member(Request $request)
    {
        $kode_rembug = $request->kode_rembug;

        $read = KopAnggota::tpl_member($kode_rembug);

        $count = $read->count();

        if ($count > 0) {
            $data = array();

            foreach ($read as $rd) {
                $data[] = array(
                    'no_anggota' => $rd->no_anggota,
                    'nama_anggota' => $rd->nama_anggota,
                    'kode_rembug' => $rd->kode_rembug,
                    'nama_rembug' => $rd->nama_rembug
                );
            }

            $res = array(
                'status' => TRUE,
                'data' => $data,
                'msg' => 'Berhasil!',
                'error' => NULL
            );
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Data tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function deposit(Request $request)
    {
        $no_anggota = $request->no_anggota;

        // ANGSURAN
        $getFinancing = KopPembiayaan::tpl_deposit($no_anggota)->first();
        $no_rekening = (isset($getFinancing->no_rekening) ? $getFinancing->no_rekening : '');
        $angsuran = (isset($getFinancing->angsuran) ? $getFinancing->angsuran : 0);
        $freq = (isset($getFinancing->angsuran) ? 1 : 0);

        // SIMPANAN WAJIB
        $param = array('no_anggota' => $no_anggota);
        $getMember = KopAnggota::where($param)->first();
        $simwa = $getMember->simwa;

        $read = KopTabungan::tpl_saving($no_anggota);

        $count = $read->count();

        $saving = array();

        if ($count > 0) {
            foreach ($read as $rd) {
                $saving[] = array(
                    'nama_produk' => $rd['nama_produk'],
                    'no_rekening' => $rd['no_rekening'],
                    'setoran' => str_replace('.', '', number_format($rd['setoran'], 0, ',', '.')),
                    'freq_saving' => (isset($rd['setoran']) ? 1 : 0)
                );
            }
        } else {
            $saving[] = array(
                'nama_produk' => NULL,
                'no_rekening' => NULL,
                'setoran' => 0,
                'freq_saving' => 0
            );
        }


        $data = array(
            'no_rekening' => $no_rekening,
            'angsuran' => str_replace('.', '', number_format($angsuran, 0, ',', '.')),
            'frekuensi' => $freq,
            'simwa' => str_replace('.', '', number_format($simwa, 0, ',', '.')),
            'berencana' => $saving
        );

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!',
            'error' => NULL
        );
        $response = response()->json($res, 200);

        return $response;
    }

    function process_deposit(Request $request)
    {
        $uuid = collect(DB::select('SELECT uuid() AS id_deposit'))->first()->id_deposit;
        echo $uuid;
    }
}
