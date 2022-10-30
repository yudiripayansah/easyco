<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopUser extends Model
{
    use SoftDeletes;

    protected $table = 'kop_user';
    protected $fillable = ['kode_cabang', 'kode_pgw', 'nama_user', 'role_user', 'akses_user', 'status_user', 'photo', 'password', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_cabang' => 'required|numeric',
            'kode_pgw' => 'required|numeric',
            'nama_user' => 'required|unique:kop_user',
            'role_user' => 'required|numeric',
            'akses_user' => 'required|numeric',
            'password' => 'required',
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
            'kode_pgw' => 'required|numeric',
            'role_user' => 'required|numeric',
            'akses_user' => 'required|numeric',
            'status_user' => 'numeric'
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
