<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopLembaga extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_lembaga';
    protected $fillable = ['kode_kop', 'nama_kop', 'alamat_kop', 'nik_kop', 'simpok', 'simwa', 'gl_simpok', 'gl_simwa', 'gl_simsuk', 'tagline_kop', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_kop' => 'required|numeric',
            'nama_kop' => 'required',
            'alamat_kop' => 'required',
            'nik_kop' => 'required',
            'simpok' => 'required|numeric',
            'simwa' => 'required|numeric',
            'gl_simpok' => 'required|numeric',
            'gl_simwa' => 'required|numeric',
            'gl_simsuk' => 'required|numeric',
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
            'nama_kop' => 'required',
            'alamat_kop' => 'required',
            'nik_kop' => 'required',
            'simpok' => 'required|numeric',
            'simwa' => 'required|numeric',
            'gl_simpok' => 'required|numeric',
            'gl_simwa' => 'required|numeric',
            'gl_simsuk' => 'required|numeric'
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
