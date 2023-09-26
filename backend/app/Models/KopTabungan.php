<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopTabungan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_tabungan';
    protected $fillable = ['kode_produk', 'no_anggota', 'no_rekening', 'saldo', 'flag_taber', 'jangka_waktu', 'periode_setoran', 'setoran', 'counter_setoran', 'status_rekening', 'tanggal_buka', 'tanggal_tutup', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_produk' => 'required|numeric',
            'no_anggota' => 'required|numeric',
            'no_rekening' => 'required',
            'tanggal_buka' => 'required',
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
            'kode_produk' => 'required|numeric',
            'no_anggota' => 'required|numeric',
            'no_rekening' => 'required',
            'tanggal_buka' => 'required'
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

    function get_saldo_tabungan($kode_cabang)
    {
        $show = KopTabungan::select(DB::raw('COALESCE(SUM(saldo),0) AS saldo_tabungan'))
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kop_tabungan.no_anggota')
            ->where('status_rekening', 1);

        if ($kode_cabang <> '00000') {
            $show = $show->where('ka.kode_cabang', $kode_cabang);
        }

        $show = $show->first();

        return $show;
    }

    function get_seq_rekening($no_anggota, $kode_produk)
    {
        $show = KopTabungan::select(DB::raw('COUNT(*) AS jumlah'))
            ->where('no_anggota', $no_anggota)
            ->where('kode_produk', $kode_produk)
            ->first();

        return $show;
    }

    function get_rekening_tabungan($no_anggota, $kode_produk)
    {
        $show = KopTabungan::select('*')
            ->where('no_anggota', $no_anggota)
            ->where('kode_produk', $kode_produk)
            ->first();

        return $show;
    }

    function get_all_rekening($no_anggota)
    {
        $show = KopTabungan::select('kop_tabungan.*', 'a.nama_produk')
            ->join('kop_prd_tabungan AS a', 'a.kode_produk', 'kop_tabungan.kode_produk')
            ->where('no_anggota', $no_anggota)
            ->get();

        return $show;
    }

    function tpl_saving($no_anggota)
    {
        $show = KopTabungan::select('kpt.nama_produk', 'kpt.nama_singkat', 'kop_tabungan.no_rekening', 'kop_tabungan.setoran', 'kop_tabungan.jangka_waktu', 'kop_tabungan.counter_setoran', 'kop_tabungan.saldo', 'kop_tabungan.kode_produk')
            ->join('kop_prd_tabungan AS kpt', 'kpt.kode_produk', '=', 'kop_tabungan.kode_produk')
            ->where('kop_tabungan.status_rekening', 1)
            ->where('kpt.jenis_tabungan', 1)
            ->where('kop_tabungan.no_anggota', $no_anggota)
            ->get();

        return $show;
    }

    function get_profile($no_anggota)
    {
        $show = KopTabungan::select('kop_tabungan.*', 'kpt.nama_produk', DB::raw('kop_tabungan.tanggal_tutup AS jatuh_tempo'), 'kop_tabungan.saldo', DB::raw('(CASE WHEN kop_tabungan.status_rekening = 1 THEN \'Aktif\' WHEN kop_tabungan.status_rekening = 2 THEN \'Blokir\' WHEN kop_tabungan.status_rekening = 3 THEN \'Verifikasi Anggota Keluar\' ELSE \'Tutup\' END) AS status_rekening'))
            ->join('kop_prd_tabungan AS kpt', 'kpt.kode_produk', 'kop_tabungan.kode_produk')
            ->where('kop_tabungan.no_anggota', $no_anggota)
            ->get();

        return $show;
    }

    function get_report_tabungan($kode_cabang, $kode_produk, $perPage, $offset, $total)
    {
        $show = KopTabungan::select('kop_tabungan.no_rekening', DB::raw("(CASE WHEN kr.kode_rembug IS NULL THEN 'INDIVIDU' ELSE kr.nama_rembug END) AS nama_rembug"), DB::raw("(CASE WHEN kp.kode_pgw IS NULL THEN 'INDIVIDU' ELSE kp.nama_pgw END) AS nama_pgw"), 'ka.no_anggota', 'ka.nama_anggota', 'kpt.nama_produk', 'kop_tabungan.saldo')
            ->join('kop_prd_tabungan AS kpt', 'kpt.kode_produk', 'kop_tabungan.kode_produk')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kop_tabungan.no_anggota')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'ka.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
            ->leftjoin('kop_pegawai AS kp', 'kp.kode_pgw', 'kr.kode_petugas')
            ->where('kop_tabungan.status_rekening', 1);

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($kode_produk <> '~' and $kode_produk <> '00000' and !empty($kode_produk) and $kode_produk <> null) {
            $show->where('kpt.kode_produk', $kode_produk);
        }

        $show->orderBy('ka.no_anggota', 'ASC');

        if ($total == 1) {
            if ($perPage != '~') {
                $show->skip($offset)->take($perPage);
            }
        }

        $show = $show->get();

        return $show;
    }

    function get_report_buka_tabungan($kode_cabang, $kode_produk, $from_date, $thru_date)
    {
        $show = KopTabungan::select('kc.nama_cabang', 'kop_tabungan.tanggal_buka', 'kop_tabungan.no_rekening', 'ka.nama_anggota', 'kpt.nama_produk', 'kop_tabungan.jangka_waktu', 'kop_tabungan.periode_setoran', 'kop_tabungan.saldo')
            ->join('kop_prd_tabungan AS kpt', 'kpt.kode_produk', 'kop_tabungan.kode_produk')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kop_tabungan.no_anggota')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'ka.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
            ->leftjoin('kop_pegawai AS kp', 'kp.kode_pgw', 'kr.kode_petugas')
            ->where('kop_tabungan.status_rekening', 1)
            ->whereBetween('kop_tabungan.tanggal_buka', [$from_date, $thru_date]);

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($kode_produk <> '~' and $kode_produk <> '00000' and !empty($kode_produk) and $kode_produk <> null) {
            $show->where('kpt.kode_produk', $kode_produk);
        }

        $show->orderBy('ka.no_anggota', 'ASC');

        $show = $show->get();

        return $show;
    }
}
