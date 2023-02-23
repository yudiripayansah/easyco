<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopAnggotaMutasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_anggota_mutasi';
    protected $fillable = ['no_anggota', 'jenis_mutasi', 'alasan_mutasi', 'keterangan_mutasi', 'kode_rembug', 'kode_rembug_baru', 'tanggal_mutasi', 'saldo_pokok', 'saldo_margin', 'saldo_catab', 'saldo_minggon', 'saldo_sukarela', 'saldo_tab_berencana', 'saldo_deposito', 'saldo_simpok', 'saldo_simwa', 'bonus_bagihasil', 'setoran_tambahan', 'penarikan_sukarela', 'flag_saldo_margin', 'flag_saldo_catab', 'status_mutasi', 'kode_petugas', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'no_anggota' => 'required|numeric',
            'jenis_mutasi' => 'required|numeric',
            'alasan_mutasi' => 'required|numeric',
            'keterangan_mutasi' => 'required',
            'kode_rembug' => 'required|numeric',
            'kode_rembug_baru' => 'numeric',
            'tanggal_mutasi' => 'required',
            'saldo_pokok' => 'numeric',
            'saldo_margin' => 'numeric',
            'saldo_catab' => 'numeric',
            'saldo_minggon' => 'numeric',
            'saldo_sukarela' => 'numeric',
            'saldo_tab_berencana' => 'numeric',
            'saldo_deposito' => 'numeric',
            'saldo_simpok' => 'numeric',
            'saldo_simwa' => 'numeric',
            'bonus_bagihasil' => 'numeric',
            'setoran_tambahan' => 'numeric',
            'penarikan_sukarela' => 'numeric',
            'flag_saldo_margin' => 'numeric',
            'flag_saldo_catab' => 'numeric',
            'status_mutasi' => 'numeric',
            'kode_petugas' => 'numeric',
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
            'jenis_mutasi' => 'required|numeric',
            'alasan_mutasi' => 'required|numeric',
            'keterangan_mutasi' => 'required',
            'kode_rembug' => 'required|numeric',
            'kode_rembug_baru' => 'numeric',
            'tanggal_mutasi' => 'required',
            'saldo_pokok' => 'numeric',
            'saldo_margin' => 'numeric',
            'saldo_catab' => 'numeric',
            'saldo_minggon' => 'numeric',
            'saldo_sukarela' => 'numeric',
            'saldo_tab_berencana' => 'numeric',
            'saldo_deposito' => 'numeric',
            'saldo_simpok' => 'numeric',
            'saldo_simwa' => 'numeric',
            'bonus_bagihasil' => 'numeric',
            'setoran_tambahan' => 'numeric',
            'penarikan_sukarela' => 'numeric',
            'flag_saldo_margin' => 'numeric',
            'flag_saldo_catab' => 'numeric',
            'status_mutasi' => 'numeric',
            'kode_petugas' => 'numeric'
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

    function get_saldo_keluar($no_anggota)
    {
        $show = KopAnggota::select(DB::raw('COALESCE(SUM(kpb.saldo_pokok),0) AS saldo_pokok'), DB::raw('COALESCE(SUM(kpb.saldo_margin),0) AS saldo_margin'), DB::raw('COALESCE(SUM(kpb.saldo_catab),0) AS saldo_catab'), DB::raw('COALESCE(SUM(kpb.saldo_minggon),0) AS saldo_minggon'), DB::raw('COALESCE(SUM(kop_anggota.simpok),0) AS simpok'), DB::raw('COALESCE(SUM(kop_anggota.simwa),0) AS simwa'), DB::raw('COALESCE(SUM(kop_anggota.simsuk),0) AS simsuk'), DB::raw('COALESCE(SUM(kt.saldo),0) AS saldo_tabungan'), DB::raw('0 AS saldo_deposito'), DB::raw('0 AS bonus_bagihasil'))
            ->leftjoin('kop_pengajuan AS kp', 'kp.no_anggota', 'kop_anggota.no_anggota')
            ->leftjoin('kop_pembiayaan AS kpb', function ($join) {
                $join->on('kpb.no_pengajuan', 'kp.no_pengajuan')->where('kpb.status_rekening', 1);
            })
            ->leftjoin('kop_tabungan AS kt', function ($joins) {
                $joins->on('kt.no_anggota', 'kop_anggota.no_anggota')->where('kt.status_rekening', 1);
            })
            ->where('kop_anggota.no_anggota', $no_anggota)
            ->first();

        return $show;
    }
}
