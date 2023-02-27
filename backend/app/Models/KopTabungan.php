<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class KopTabungan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_tabungan';
    protected $fillable = ['no_anggota', 'no_rekening', 'tanggal_buka', 'created_by'];

    function tpl_saving($no_anggota)
    {
        $show = KopTabungan::select('kpt.nama_produk', 'kpt.nama_singkat', 'kop_tabungan.no_rekening', 'kop_tabungan.setoran', 'kop_tabungan.jangka_waktu', 'kop_tabungan.counter_setoran', 'kop_tabungan.saldo')
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
}
