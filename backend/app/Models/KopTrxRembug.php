<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopTrxRembug extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_trx_rembug';
    protected $fillable = ['id_trx_rembug', 'kode_rembug', 'kode_petugas', 'trx_date', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'id_trx_rembug' => 'required',
            'kode_rembug' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'trx_date' => 'required',
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

    function get_exist($kode_rembug, $kode_petugas, $trx_date)
    {
        $show = KopTrxRembug::select('*')
            ->where('kode_rembug', $kode_rembug)
            ->where('kode_petugas', $kode_petugas)
            ->where('trx_date', $trx_date)
            ->first();

        return $show;
    }

    function get_count($kode_rembug, $kode_petugas, $trx_date)
    {
        $show = KopTrxRembug::select(DB::raw('COUNT(*) AS jumlah'))
            ->where('kode_rembug', $kode_rembug)
            ->where('kode_petugas', $kode_petugas)
            ->where('trx_date', $trx_date)
            ->first();

        return $show;
    }

    function get_all_transaction($branch_code, $from_date, $thru_date)
    {
        $show = KopTrxRembug::select('kop_trx_rembug.id_trx_rembug', 'kr.kode_rembug', 'kr.nama_rembug', 'kc.nama_cabang', 'kop_trx_rembug.trx_date', 'kkp.nama_kas_petugas', 'kop_trx_rembug.infaq')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'kop_trx_rembug.kode_rembug')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'kr.kode_cabang')
            ->join('kop_kas_petugas AS kkp', 'kkp.kode_petugas', 'kop_trx_rembug.kode_petugas')
            ->where('kop_trx_rembug.verified_by', NULL);

        if ($branch_code <> '00000') {
            $show->where('kc.kode_cabang', $branch_code);
        }

        $show->whereBetween('kop_trx_rembug.trx_date', [$from_date, $thru_date])
            ->orderBy('kc.nama_cabang', 'desc')
            ->orderBy('kop_trx_rembug.trx_date', 'desc');

        $show = $show->get();

        return $show;
    }

    function total_cashflow($kode_rembug, $trx_date, $flag)
    {
        $show = KopTrxRembug::select(DB::raw('COALESCE(SUM(amount),0) AS amount'))
            ->join('kop_trx_anggota AS kta', 'kta.id_trx_rembug', 'kop_trx_rembug.id_trx_rembug')
            ->where('kop_trx_rembug.kode_rembug', $kode_rembug)
            ->where('kop_trx_rembug.trx_date', $trx_date)
            ->where('kta.flag_debet_credit', $flag)
            ->first();

        return $show;
    }

    function get_rembug_verification($id_trx_rembug)
    {
        $show = KopTrxRembug::select('kc.nama_cabang', 'kop_trx_rembug.trx_date', 'kr.nama_rembug', 'kkp.nama_kas_petugas')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'kop_trx_rembug.kode_rembug')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'kr.kode_cabang')
            ->join('kop_kas_petugas AS kkp', 'kkp.kode_petugas', 'kop_trx_rembug.kode_petugas')
            ->where('kop_trx_rembug.id_trx_rembug', $id_trx_rembug)
            ->first();

        return $show;
    }

    function total_cashflow_verification($id_trx_rembug, $flag)
    {
        $show = KopTrxRembug::select(DB::raw('COALESCE(SUM(amount),0) AS amount'))
            ->join('kop_trx_anggota AS kta', 'kta.id_trx_rembug', 'kop_trx_rembug.id_trx_rembug')
            ->where('kop_trx_rembug.id_trx_rembug', $id_trx_rembug)
            ->where('kta.flag_debet_credit', $flag)
            ->first();

        return $show;
    }

    function get_detail($id_trx_rembug)
    {
        $statement = "SELECT
        ka.no_anggota,
        ka.nama_anggota,
        COALESCE(a.frek,0) AS frek,
        COALESCE(b.angsuran,0) AS angsuran,
        COALESCE(c.setoran_sukarela,0) AS setoran_sukarela,
        COALESCE(d.setoran_simpok,0) AS setoran_simpok,
        COALESCE(e.setoran_taber,0) AS setoran_taber,
        COALESCE(f.penarikan_sukarela,0) AS penarikan_sukarela,
        COALESCE(g.pokok,0) AS pokok,
        COALESCE(g.biaya_administrasi,0) AS biaya_administrasi,
        COALESCE(g.biaya_asuransi_jiwa,0) AS biaya_asuransi_jiwa
        FROM kop_anggota AS ka
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            (SUM(kta.amount) / kp.angsuran_pokok) AS frek
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            JOIN kop_pembiayaan AS kp ON kp.no_rekening = kta.no_rekening
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '32'
            GROUP BY kta.no_anggota,kp.angsuran_pokok
        ) AS a ON a.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS angsuran
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type IN('32','33','34')
            GROUP BY 1
        ) AS b ON b.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS setoran_sukarela
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '13'
            GROUP BY 1
        ) AS c ON c.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS setoran_simpok
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '11'
            GROUP BY 1
        ) AS d ON d.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS setoran_taber
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '21'
            GROUP BY 1
        ) AS e ON e.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS penarikan_sukarela
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '22'
            GROUP BY 1
        ) AS f ON f.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            kp.pokok,
            kp.biaya_administrasi,
            kp.biaya_asuransi_jiwa
            FROM kop_pembiayaan AS kp
            JOIN kop_pengajuan AS kpg ON kpg.no_pengajuan = kp.no_pengajuan
            JOIN kop_trx_anggota AS kta ON kta.no_anggota = kpg.no_anggota
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kp.status_rekening = '1' AND kp.status_droping = '0'
            GROUP BY 1,2,3,4
        ) AS g ON g.no_anggota = ka.no_anggota
        WHERE ka.status <> 2";

        $show = DB::select($statement, [$id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug]);

        return $show;
    }
}
