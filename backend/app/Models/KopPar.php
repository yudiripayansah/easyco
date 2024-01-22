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

    function rekap_par($kode_cabang, $rekap_by, $tanggal)
    {
        $statement = "SELECT
        COUNT(kp1.*) AS jumlah_1,
        COALESCE(SUM(kp1.saldo_pokok),0) AS saldo_pokok_1,
        COALESCE(SUM(kp1.cpp),0) AS cpp_1,
        COUNT(kp2.*) AS jumlah_2,
        COALESCE(SUM(kp2.saldo_pokok),0) AS saldo_pokok_2,
        COALESCE(SUM(kp2.cpp),0) AS cpp_2,
        COUNT(kp3.*) AS jumlah_3,
        COALESCE(SUM(kp3.saldo_pokok),0) AS saldo_pokok_3,
        COALESCE(SUM(kp3.cpp),0) AS cpp_3,
        COUNT(kp4.*) AS jumlah_4,
        COALESCE(SUM(kp4.saldo_pokok),0) AS saldo_pokok_4,
        COALESCE(SUM(kp4.cpp),0) AS cpp_4,
        COUNT(kp5.*) AS jumlah_5,
        COALESCE(SUM(kp5.saldo_pokok),0) AS saldo_pokok_5,
        COALESCE(SUM(kp5.cpp),0) AS cpp_5,
        COUNT(kp6.*) AS jumlah_6,
        COALESCE(SUM(kp6.saldo_pokok),0) AS saldo_pokok_6,
        COALESCE(SUM(kp6.cpp),0) AS cpp_6, ";

        if ($rekap_by == 1) {
            $statement .= "kop_cabang.nama_cabang AS keterangan
            FROM kop_cabang
            JOIN kop_anggota AS ka ON ka.kode_cabang = kop_cabang.kode_cabang
            JOIN kop_pengajuan AS kpj ON kpj.no_anggota = ka.no_anggota
            JOIN kop_pembiayaan AS kpb ON kpb.no_pengajuan = kpj.no_pengajuan
            LEFT JOIN kop_par AS kp1 ON kp1.kode_cabang = kop_cabang.kode_cabang AND kp1.no_rekening = kpb.no_rekening AND kp1.kategori_par::INTEGER = 0 AND kp1.tanggal_hitung = ? AND kp1.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp2 ON kp2.kode_cabang = kop_cabang.kode_cabang AND kp2.no_rekening = kpb.no_rekening AND kp2.kategori_par::INTEGER = 1 AND kp2.tanggal_hitung = ? AND kp2.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp3 ON kp3.kode_cabang = kop_cabang.kode_cabang AND kp3.no_rekening = kpb.no_rekening AND kp3.kategori_par::INTEGER = 2 AND kp3.tanggal_hitung = ? AND kp3.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp4 ON kp4.kode_cabang = kop_cabang.kode_cabang AND kp4.no_rekening = kpb.no_rekening AND kp4.kategori_par::INTEGER = 3 AND kp4.tanggal_hitung = ? AND kp4.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp5 ON kp5.kode_cabang = kop_cabang.kode_cabang AND kp5.no_rekening = kpb.no_rekening AND kp5.kategori_par::INTEGER = 4 AND kp5.tanggal_hitung = ? AND kp5.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp6 ON kp6.kode_cabang = kop_cabang.kode_cabang AND kp6.no_rekening = kpb.no_rekening AND kp6.kategori_par::INTEGER = 5 AND kp6.tanggal_hitung = ? AND kp6.freq_tunggakan > 0
            WHERE kpb.status_rekening = 1 AND kop_cabang.kode_cabang = ?
            GROUP BY kop_cabang.nama_cabang
            ORDER BY kop_cabang.nama_cabang";
        } elseif ($rekap_by == 2) {
            $statement .= "kop_pegawai.nama_pgw AS keterangan
            FROM kop_pegawai
            JOIN kop_rembug AS kr ON kr.kode_petugas = kop_pegawai.kode_pgw
            JOIN kop_anggota AS ka ON ka.kode_rembug = kr.kode_rembug
            JOIN kop_cabang AS kc ON kc.kode_cabang = ka.kode_cabang
            JOIN kop_pengajuan AS kpj ON kpj.no_anggota = ka.no_anggota
            JOIN kop_pembiayaan AS kpb ON kpb.no_pengajuan = kpj.no_pengajuan
            LEFT JOIN kop_par AS kp1 ON kp1.kode_cabang = kc.kode_cabang AND kp1.no_rekening = kpb.no_rekening AND kp1.kategori_par::INTEGER = 0 AND kp1.tanggal_hitung = ? AND kp1.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp2 ON kp2.kode_cabang = kc.kode_cabang AND kp2.no_rekening = kpb.no_rekening AND kp2.kategori_par::INTEGER = 1 AND kp2.tanggal_hitung = ? AND kp2.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp3 ON kp3.kode_cabang = kc.kode_cabang AND kp3.no_rekening = kpb.no_rekening AND kp3.kategori_par::INTEGER = 2 AND kp3.tanggal_hitung = ? AND kp3.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp4 ON kp4.kode_cabang = kc.kode_cabang AND kp4.no_rekening = kpb.no_rekening AND kp4.kategori_par::INTEGER = 3 AND kp4.tanggal_hitung = ? AND kp4.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp5 ON kp5.kode_cabang = kc.kode_cabang AND kp5.no_rekening = kpb.no_rekening AND kp5.kategori_par::INTEGER = 4 AND kp5.tanggal_hitung = ? AND kp5.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp6 ON kp6.kode_cabang = kc.kode_cabang AND kp6.no_rekening = kpb.no_rekening AND kp6.kategori_par::INTEGER = 5 AND kp6.tanggal_hitung = ? AND kp6.freq_tunggakan > 0
            WHERE kpb.status_rekening = 1 AND kc.kode_cabang = ?
            GROUP BY kop_pegawai.nama_pgw
            ORDER BY kop_pegawai.nama_pgw";
        } else {
            $statement .= "kop_rembug.nama_rembug AS keterangan
            FROM kop_rembug
            JOIN kop_anggota AS ka ON ka.kode_rembug = kop_rembug.kode_rembug
            JOIN kop_cabang AS kc ON kc.kode_cabang = ka.kode_cabang
            JOIN kop_pengajuan AS kpj ON kpj.no_anggota = ka.no_anggota
            JOIN kop_pembiayaan AS kpb ON kpb.no_pengajuan = kpj.no_pengajuan
            LEFT JOIN kop_par AS kp1 ON kp1.kode_cabang = kc.kode_cabang AND kp1.no_rekening = kpb.no_rekening AND kp1.kategori_par::INTEGER = 0 AND kp1.tanggal_hitung = ? AND kp1.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp2 ON kp2.kode_cabang = kc.kode_cabang AND kp2.no_rekening = kpb.no_rekening AND kp2.kategori_par::INTEGER = 1 AND kp2.tanggal_hitung = ? AND kp2.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp3 ON kp3.kode_cabang = kc.kode_cabang AND kp3.no_rekening = kpb.no_rekening AND kp3.kategori_par::INTEGER = 2 AND kp3.tanggal_hitung = ? AND kp3.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp4 ON kp4.kode_cabang = kc.kode_cabang AND kp4.no_rekening = kpb.no_rekening AND kp4.kategori_par::INTEGER = 3 AND kp4.tanggal_hitung = ? AND kp4.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp5 ON kp5.kode_cabang = kc.kode_cabang AND kp5.no_rekening = kpb.no_rekening AND kp5.kategori_par::INTEGER = 4 AND kp5.tanggal_hitung = ? AND kp5.freq_tunggakan > 0
            LEFT JOIN kop_par AS kp6 ON kp6.kode_cabang = kc.kode_cabang AND kp6.no_rekening = kpb.no_rekening AND kp6.kategori_par::INTEGER = 5 AND kp6.tanggal_hitung = ? AND kp6.freq_tunggakan > 0
            WHERE kpb.status_rekening = 1 AND kc.kode_cabang = ?
            GROUP BY kop_rembug.nama_rembug
            ORDER BY kop_rembug.nama_rembug";
        }

        $show = DB::select($statement, [$tanggal, $tanggal, $tanggal, $tanggal, $tanggal, $tanggal, $kode_cabang]);

        return $show;
    }
}
