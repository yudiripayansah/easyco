<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopPengajuan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_pengajuan';
    protected $fillable = ['no_anggota', 'kode_petugas', 'no_pengajuan', 'tanggal_pengajuan', 'jumlah_pengajuan', 'pengajuan_ke', 'peruntukan', 'keterangan_peruntukan', 'rencana_droping', 'rencana_periode_jwaktu', 'status_pengajuan', 'jenis_pembiayaan', 'sumber_pengembalian', 'doc_ktp', 'doc_kk', 'doc_pendukung', 'ttd_anggota', 'ttd_suami', 'ttd_ketua_majelis', 'ttd_tpl', 'no_pengajuan_o', 'no_anggota_o', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'no_anggota' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'tanggal_pengajuan' => 'required|date',
            'jumlah_pengajuan' => 'numeric',
            'pengajuan_ke' => 'required|numeric',
            'peruntukan' => 'required|numeric',
            'keterangan_peruntukan' => 'required',
            'rencana_droping' => 'required|date',
            'rencana_periode_jwaktu' => 'numeric',
            'jenis_pembiayaan' => 'numeric',
            'sumber_pengembalian' => 'numeric',
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
            'kode_petugas' => 'required|numeric',
            'tanggal_pengajuan' => 'required|date',
            'jumlah_pengajuan' => 'numeric',
            'pengajuan_ke' => 'required|numeric',
            'peruntukan' => 'required|numeric',
            'keterangan_peruntukan' => 'required',
            'rencana_droping' => 'required|date',
            'rencana_periode_jwaktu' => 'numeric',
            'jenis_pembiayaan' => 'numeric',
            'sumber_pengembalian' => 'numeric'
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
}
