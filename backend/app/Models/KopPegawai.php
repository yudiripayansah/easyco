<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopPegawai extends Model
{
    use SoftDeletes;

    protected $table = 'kop_pegawai';
    protected $fillable = ['kode_cabang', 'kode_pgw', 'nama_pgw', 'jenis_kelamin', 'alamat_pgw', 'no_ktp', 'no_hp', 'jabatan', 'tgl_gabung', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_pgw' => 'required|numeric|unique:kop_pegawai',
            'kode_cabang' => 'required|numeric',
            'nama_pgw' => 'required',
            'jenis_kelamin' => 'required',
            'no_ktp' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jabatan' => 'required',
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
            'nama_pgw' => 'required',
            'jenis_kelamin' => 'required',
            'no_ktp' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jabatan' => 'required'
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
        $show = KopPegawai::select('kop_pegawai.*', 'klk.kode_display')
            ->join('kop_cabang AS kc', 'kc.kode_cabang', 'kop_pegawai.kode_cabang')
            ->join('kop_list_kode AS klk', function ($join) {
                $join->on('klk.kode_value', DB::raw('kop_pegawai.jabatan::INTEGER'))->where('klk.nama_kode', 'jabatan');
            });

        if ($kode_cabang != '00000') {
            $show->where('kc.kode_cabang', $kode_cabang);
        }

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kode_pgw', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_pgw', 'LIKE', '%' . $search . '%')
                ->orWhere('jabatan', 'LIKE', '%' . $search . '%');
        }

        $show->orderBy($sortBy, $sortDir);

        $show = $show->get();

        return $show;
    }

    function generateKodePegawai($kode_cabang)
    {
        $show = KopPegawai::select(DB::raw('CAST(MAX(RIGHT(kode_pgw,4)) AS INTEGER) AS kode_pgw'))
            ->where('kode_cabang', $kode_cabang)
            ->withTrashed()
            ->first();

        return $show;
    }
}
