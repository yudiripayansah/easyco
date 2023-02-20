<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopKatgoriPar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_katgori_par';
    protected $fillable = ['jumlah_hari_1', 'jumlah_hari_2', 'kategori_par', 'cpp', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'jumlah_hari_1' => 'required|numeric',
            'jumlah_hari_2' => 'required|numeric',
            'kategori_par' => 'required',
            'cpp' => 'numeric',
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
            'jumlah_hari_1' => 'required|numeric',
            'jumlah_hari_2' => 'required|numeric',
            'kategori_par' => 'required',
            'cpp' => 'numeric'
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
        $show = KopKatgoriPar::orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kategori_par', 'LIKE', '%' . $search . '%');
        }

        $show = $show->get();

        return $show;
    }
}
