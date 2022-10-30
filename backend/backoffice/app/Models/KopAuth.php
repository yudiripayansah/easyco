<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopAuth extends Model
{
    use SoftDeletes;

    protected $table = 'kop_user';
    protected $fillable = ['kode_cabang', 'kode_pgw', 'nama_user', 'password', 'created_by'];

    public function validateLogin($validate)
    {
        $rule = [
            'nama_user' => 'required',
            'password' => 'required'
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
