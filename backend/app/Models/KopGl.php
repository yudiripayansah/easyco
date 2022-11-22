<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopGl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_gl';
    protected $fillable = ['kode_gl', 'group_gl', 'tipe_gl', 'default_saldo', 'flag_akses', 'nama_gl', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_gl' => 'required|numeric|unique:kop_gl',
            'group_gl' => 'required|numeric',
            'tipe_gl' => 'required|numeric',
            'default_saldo' => 'required',
            'nama_gl' => 'required',
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
            'group_gl' => 'required|numeric',
            'tipe_gl' => 'required|numeric',
            'default_saldo' => 'required',
            'nama_gl' => 'required'
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
        $show = DB::table('kop_gl')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kode_gl', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_gl', 'LIKE', '%' . $search . '%');
        }

        $show = $show->get();

        return $show;
    }
}
