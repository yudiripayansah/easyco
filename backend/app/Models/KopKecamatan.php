<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopKecamatan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_kecamatan';
    protected $fillable = ['kode_kecamatan', 'kode_kota', 'nama_kecamatan', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_kecamatan' => 'required|numeric|unique:kop_kecamatan',
            'kode_kota' => 'required|numeric',
            'nama_kecamatan' => 'required',
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
            'kode_kota' => 'required|numeric',
            'nama_kecamatan' => 'required'
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
        $show = DB::table('kop_kecamatan')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kode_kecamatan', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_kecamatan', 'LIKE', '%' . $search . '%');
        }

        $show = $show->get();

        return $show;
    }
}
