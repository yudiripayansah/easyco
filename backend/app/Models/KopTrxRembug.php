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
            ->where('verified_by', null)
            ->first();

        return $show;
    }

    function get_count($kode_rembug, $kode_petugas, $trx_date)
    {
        $show = KopTrxRembug::select(DB::raw('COUNT(*) AS jumlah'))
            ->where('kode_rembug', $kode_rembug)
            ->where('kode_petugas', $kode_petugas)
            ->where('trx_date', $trx_date)
            ->where('verified_by', null)
            ->first();

        return $show;
    }

    function get_all_transaction($branch_code, $fa_code, $cm_code, $from_date, $thru_date, $flag)
    {
        $show = KopTrxRembug::select('kop_trx_rembug.id_trx_rembug', 'kr.kode_rembug', 'kr.nama_rembug', 'kc.nama_cabang', 'kop_trx_rembug.trx_date', 'kkp.nama_kas_petugas', 'kp.nama_pgw', DB::raw('kop_trx_rembug.infaq::INTEGER AS infaq'), 'kop_trx_rembug.verified_by', 'kop_trx_rembug.created_at')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'kop_trx_rembug.kode_rembug')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'kr.kode_cabang')
            ->join('kop_kas_petugas AS kkp', 'kkp.kode_petugas', 'kop_trx_rembug.kode_petugas')
            ->join('kop_pegawai AS kp', 'kp.kode_pgw', 'kkp.kode_petugas');

        if ($flag == 1) {
            $show->where('kop_trx_rembug.verified_by', NULL);
        }

        if ($branch_code <> '00000') {
            $show->where('kc.kode_cabang', $branch_code);
        }

        if ($fa_code <> '') {
            $show->where('kp.kode_pgw', $fa_code);
        }

        if ($cm_code <> '') {
            $show->where('kr.kode_rembug', $cm_code);
        }

        $show->whereBetween('kop_trx_rembug.trx_date', [$from_date, $thru_date])
            ->orderBy('kc.nama_cabang', 'desc')
            ->orderBy('kop_trx_rembug.trx_date', 'desc');

        $show = $show->get();

        return $show;
    }

    function total_cashflow($kode_rembug, $trx_date, $flag)
    {
        $show = KopTrxRembug::select(DB::raw('COALESCE(SUM(amount::INTEGER),0) AS amount'))
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
        h.id_trx_rembug,
        ka.no_anggota,
        ka.nama_anggota,
        COALESCE(CAST(ROUND(a.frek) AS INTEGER),0) AS frek,
        COALESCE(b.angsuran::INTEGER,0) AS angsuran,
        COALESCE(c.setoran_sukarela::INTEGER,0) AS setoran_sukarela,
        COALESCE(d.setoran_simpok::INTEGER,0) AS setoran_simpok,
        COALESCE(e.setoran_taber::INTEGER,0) AS setoran_taber,
        COALESCE(f.penarikan_sukarela::INTEGER,0) AS penarikan_sukarela,
        COALESCE(g.pokok::INTEGER,0) AS pokok,
        COALESCE(g.biaya_administrasi::INTEGER,0) AS biaya_administrasi,
        COALESCE(g.biaya_asuransi_jiwa::INTEGER,0) AS biaya_asuransi_jiwa,
        COALESCE(i.angsuran_pokok::INTEGER,0) AS angsuran_pokok,
        COALESCE(j.angsuran_margin::INTEGER,0) AS angsuran_margin,
        COALESCE(k.angsuran_catab::INTEGER,0) AS angsuran_catab,
        COALESCE(l.dana_kebajikan::INTEGER,0) AS dana_kebajikan,
        COALESCE(m.dana_gotong_royong::INTEGER,0) AS dana_gotong_royong
        FROM kop_anggota AS ka
        JOIN kop_trx_rembug AS h ON h.kode_rembug = ka.kode_rembug
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
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type IN('11','12','16')
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
            WHERE ktr.id_trx_rembug = ? AND kp.status_rekening = '0' AND kp.status_droping = '1'
            GROUP BY 1,2,3,4
        ) AS g ON g.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS angsuran_pokok
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '32'
            GROUP BY 1
        ) AS i ON i.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS angsuran_margin
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '33'
            GROUP BY 1
        ) AS j ON j.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS angsuran_catab
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '34'
            GROUP BY 1
        ) AS k ON k.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS dana_kebajikan
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '37'
            GROUP BY 1
        ) AS l ON l.no_anggota = ka.no_anggota
        LEFT JOIN (
            SELECT
            kta.no_anggota,
            SUM(kta.amount) AS dana_gotong_royong
            FROM kop_trx_anggota AS kta
            JOIN kop_trx_rembug AS ktr ON ktr.id_trx_rembug = kta.id_trx_rembug
            WHERE ktr.id_trx_rembug = ? AND kta.trx_type = '38'
            GROUP BY 1
        ) AS m ON m.no_anggota = ka.no_anggota
        WHERE h.id_trx_rembug = ? AND ka.status <> 2";

        $show = DB::select($statement, [$id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug, $id_trx_rembug]);

        return $show;
    }

    function check_unverified($from, $thru)
    {
        $show = KopTrxRembug::select(DB::raw('COUNT(*) AS jumlah'))
            ->whereBetween('trx_date', [$from, $thru])
            ->where('verified_by', null)
            ->first();

        return $show;
    }
}
