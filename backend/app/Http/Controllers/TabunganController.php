<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KopAnggota;
use App\Models\KopTabungan;
use App\Models\KopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    function registrasi(Request $request)
    {
        $data = $request->all();

        $sequence = KopTabungan::get_seq_rekening($request->no_anggota, $request->kode_produk);

        $format = '00';

        if ($sequence['jumlah'] == 0) {
            $tabungan_ke = 1;
        } else {
            $tabungan_ke = $sequence['jumlah'] + 1;
        }

        $tabungan_ke = substr($format . $tabungan_ke, '-2');

        $data['flag_taber'] = $request->jenis_tabungan;
        $data['tanggal_buka'] = date('Y-m-d');
        $data['no_rekening'] = $request->no_anggota . $request->kode_produk . $tabungan_ke;

        $validate = KopTabungan::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopTabungan::create($data);
                $find = KopTabungan::find($create->id);

                $res = array(
                    'status' => TRUE,
                    'data' => $find,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => $e->getMessage()
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function read(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'kop_tabungan.tanggal_buka';
        $search = NULL;
        $total = 0;
        $totalPage = 1;
        $from = NULL;
        $to = NULL;

        $token = $request->header('token');
        $param = array('token' => $token);
        $get = KopUser::where($param)->first();
        $cabang = $get->kode_cabang;

        if ($request->page) {
            $page = $request->page;
        }

        if ($request->perPage) {
            $perPage = $request->perPage;
        }

        if ($request->sortDir) {
            $sortDir = $request->sortDir;
        }

        if ($request->sortBy) {
            $sortBy = $request->sortBy;
        }

        if ($request->search) {
            $search = strtoupper($request->search);
        }

        if ($request->from) {
            $from = str_replace('/', '-', $request->from);
            $from = date('Y-m-d', strtotime($from));
        }

        if ($request->to) {
            $to = str_replace('/', '-', $request->to);
            $to = date('Y-m-d', strtotime($to));
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopTabungan::select('kop_tabungan.*', 'kop_anggota.nama_anggota', 'kop_prd_tabungan.nama_produk')
            ->join('kop_anggota', 'kop_anggota.no_anggota', 'kop_tabungan.no_anggota')
            ->join('kop_cabang', 'kop_cabang.kode_cabang', 'kop_anggota.kode_cabang')
            ->join('kop_prd_tabungan', 'kop_prd_tabungan.kode_produk', 'kop_tabungan.kode_produk')
            ->where('kop_tabungan.status_rekening', $request->status)
            ->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($cabang != '00000') {
            $read->where('kop_cabang.kode_cabang', $cabang);
        }

        if ($search) {
            $read->where('kop_anggota.no_anggota', 'LIKE', '%' . $search . '%')
                ->orWhere('kop_tabungan.no_rekening', 'LIKE', '%' . $search . '%');
        }

        if ($from && $to) {
            $read->whereBetween('kop_tabungan.tanggal_buka', [$from, $to]);
        }

        $read = $read->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $cabang || ($from && $to)) {
            $total = KopTabungan::orderBy($sortBy, $sortDir)
                ->join('kop_anggota', 'kop_anggota.no_anggota', 'kop_tabungan.no_anggota')
                ->join('kop_cabang', 'kop_cabang.kode_cabang', 'kop_anggota.kode_cabang')
                ->join('kop_prd_tabungan', 'kop_prd_tabungan.kode_produk', 'kop_tabungan.kode_produk')
                ->where('kop_tabungan.status_rekening', $request->status);

            if ($search) {
                $total->where('kop_anggota.no_anggota', 'LIKE', '%' . $search . '%')
                    ->orWhere('kop_tabungan.no_rekening', 'LIKE', '%' . $search . '%');
            }

            if ($cabang != '00000') {
                $total->where('kop_cabang.kode_cabang', $cabang);
            }

            if ($from && $to) {
                $total->whereBetween('kop_tabungan.tanggal_buka', [$from, $to]);
            }

            $total = $total->count();
        } else {
            $total = KopTabungan::all()->count();
        }

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        $res = array(
            'status' => TRUE,
            'data' => $read,
            'page' => $page,
            'perPage' => $perPage,
            'sortDir' => $sortDir,
            'sortBy' => $sortBy,
            'search' => $search,
            'total' => $total,
            'totalPage' => $totalPage,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    public function tutup(Request $request)
    {
        $get = KopTabungan::find($request->id);

        if ($get->saldo == 0) {
            $get->status_rekening = 9;
        } else {
            $get->status_rekening = 4;
        }

        $get->save();

        $res = array(
            'status' => TRUE,
            'data' => NULL,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    public function approve_tutup(Request $request)
    {
        $get = KopTabungan::find($request->id);

        $param = array('no_anggota' => $get->no_anggota);
        $sukarela = KopAnggota::where($param)->first();

        $getSukarela = KopAnggota::find($sukarela->id);
        $getSukarela->simsuk = $getSukarela->simsuk + $get->saldo;

        $get->status_rekening = 9;
        $get->saldo = 0;

        $getSukarela->save();
        $get->save();

        $res = array(
            'status' => TRUE,
            'data' => NULL,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    public function reject_tutup(Request $request)
    {
        $get = KopTabungan::find($request->id);

        $get->status_rekening = 1;
        $get->save();

        $res = array(
            'status' => TRUE,
            'data' => NULL,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }
}
