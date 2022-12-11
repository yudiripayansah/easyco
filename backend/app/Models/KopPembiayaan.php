<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopPembiayaan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_pembiayaan';
    protected $fillable = ['kode_produk', 'kode_akad', 'kode_petugas', 'no_pengajuan', 'no_rekening', 'pokok', 'margin', 'nisbah_bagihasil', 'periode_jangka_waktu', 'jangka_waktu', 'angsuran_pokok', 'angsuran_margin', 'angsuran_catab', 'angsuran_minggon', 'biaya_administrasi', 'biaya_asuransi_jiwa', 'biaya_asuransi_jaminan', 'biaya_notaris', 'tabungan_persen', 'dana_kebajikan', 'tanggal_registrasi', 'tanggal_akad', 'tanggal_mulai_angsur', 'tanggal_jtempo', 'counter_angsuran', 'saldo_pokok', 'saldo_margin', 'saldo_catab', 'saldo_minggon', 'jtempo_angsuran_last', 'jtempo_angsuran_next', 'sumber_dana', 'dana_sendiri', 'dana_kreditur', 'kode_kreditur', 'ujroh_kreditur', 'ujroh_kreditur_persen', 'ujroh_kreditur_nominal', 'ujroh_kreditur_carabayar', 'status_pyd_kreditur', 'status_rekening', 'status_kolektibilitas', 'status_par', 'iswakalah', 'proses_wakalah', 'angsuran_jadwal_khusus', 'rescheduling', 'peruntukan', 'norek_tabungan', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_produk' => 'required',
            'kode_akad' => 'required',
            'no_pengajuan' => 'required',
            'no_rekening' => 'required|unique:kop_pembiayaan',
            'pokok' => 'numeric',
            'margin' => 'numeric',
            //'nisbah_bagihasil' => 'numeric',
            'periode_jangka_waktu' => 'numeric',
            'jangka_waktu' => 'required|numeric',
            'angsuran_pokok' => 'numeric',
            'angsuran_margin' => 'numeric',
            'angsuran_catab' => 'numeric',
            //'angsuran_minggon' => 'numeric',
            'biaya_administrasi' => 'numeric',
            'biaya_asuransi_jiwa' => 'numeric',
            //'biaya_asuransi_jaminan' => 'numeric',
            //'biaya_notaris' => 'numeric',
            //'tabungan_persen' => 'numeric',
            'dana_kebajikan' => 'numeric',
            'tanggal_registrasi' => 'required',
            'tanggal_akad' => 'required',
            'tanggal_mulai_angsur' => 'required',
            'tanggal_jtempo' => 'required',
            'saldo_pokok' => 'numeric',
            'saldo_margin' => 'numeric',
            'saldo_catab' => 'numeric',
            //'saldo_minggon' => 'numeric',
            //'jtempo_angsuran_last' => 'date',
            //'jtempo_angsuran_next' => 'date',
            'sumber_dana' => 'numeric',
            //'dana_sendiri' => 'numeric',
            //'dana_kreditur' => 'numeric',
            //'kode_kreditur' => 'numeric',
            //'ujroh_kreditur' => 'numeric',
            //'ujroh_kreditur_persen' => 'numeric',
            //'ujroh_kreditur_nominal' => 'numeric',
            //'ujroh_kreditur_carabayar' => 'numeric',
            //'angsuran_jadwal_khusus' => 'numeric',
            'peruntukan' => 'required|numeric',
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
            'kode_produk' => 'required',
            'kode_akad' => 'required',
            'pokok' => 'numeric',
            'margin' => 'numeric',
            //'nisbah_bagihasil' => 'numeric',
            'periode_jangka_waktu' => 'numeric',
            'jangka_waktu' => 'required|numeric',
            'angsuran_pokok' => 'numeric',
            'angsuran_margin' => 'numeric',
            'angsuran_catab' => 'numeric',
            //'angsuran_minggon' => 'numeric',
            'biaya_administrasi' => 'numeric',
            'biaya_asuransi_jiwa' => 'numeric',
            //'biaya_asuransi_jaminan' => 'numeric',
            //'biaya_notaris' => 'numeric',
            //'tabungan_persen' => 'numeric',
            'dana_kebajikan' => 'numeric',
            'tanggal_registrasi' => 'required',
            'tanggal_akad' => 'required',
            'tanggal_mulai_angsur' => 'required',
            'tanggal_jtempo' => 'required',
            'saldo_pokok' => 'numeric',
            'saldo_margin' => 'numeric',
            'saldo_catab' => 'numeric',
            //'saldo_minggon' => 'numeric',
            //'jtempo_angsuran_last' => 'date',
            //'jtempo_angsuran_next' => 'date',
            'sumber_dana' => 'numeric',
            //'dana_sendiri' => 'numeric',
            //'dana_kreditur' => 'numeric',
            //'kode_kreditur' => 'numeric',
            //'ujroh_kreditur' => 'numeric',
            //'ujroh_kreditur_persen' => 'numeric',
            //'ujroh_kreditur_nominal' => 'numeric',
            //'ujroh_kreditur_carabayar' => 'numeric',
            //'angsuran_jadwal_khusus' => 'numeric',
            'peruntukan' => 'required|numeric'
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

    function rembug($kode_cabang)
    {
        $show = DB::table('kop_rembug')->where('kode_cabang', $kode_cabang)->orderBy('id', 'ASC')->get();

        return $show;
    }

    function pengajuan($kode_rembug)
    {
        $param = array();

        if ($kode_rembug <> '00000') {
            $param['kr.kode_rembug'] = $kode_rembug;
        }

        $param['kp.status_pengajuan'] = 0;

        $show = DB::table('kop_pengajuan AS kp')
            ->select('kp.no_pengajuan', 'ka.no_anggota', 'ka.nama_anggota', 'kp.jumlah_pengajuan', 'kp.tanggal_pengajuan', 'kp.rencana_droping', 'kp.peruntukan', 'kp.keterangan_peruntukan', 'kp.pengajuan_ke')
            ->join('kop_anggota AS ka', 'ka.no_anggota', '=', 'kp.no_anggota')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', '=', 'ka.kode_rembug')
            ->where($param)
            ->get();

        return $show;
    }

    function fa($kode_cabang)
    {
        $param = array();

        if ($kode_cabang <> '00000') {
            $param['kc.kode_cabang'] = $kode_cabang;
        }

        $param['kkp.status_kas_petugas'] = 1;

        $show = DB::table('kop_kas_petugas AS kkp')
            ->select('kkp.kode_petugas', 'kkp.nama_kas_petugas')
            ->join('kop_user AS ku', 'ku.id_user', '=', 'kkp.id_user')
            ->leftJoin('kop_cabang AS kc', 'kc.kode_cabang', '=', 'ku.kode_cabang')
            ->where($param)
            ->get();

        return $show;
    }

    function peruntukan($nama_kode)
    {
        $show = DB::table('kop_list_kode')->where('nama_kode', $nama_kode)->orderBy('id', 'ASC')->get();

        return $show;
    }

    function product()
    {
        $show = DB::table('kop_prd_pembiayaan')->orderBy('kode_produk', 'ASC')->get();

        return $show;
    }

    function tpl_deposit($no_anggota)
    {
        $show = KopPembiayaan::select('kop_pembiayaan.no_rekening', 'kop_pembiayaan.angsuran_pokok', 'kop_pembiayaan.angsuran_margin', 'kop_pembiayaan.angsuran_catab', DB::raw('COALESCE((kop_pembiayaan.angsuran_pokok+kop_pembiayaan.angsuran_margin+kop_pembiayaan.angsuran_catab),0) AS angsuran'))
            ->join('kop_pengajuan AS kpp', 'kpp.no_pengajuan', '=', 'kop_pembiayaan.no_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', '=', 'kpp.no_anggota')
            ->where('kop_pembiayaan.status_rekening', 1)
            ->where('ka.no_anggota', $no_anggota)
            ->get();

        return $show;
    }

    function tpl_financing($no_anggota)
    {
        $show = KopPembiayaan::select('kpp.nama_singkat', 'kop_pembiayaan.counter_angsuran', 'kop_pembiayaan.jangka_waktu', 'kop_pembiayaan.pokok')
            ->join('kop_pengajuan AS kp', 'kp.no_pengajuan', '=', 'kop_pembiayaan.no_pengajuan')
            ->join('kop_prd_pembiayaan AS kpp', 'kpp.kode_produk', '=', 'kop_pembiayaan.kode_produk')
            ->where('kop_pembiayaan.status_rekening', 1)
            ->where('kp.no_anggota', $no_anggota)
            ->get();

        return $show;
    }

    function tpl_droping($no_anggota)
    {
        $show = KopPembiayaan::select('kop_pembiayaan.pokok', 'kop_pembiayaan.biaya_administrasi', 'kop_pembiayaan.biaya_asuransi_jiwa', 'kop_pembiayaan.biaya_asuransi_jaminan', 'kop_pembiayaan.biaya_notaris', 'kop_pembiayaan.tabungan_persen', 'kop_pembiayaan.dana_kebajikan')
            ->join('kop_pengajuan AS kpp', 'kpp.no_pengajuan', '=', 'kop_pembiayaan.no_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', '=', 'kpp.no_anggota')
            ->where('kop_pembiayaan.status_rekening', 1)
            ->where('kop_pembiayaan.status_droping', 0)
            ->where('ka.no_anggota', $no_anggota)
            ->get();

        return $show;
    }

    function report_list($kode_cabang, $jenis_pembiayaan, $kode_petugas, $kode_rembug, $produk, $from_date, $thru_date)
    {
        $show = KopPembiayaan::select('kc.nama_cabang', 'kr.nama_rembug', 'ka.no_anggota', 'ka.nama_anggota', 'kop_pembiayaan.no_rekening', 'ka.tempat_lahir', 'ka.tgl_lahir', 'kau.usia', 'ka.no_telp', 'kd.nama_desa', 'kop_pembiayaan.tanggal_registrasi', 'kpg.pengajuan_ke', 'kop_pembiayaan.pokok', 'kop_pembiayaan.margin', DB::raw('(kop_pembiayaan.angsuran_pokok+kop_pembiayaan.angsuran_margin+kop_pembiayaan.angsuran_catab+kop_pembiayaan.angsuran_minggon) AS angsuran'), 'kop_pembiayaan.biaya_administrasi', 'kop_pembiayaan.biaya_asuransi_jiwa', 'kop_pembiayaan.dana_kebajikan', 'kop_pembiayaan.jangka_waktu', 'kop_pembiayaan.periode_jangka_waktu', 'kop_pembiayaan.tanggal_akad', 'kop_pembiayaan.sumber_dana', 'kop_pembiayaan.status_rekening')
            ->join('kop_pengajuan AS kpg', 'kpg.no_pengajuan', '=', 'kop_pembiayaan.no_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', '=', 'kpg.no_anggota')
            ->join('kop_anggota_uk AS kau', 'kau.no_anggota', '=', 'ka.no_anggota')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', '=', 'ka.kode_cabang')
            ->leftjoin('kop_rembug AS kr', 'kr.kode_rembug', '=', 'ka.kode_rembug')
            ->leftjoin('kop_desa AS kd', 'kd.kode_desa', '=', 'kr.kode_desa')
            ->join('kop_list_kode AS klk', function ($join) {
                $join->on('klk.kode_value', '=', 'kop_pembiayaan.peruntukan')->where('klk.nama_kode', '=', 'peruntukan');
            })
            ->leftjoin('kop_list_kode AS oio', function ($joins) {
                $joins->on('oio.kode_value', '=', 'kop_pembiayaan.kode_kreditur')->where('oio.nama_kode', '=', 'kreditur');
            });

        if ($kode_cabang <> '~') {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($jenis_pembiayaan <> '~') {
            $show->where('kpg.jenis_pembiayaan', $jenis_pembiayaan);
        }

        if ($kode_petugas <> '~') {
            $show->where('kop_pembiayaan.kode_petugas', $kode_petugas);
        }

        if ($kode_rembug <> '~') {
            $show->where('kr.kode_rembug', $kode_rembug);
        }

        if ($produk <> '~') {
            $show->where('kop_pembiayaan.kode_produk', $produk);
        }

        $show->whereBetween('kop_pembiayaan.tanggal_registrasi', [$from_date, $thru_date])
            ->orderBy('kc.nama_cabang', 'ASC')
            ->orderBy('kop_pembiayaan.tanggal_registrasi', 'ASC');

        $show = $show->get();

        return $show;
    }
}
