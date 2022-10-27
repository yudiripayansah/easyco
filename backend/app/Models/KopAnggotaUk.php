<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class KopAnggotaUk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_anggota_uk';
    protected $fillable = ['no_anggota', 'p_nama', 'p_tmplahir', 'p_tglahir', 'usia', 'p_noktp', 'p_nohp', 'p_pendidikan', 'p_pekerjaan', 'p_ketpekerjaan', 'p_pendapatan', 'jml_anak', 'jml_tanggungan', 'rumah_status', 'rumah_ukuran', 'rumah_atap', 'rumah_dinding', 'rumah_lantai', 'rumah_jamban', 'rumah_air', 'lahan_sawah', 'lahan_kebun', 'lahan_pekarangan', 'ternak_sapi', 'ternak_domba', 'ternak_unggas', 'elc_kulkas', 'elc_tv', 'elc_hp', 'kend_sepeda', 'kend_motor', 'ush_rumahtangga', 'ush_komoditi', 'ush_lokasi', 'ush_omset', 'by_beras', 'by_dapur', 'by_listrik', 'by_telpon', 'by_sekolah', 'by_lain'];

    public function validateAdd($validate)
    {
        $rule = [
            'p_tglahir' => 'date',
            'usia' => 'numeric',
            'p_pendidikan' => 'numeric',
            'p_pekerjaan' => 'numeric',
            'p_pendapatan' => 'numeric',
            'jml_anak' => 'numeric',
            'jml_tanggungan' => 'numeric',
            'rumah_status' => 'numeric',
            'rumah_ukuran' => 'numeric',
            'rumah_atap' => 'numeric',
            'rumah_dinding' => 'numeric',
            'rumah_lantai' => 'numeric',
            'rumah_jamban' => 'numeric',
            'rumah_air' => 'numeric',
            'lahan_sawah' => 'numeric',
            'lahan_kebun' => 'numeric',
            'lahan_pekarangan' => 'numeric',
            'ternak_sapi' => 'numeric',
            'ternak_domba' => 'numeric',
            'ternak_unggas' => 'numeric',
            'elc_kulkas' => 'numeric',
            'elc_tv' => 'numeric',
            'elc_hp' => 'numeric',
            'kend_sepeda' => 'numeric',
            'kend_motor' => 'numeric',
            'ush_rumahtangga' => 'numeric',
            'ush_omset' => 'numeric',
            'by_beras' => 'numeric',
            'by_dapur' => 'numeric',
            'by_listrik' => 'numeric',
            'by_telpon' => 'numeric',
            'by_sekolah' => 'numeric',
            'by_lain' => 'numeric'
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
            'p_tglahir' => 'date',
            'usia' => 'numeric',
            'p_pendidikan' => 'numeric',
            'p_pekerjaan' => 'numeric',
            'p_pendapatan' => 'numeric',
            'jml_anak' => 'numeric',
            'jml_tanggungan' => 'numeric',
            'rumah_status' => 'numeric',
            'rumah_ukuran' => 'numeric',
            'rumah_atap' => 'numeric',
            'rumah_dinding' => 'numeric',
            'rumah_lantai' => 'numeric',
            'rumah_jamban' => 'numeric',
            'rumah_air' => 'numeric',
            'lahan_sawah' => 'numeric',
            'lahan_kebun' => 'numeric',
            'lahan_pekarangan' => 'numeric',
            'ternak_sapi' => 'numeric',
            'ternak_domba' => 'numeric',
            'ternak_unggas' => 'numeric',
            'elc_kulkas' => 'numeric',
            'elc_tv' => 'numeric',
            'elc_hp' => 'numeric',
            'kend_sepeda' => 'numeric',
            'kend_motor' => 'numeric',
            'ush_rumahtangga' => 'numeric',
            'ush_omset' => 'numeric',
            'by_beras' => 'numeric',
            'by_dapur' => 'numeric',
            'by_listrik' => 'numeric',
            'by_telpon' => 'numeric',
            'by_sekolah' => 'numeric',
            'by_lain' => 'numeric'
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
