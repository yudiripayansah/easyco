<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopDesa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_desa';
    protected $fillable = ['kode_desa', 'kode_kecamatan', 'nama_desa', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_desa' => 'required|numeric|unique:kop_desa',
            'kode_kecamatan' => 'required|numeric',
            'nama_desa' => 'required',
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
            'kode_kecamatan' => 'required|numeric',
            'nama_desa' => 'required'
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
        $show = DB::table('kop_desa')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kode_desa', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_desa', 'LIKE', '%' . $search . '%');
        }

        $show = $show->get();

        return $show;
    }
}
