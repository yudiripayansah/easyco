<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KopPrdDeposito extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_prd_deposito';
    protected $fillable = ['kode_produk', 'kode_gl', 'nama_produk', 'nama_singkat', 'periode_setoran', 'jangka_waktu', 'minimal_setoran', 'nisbah', 'persen_pajak', 'created_by'];

    public function validateAdd($validate)
    {
        $rule = [
            'kode_produk' => 'required|numeric',
            'kode_gl' => 'required|numeric',
            'nama_produk' => 'required',
            'nama_singkat' => 'required',
            'periode_setoran' => 'numeric',
            'jangka_waktu' => 'required|numeric',
            'minimal_setoran' => 'numeric',
            'nisbah' => 'numeric',
            'persen_pajak' => 'numeric',
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
            'kode_gl' => 'required|numeric',
            'nama_produk' => 'required',
            'nama_singkat' => 'required',
            'periode_setoran' => 'numeric',
            'jangka_waktu' => 'required|numeric',
            'minimal_setoran' => 'numeric',
            'nisbah' => 'numeric',
            'persen_pajak' => 'numeric'
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
        $show = DB::table('kop_prd_deposito')->orderBy($sortBy, $sortDir);

        if ($perPage != '~') {
            $show->skip($offset)->take($perPage);
        }

        if ($search <> NULL) {
            $show->where('kode_produk', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_produk', 'LIKE', '%' . $search . '%')
                ->orWhere('nama_singkat', 'LIKE', '%' . $search . '%');
        }

        $show = $show->get();

        return $show;
    }
}
