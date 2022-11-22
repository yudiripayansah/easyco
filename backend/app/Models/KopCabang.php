<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD:backend/backoffice/app/Models/KopCabang.php
use Illuminate\Database\Eloquent\SoftDeletes;
=======
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Support\Facades\DB;
>>>>>>> working:backend/app/Models/KopCabang.php
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
            'jenis_cabang' => 'numeric'
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

    function read($search, $sortBy, $sortDir, $offset, $perPage)
    {
        $show = DB::table('kop_cabang')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kode_cabang', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_cabang', 'LIKE', '%' . $search . '%')
                ->orWhere('pimpinan_cabang', 'LIKE', '%' . $search . '%');
        }

        $show = $show->get();

        return $show;
    }
}
