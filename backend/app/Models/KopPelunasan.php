<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class KopPelunasan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_pelunasan';
    protected $fillable = ['id_trx_rembug', 'no_rekening', 'saldo_pokok', 'saldo_margin', 'saldo_catab', 'saldo_minggon', 'potongan_margin', 'flag_catab', 'status_pelunasan', 'tanggal_pelunasan', 'jenis_pembayaran', 'kode_kas_petugas', 'no_rekening_pinbuk', 'created_by'];

    function get_pelunasan($kode_cabang, $kode_petugas, $kode_rembug, $from_date, $thru_date)
    {
        $show = KopPelunasan::select('kop_pelunasan.tanggal_pelunasan', 'kpb.no_rekening', 'ka.nama_anggota', DB::raw("(CASE WHEN kr.kode_rembug IS NULL THEN 'INDIVIDU' ELSE kr.nama_rembug END) AS nama_rembug"), 'kpb.pokok', 'kpb.margin', 'kpb.jangka_waktu', 'kpb.periode_jangka_waktu', 'kpb.tanggal_jtempo', 'kpb.counter_angsuran', 'kop_pelunasan.saldo_pokok', 'kop_pelunasan.saldo_margin', 'kop_pelunasan.saldo_catab', 'kop_pelunasan.potongan_margin', DB::raw("(CASE WHEN kr.kode_rembug IS NULL THEN 'INDIVIDU' ELSE kp.nama_pgw END) AS nama_pgw"))
            ->join('kop_pembiayaan AS kpb', 'kpb.no_rekening', 'kop_pelunasan.no_rekening')
            ->join('kop_pengajuan AS kpg', 'kpg.no_pengajuan', 'kpb.no_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kpg.no_anggota')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'ka.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
            ->join('kop_pegawai AS kp', 'kp.kode_pgw', 'kr.kode_petugas')
            ->where('kop_pelunasan.status_pelunasan', 1);

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($kode_petugas <> '~' and $kode_petugas <> '00000' and !empty($kode_petugas) and $kode_petugas <> null) {
            $show->where('kp.kode_pgw', $kode_petugas);
        }

        if ($kode_rembug <> '~' and $kode_rembug <> '00000' and !empty($kode_rembug) and $kode_rembug <> null) {
            $show->where('kr.kode_rembug', $kode_rembug);
        }

        $show->whereBetween('kop_pelunasan.tanggal_pelunasan', [$from_date, $thru_date])
            ->orderBy('kc.kode_cabang', 'ASC')
            ->orderBy('kr.kode_rembug', 'ASC')
            ->orderBy('kop_pelunasan.tanggal_pelunasan', 'ASC');

        $show = $show->get();

        return $show;
    }
}
