<?php

namespace App\Exports;

use App\Models\KopAnggota;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListAnggotaMasukExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $kode_rembug, $from_date, $thru_date;

    function __construct($kode_cabang, $kode_rembug, $from_date, $thru_date)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_rembug = $kode_rembug;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
    }

    public function view(): View
    {
        $show = KopAnggota::select('kc.nama_cabang', 'kr.nama_rembug', 'kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kop_anggota.jenis_kelamin', 'kop_anggota.ibu_kandung', 'kop_anggota.tempat_lahir', 'kop_anggota.tgl_lahir', 'kop_anggota.alamat', 'kop_anggota.desa', 'kop_anggota.kecamatan', 'kop_anggota.kabupaten', 'kop_anggota.no_ktp', 'kop_anggota.no_telp', 'kop_anggota.pendidikan', 'kop_anggota.status_perkawinan', 'kop_anggota.nama_pasangan', 'kop_anggota.pekerjaan', 'kop_anggota.ket_pekerjaan', 'kop_anggota.pendapatan_perbulan', 'kop_anggota.tgl_gabung')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', '=', 'kop_anggota.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', '=', 'kop_anggota.kode_rembug')
            ->whereIn('kop_anggota.status', [0, 1, 2, 3]);

        if ($this->kode_cabang <> '00000') {
            $show->where('kc.kode_cabang', $this->kode_cabang);
        }

        if ($this->kode_rembug <> '00000') {
            $show->where('kr.kode_rembug', $this->kode_rembug);
        }

        $show->whereBetween('kop_anggota.tgl_gabung', [$this->from_date, $this->thru_date])
            ->orderBy('kc.kode_cabang', 'ASC')
            ->orderBy('kr.kode_rembug', 'ASC')
            ->orderBy('kop_anggota.no_anggota', 'ASC');

        $show = $show->get();

        return view('listanggotamasuk', ['anggotamasuk' => $show]);
    }
}
