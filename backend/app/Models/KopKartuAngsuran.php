<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KopKartuAngsuran extends Model
{
    use HasFactory;

    protected $table = 'kop_kartu_angsuran';

    function get_history_financing($no_rekening)
    {
        $show = KopKartuAngsuran::select('tgl_angsuran', 'tgl_bayar', 'angsuran_ke', 'angsuran_pokok', 'angsuran_margin', 'saldo_pokok', 'saldo_margin')
            ->where('no_rekening', $no_rekening)
            ->orderBy('angsuran_ke', 'ASC')
            ->get();

        return $show;
    }

    function get_detail_profile($no_rekening)
    {
        $show = KopPembiayaan::select('ka.nama_anggota', DB::raw("(CASE WHEN kr.kode_rembug IS NULL THEN 'INDIVIDU' ELSE kr.nama_rembug END) AS nama_rembug"), 'kpp.nama_singkat', 'kop_pembiayaan.pokok', 'kop_pembiayaan.margin', 'kop_pembiayaan.tanggal_akad', 'kop_pembiayaan.saldo_pokok', 'kop_pembiayaan.saldo_margin', 'kp.pengajuan_ke', DB::raw("(CASE WHEN kop_pembiayaan.status_rekening = 1 THEN 'AKTIF' WHEN kop_pembiayaan.status_rekening = 2 THEN 'LUNAS' ELSE 'REGISTRASI' END) AS status_rekening"))
            ->join('kop_prd_pembiayaan AS kpp', 'kpp.kode_produk', 'kop_pembiayaan.kode_produk')
            ->join('kop_pengajuan AS kp', 'kp.no_pengajuan', 'kop_pembiayaan.no_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kp.no_anggota')
            ->leftJoin('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
            ->where('kop_pembiayaan.no_rekening', $no_rekening)
            ->first();

        return $show;
    }
}
