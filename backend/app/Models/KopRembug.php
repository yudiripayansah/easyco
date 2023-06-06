<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopRembug extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_rembug';
    protected $fillable = ['kode_rembug', 'kode_cabang', 'kode_desa', 'kode_petugas', 'nama_rembug', 'tgl_pembentukan', 'hari_transaksi', 'jam_transaksi', 'status_aktif', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_rembug' => 'required|numeric|unique:kop_rembug',
            'kode_cabang' => 'required|numeric',
            'kode_desa' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'nama_rembug' => 'required',
            'tgl_pembentukan' => 'required',
            'hari_transaksi' => 'required|numeric',
            'jam_transaksi' => 'required|date_format:H:i',
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
            'kode_cabang' => 'required|numeric',
            'kode_desa' => 'required|numeric',
            'kode_petugas' => 'required|numeric',
            'nama_rembug' => 'required',
            'tgl_pembentukan' => 'required',
            'hari_transaksi' => 'required|numeric',
            'jam_transaksi' => 'required|date_format:H:i'
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

    function read($search, $sortBy, $sortDir, $offset, $perPage, $kode_cabang)
    {
        $show = KopRembug::select('kop_rembug.*', 'kc.kode_cabang')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'kop_rembug.kode_cabang');

        if ($kode_cabang != '00000') {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kode_rembug', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_rembug', 'LIKE', '%' . $search . '%');
        }

        $show->orderBy($sortBy, $sortDir);

        $show = $show->get();

        return $show;
    }

    function tpl_rembug($kode_petugas, $hari_transaksi)
    {
        $show = KopRembug::select('kop_rembug.kode_rembug', 'kop_rembug.nama_rembug', 'kd.nama_desa', DB::raw('COUNT(ka.*) AS jumlah'))
            ->join('kop_desa AS kd', 'kd.kode_desa', '=', 'kop_rembug.kode_desa')
            ->join('kop_kas_petugas AS kkp', 'kkp.kode_petugas', '=', 'kop_rembug.kode_petugas')
            ->join('kop_anggota AS ka', 'ka.kode_rembug', '=', 'kop_rembug.kode_rembug')
            ->where('ka.status', 1)
            ->where('kop_rembug.status_aktif', 1)
            ->where('kkp.kode_petugas', $kode_petugas)
            ->where('kop_rembug.hari_transaksi', $hari_transaksi)
            ->groupBy('kop_rembug.kode_rembug', 'kop_rembug.nama_rembug', 'kd.nama_desa')
            ->orderBy('kop_rembug.kode_rembug', 'ASC')
            ->get();

        return $show;
    }

    function generateKodeRembug($kode_cabang)
    {
        $show = KopRembug::select(DB::raw('CAST(MAX(RIGHT(kode_rembug,4)) AS INTEGER) AS kode_rembug'))
            ->where('kode_cabang', $kode_cabang)
            ->withTrashed()
            ->first();

        return $show;
    }
}
