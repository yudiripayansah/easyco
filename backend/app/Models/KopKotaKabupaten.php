<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopKotaKabupaten extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_kota_kabupaten';
    protected $fillable = ['kode_kota', 'nama_kota', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_kota' => 'required|numeric|unique:kop_kota_kabupaten',
            'nama_kota' => 'required',
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
            'nama_kota' => 'required'
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
        $show = KopKotaKabupaten::orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kode_kota', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_kota', 'LIKE', '%' . $search . '%');
        }

        $show = $show->get();

        return $show;
    }
}
