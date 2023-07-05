<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopAnggota extends Model
{
    use SoftDeletes;

    protected $table = 'kop_anggota';
    protected $fillable = ['kode_cabang', 'kode_rembug', 'no_anggota', 'nama_anggota', 'jenis_kelamin', 'ibu_kandung', 'tempat_lahir', 'tgl_lahir', 'alamat', 'desa', 'kecamatan', 'kabupaten', 'kodepos', 'no_ktp', 'no_npwp', 'no_telp', 'pendidikan', 'status_perkawinan', 'nama_pasangan', 'pekerjaan', 'ket_pekerjaan', 'pendapatan_perbulan', 'simpok', 'simwa', 'simsuk', 'tgl_gabung', 'status', 'tanggal_keluar', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_cabang' => 'required|numeric',
            'nama_anggota' => 'required',
            'jenis_kelamin' => 'required',
            'ibu_kandung' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'no_ktp' => 'required|numeric',
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
            'nama_anggota' => 'required',
            'jenis_kelamin' => 'required',
            'ibu_kandung' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'no_ktp' => 'required|numeric'
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

    function rembug($kode_cabang)
    {
        $show = KopRembug::orderBy('id', 'ASC');

        if ($kode_cabang <> '00000') {
            $show = $show->where('kode_cabang', $kode_cabang);
        }

        $show = $show->get();

        return $show;
    }

    function tpl_member($kode_rembug)
    {
        $show = KopAnggota::select('kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kr.kode_rembug', 'kr.nama_rembug')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', '=', 'kop_anggota.kode_rembug')
            ->where('kr.kode_rembug', $kode_rembug)
            ->orderBy('kop_anggota.no_anggota', 'ASC')
            ->get();

        return $show;
    }

    function tpl_trx_member($kode_rembug, $trx_date)
    {
        $show = KopAnggota::select('kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kr.kode_rembug', 'kr.nama_rembug')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'kop_anggota.kode_rembug')
            ->leftjoin('kop_trx_anggota AS kta', function ($join) use ($trx_date) {
                $join->on('kta.no_anggota', 'kop_anggota.no_anggota')
                    ->where('kta.verified_by', null)
                    ->where('kta.trx_date', $trx_date);
            })
            ->where('kr.kode_rembug', $kode_rembug)
            ->groupBy('kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kr.kode_rembug', 'kr.nama_rembug', 'kta.created_by')
            ->orderBy('kta.created_by', 'DESC')
            ->orderBy('kop_anggota.no_anggota', 'ASC')
            ->get();

        return $show;
    }

    function report_list($kode_cabang, $kode_rembug, $from_date, $thru_date)
    {
        $show = KopAnggota::select('kop_anggota.*', 'kc.nama_cabang', 'kr.nama_rembug', DB::raw('COALESCE(kp.saldo_pokok+kp.saldo_margin,0) AS saldo_outstanding'))
            ->join('kop_cabang AS kc', 'kc.kode_cabang', '=', 'kop_anggota.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', '=', 'kop_anggota.kode_rembug')
            ->leftjoin('kop_pengajuan AS kpg', function ($join) {
                $join->on('kpg.no_anggota', 'kop_anggota.no_anggota')->where('kpg.status_pengajuan', 1);
            })
            ->leftjoin('kop_pembiayaan AS kp', function ($join) {
                $join->on('kp.no_pengajuan', 'kpg.no_pengajuan')->where('kp.status_rekening', 1);
            });

        if ($kode_cabang <> '~') {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($kode_rembug <> '~') {
            $show->where('kr.kode_rembug', $kode_rembug);
        }

        if ($from_date <> '~' and $thru_date <> '~') {
            $show->whereBetween('kop_anggota.tgl_gabung', [$from_date, $thru_date]);
        }

        $show->orderBy('kc.kode_cabang', 'ASC')
            ->orderBy('kr.kode_rembug', 'ASC')
            ->orderBy('kop_anggota.no_anggota', 'ASC');

        $show = $show->get();

        return $show;
    }

    function member_dashboard($no_anggota)
    {
        $show = KopAnggota::select('kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kr.nama_rembug', 'kd.nama_desa', 'kop_anggota.simpok', 'kop_anggota.simwa', 'kop_anggota.simsuk', DB::raw('COALESCE(SUM(kpb.saldo_pokok),0) AS saldo_outstanding'), DB::raw('COALESCE(SUM(kt.saldo),0) AS saldo_tab_berencana'))
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'kop_anggota.kode_rembug')
            ->join('kop_desa AS kd', 'kd.kode_desa', 'kr.kode_desa')
            ->leftjoin('kop_pengajuan AS kp', 'kp.no_anggota', 'kop_anggota.no_anggota')
            ->leftjoin('kop_pembiayaan AS kpb', function ($join) {
                $join->on('kpb.no_pengajuan', 'kp.no_pengajuan')->where('kpb.status_rekening', 1);
            })
            ->leftjoin('kop_tabungan AS kt', function ($joins) {
                $joins->on('kt.no_anggota', 'kop_anggota.no_anggota')->where('kt.flag_taber', 1)->where('kt.status_rekening', 1);
            })
            ->where('kop_anggota.no_anggota', $no_anggota)
            ->groupBy('kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kr.nama_rembug', 'kd.nama_desa', 'kop_anggota.simpok', 'kop_anggota.simwa', 'kop_anggota.simsuk')
            ->first();

        return $show;
    }

    function get_profile($no_anggota)
    {
        $show = KopAnggota::select('kop_anggota.*', 'kau.*', DB::raw('(CASE WHEN kop_anggota.kode_rembug IS NULL THEN \'Individu\' ELSE kr.nama_rembug END) AS nama_rembug'))
            ->join('kop_anggota_uk AS kau', 'kau.no_anggota', 'kop_anggota.no_anggota')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', 'kop_anggota.kode_rembug')
            ->where('kop_anggota.no_anggota', $no_anggota)
            ->first();

        return $show;
    }
}
