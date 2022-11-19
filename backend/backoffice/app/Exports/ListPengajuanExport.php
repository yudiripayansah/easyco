<?php

namespace App\Exports;

use App\Models\KopPengajuan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListPengajuanExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $jenis_pembiayaan, $kode_petugas, $kode_rembug, $from_date, $thru_date;

    function __construct($kode_cabang, $jenis_pembiayaan, $kode_petugas, $kode_rembug, $from_date, $thru_date)
    {
        $this->kode_cabang = $kode_cabang;
        $this->jenis_pembiayaan = $jenis_pembiayaan;
        $this->kode_petugas = $kode_petugas;
        $this->kode_rembug = $kode_rembug;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
    }

    public function view(): View
    {
        $show = KopPengajuan::select('kc.nama_cabang', 'kr.nama_rembug', 'kop_pengajuan.no_pengajuan', 'ka.no_anggota', 'ka.nama_anggota', 'ka.no_ktp', 'ka.tempat_lahir', 'ka.tgl_lahir', 'ka.no_telp', 'kr.nama_rembug', 'kkp.nama_kas_petugas', 'kop_pengajuan.jenis_pembiayaan', 'kop_pengajuan.tanggal_pengajuan', 'kop_pengajuan.rencana_droping', 'kop_pengajuan.jumlah_pengajuan', 'kop_pengajuan.status_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', '=', 'kop_pengajuan.no_anggota')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', '=', 'ka.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', '=', 'ka.kode_rembug')
            ->join('kop_kas_petugas AS kkp', 'kkp.kode_petugas', '=', 'kr.kode_petugas')
            ->whereIn('kop_pengajuan.status_pengajuan', [0, 1]);

        if ($this->kode_cabang <> '00000') {
            $show->where('kc.kode_cabang', $this->kode_cabang);
        }

        if ($this->jenis_pembiayaan <> 9) {
            $show->where('kop_pengajuan.jenis_pembiayaan', $this->jenis_pembiayaan);
        }

        if ($this->kode_petugas <> '00000') {
            $show->where('kkp.kode_petugas', $this->kode_petugas);
        }

        if ($this->kode_rembug <> '00000') {
            $show->where('kr.kode_rembug', $this->kode_rembug);
        }

        $show->whereBetween('kop_pengajuan.tanggal_pengajuan', [$this->from_date, $this->thru_date])
            ->orderBy('kc.kode_cabang', 'ASC')
            ->orderBy('kr.kode_rembug', 'ASC')
            ->orderBy('kop_pengajuan.tanggal_pengajuan', 'ASC');

        $show = $show->get();

        return view('listpengajuan', ['pengajuan' => $show]);
    }
}
