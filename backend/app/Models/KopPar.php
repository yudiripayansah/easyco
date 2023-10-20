<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class KopPar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_par';

    function get_par_date($kode_cabang)
    {
        $show = KopPar::select('tanggal_hitung');

        if ($kode_cabang <> '00000') {
            $show->where('kode_cabang', $kode_cabang);
        }

        $show->groupBy('tanggal_hitung')->orderBy('tanggal_hitung', 'desc');

        $show = $show->get();

        return $show;
    }

    function get_kolektibilitas($kode_cabang, $tanggal_hitung, $perPage, $offset, $total)
    {
        $show = KopPar::select('f.nama_cabang', 'b.no_rekening', 'e.nama_rembug', 'd.no_anggota', 'd.nama_anggota', 'b.pokok', 'b.margin', 'b.jangka_waktu', 'b.tanggal_akad', 'b.tanggal_mulai_angsur', 'c.pengajuan_ke', 'b.angsuran_pokok', 'b.angsuran_margin', 'kop_par.angsuran_terbayar', DB::raw("((('" . $tanggal_hitung . "' - b.tanggal_mulai_angsur) / 7) + 1) AS seharusnya"), 'kop_par.saldo_pokok', 'kop_par.saldo_margin', 'kop_par.hari_nunggak', 'kop_par.freq_tunggakan', 'kop_par.tunggakan_pokok', 'kop_par.tunggakan_margin', DB::raw("(h.jumlah_hari_1||' - '||h.jumlah_hari_2) AS par_desc"), 'kop_par.cpp', 'kop_par.cadangan_piutang', 'g.nama_pgw')
            ->join('kop_pembiayaan AS b', 'b.no_rekening', 'kop_par.no_rekening')
            ->join('kop_pengajuan AS c', 'c.no_pengajuan', 'b.no_pengajuan')
            ->join('kop_anggota AS d', 'd.no_anggota', 'c.no_anggota')
            ->leftjoin('kop_rembug AS e', 'e.kode_rembug', 'd.kode_rembug')
            ->join('kop_cabang AS f', 'f.kode_cabang', 'd.kode_cabang')
            ->leftjoin('kop_pegawai AS g', 'g.kode_pgw', 'e.kode_petugas')
            ->join('kop_katgori_par AS h', 'h.kategori_par', 'kop_par.kategori_par')
            ->where('kop_par.tanggal_hitung', $tanggal_hitung);

        if ($kode_cabang <> '~') {
            $show->where('f.kode_cabang', $kode_cabang);
        }

        $show->orderBy('f.nama_cabang')
            ->orderBy('e.nama_rembug')
            ->orderBy('d.no_anggota')
            ->orderBy('d.nama_anggota')
            ->orderBy('kop_par.tunggakan_pokok', 'DESC');

        if ($total == 1) {
            if ($perPage != '~') {
                $show->skip($offset)->take($perPage);
            }
        }

        $show = $show->get();

        return $show;
    }

    function get_par($kode_cabang, $tanggal_hitung, $type)
    {
        $show = KopPar::select(DB::raw('SUM(saldo_pokok) AS saldo'))
            ->where('tanggal_hitung', $tanggal_hitung);

        if ($type == 0) {
            $show->whereIn('kategori_par', [2, 3, 4, 5]);
        }

        if ($kode_cabang <> '00000') {
            $show->where('kode_cabang', $kode_cabang);
        }

        $show = $show->first();

        return $show;
    }
}
