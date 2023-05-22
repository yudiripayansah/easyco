<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopCabang extends Model
{
    use SoftDeletes;

    protected $table = 'kop_cabang';
    protected $fillable = ['kode_cabang', 'nama_cabang', 'induk_cabang', 'jenis_cabang', 'pimpinan_cabang', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_cabang' => 'required|numeric|unique:kop_cabang',
            'nama_cabang' => 'required',
            'jenis_cabang' => 'numeric',
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
            'nama_cabang' => 'required'
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

    function read($search, $cabang, $sortBy, $sortDir, $offset, $perPage)
    {
        $show = KopCabang::orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($cabang != '00000') {
            $show->where('kode_cabang', $cabang);
        }

        if ($search <> NULL) {
            $show->where('nama_cabang', 'LIKE', '%' . $search . '%')
                ->orWhere('pimpinan_cabang', 'LIKE', '%' . $search . '%');
        }

        $show = $show->get();

        return $show;
    }
}
