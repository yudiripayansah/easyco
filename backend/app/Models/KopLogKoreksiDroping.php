<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KopLogKoreksiDroping extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_log_koreksi_droping';
    protected $fillable = ['no_rekening', 'pokok_lama', 'pokok_baru', 'margin_lama', 'margin_baru', 'periode_jangka_waktu_lama', 'periode_jangka_waktu_baru', 'jangka_waktu_lama', 'jangka_waktu_baru', 'angsuran_pokok_lama', 'angsuran_pokok_baru', 'angsuran_margin_lama', 'angsuran_margin_baru', 'angsuran_catab_lama', 'angsuran_catab_baru', 'biaya_administrasi_lama', 'biaya_administrasi_baru', 'biaya_asuransi_jiwa_lama', 'biaya_asuransi_jiwa_baru', 'tabungan_persen_lama', 'tabungan_persen_baru', 'dana_kebajikan_lama', 'dana_kebajikan_baru', 'tanggal_akad_lama', 'tanggal_akad_baru', 'tanggal_mulai_angsur_lama', 'tanggal_mulai_angsur_baru', 'tanggal_jtempo_lama', 'tanggal_jtempo_baru', 'created_by', 'created_at'];

    function validateAdd($validate)
    {
        $rule = [
            'no_rekening' => 'required',
            'pokok_baru' => 'numeric',
            'margin_lama' => 'numeric',
            'margin_baru' => 'numeric',
            'periode_jangka_waktu_lama' => 'numeric',
            'periode_jangka_waktu_baru' => 'numeric',
            'jangka_waktu_lama' => 'required|numeric',
            'jangka_waktu_baru' => 'required|numeric',
            'angsuran_pokok_lama' => 'numeric',
            'angsuran_pokok_baru' => 'numeric',
            'angsuran_margin_lama' => 'numeric',
            'angsuran_margin_baru' => 'numeric',
            'angsuran_catab_lama' => 'numeric',
            'angsuran_catab_baru' => 'numeric',
            'biaya_administrasi_lama' => 'numeric',
            'biaya_administrasi_baru' => 'numeric',
            'biaya_asuransi_jiwa_lama' => 'numeric',
            'biaya_asuransi_jiwa_baru' => 'numeric',
            'tabungan_persen_lama' => 'numeric',
            'tabungan_persen_baru' => 'numeric',
            'dana_kebajikan_lama' => 'numeric',
            'dana_kebajikan_baru' => 'numeric',
            'tanggal_akad_lama' => 'required',
            'tanggal_akad_baru' => 'required',
            'tanggal_mulai_angsur_lama' => 'required',
            'tanggal_mulai_angsur_lama' => 'required',
            'tanggal_jtempo_lama' => 'required',
            'tanggal_jtempo_baru' => 'required',
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
}
