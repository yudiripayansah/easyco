<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Support\Facades\Validator;

class KopCabang extends Model
{
    use softDeletes;

    protected $table = 'kop_cabang';
    protected $fillable = ['kode_cabang', 'nama_cabang', 'induk_cabang', 'jenis_cabang', 'pimpinan_cabang', 'created_by'];

    public static function validate($validate)
    {
        if (isset($validate['id'])) {
            $rule = [
                'kode_cabang' => 'required|numeric|unique:kode_cabang,' . $validate['id'],
                'nama_cabang' => 'required',
                'jenis_cabang' => 'numeric',
                'created_by' => 'required'
            ];
        } else {
            $rule = [
                'kode_cabang' => 'required|numeric|unique:kode_cabang',
                'nama_cabang' => 'required',
                'jenis_cabang' => 'numeric',
                'created_by' => 'required'
            ];
        }

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
