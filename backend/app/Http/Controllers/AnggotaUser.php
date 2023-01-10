<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KopAnggota;
use App\Models\KopAnggotaUser;
use App\Models\KopKartuAngsuran;
use App\Models\KopPembiayaan;
use App\Models\KopTrxAnggota;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AnggotaUser extends Controller
{
    function check_username(Request $request)
    {
        $all = $request->all();

        $param = array('nama_user' => $all['nama_user']);

        $validate = KopAnggotaUser::validateUser($all);

        if ($validate['status'] === TRUE) {
            $get = KopAnggotaUser::where($param)->first();

            if ($get) {
                $data = array('nama_user' => $all['nama_user']);

                $res = array(
                    'status' => TRUE,
                    'data' => $data,
                    'msg' => 'Silakkan masukkan Password Anda',
                    'error' => NULL
                );
            } else {
                $param2 = array('no_anggota' => $all['nama_user']);

                $check = KopAnggota::where($param2)->first();

                if ($check) {
                    $insert = array(
                        'kode_cabang' => $check->kode_cabang,
                        'nama_user' => $all['nama_user'],
                        'password' => Hash::make($all['nama_user']),
                        'role_user' => 0,
                        'akses_user' => 1,
                        'status_password' => 0,
                        'created_by' => 'SYS'
                    );

                    DB::beginTransaction();

                    try {
                        KopAnggotaUser::create($insert);

                        $res = array(
                            'status' => TRUE,
                            'data' => $all,
                            'msg' => 'Silakkan masukkan Password Anda',
                            'error' => NULL
                        );

                        DB::commit();
                    } catch (Exception $e) {
                        DB::rollBack();

                        $res = array(
                            'status' => FALSE,
                            'data' => $all,
                            'msg' => $e->getMessage(),
                            'error' => NULL
                        );
                    }
                } else {
                    $res = array(
                        'status' => FALSE,
                        'data' => $all,
                        'msg' => 'No. Anggota tidak ditemukan',
                        'error' => NULL
                    );
                }
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $all,
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function check_password(Request $request)
    {
        $all = $request->all();

        $last_login = date('Y-m-d H:i:s');

        $validate = KopAnggotaUser::validatePassword($all);

        if ($validate['status'] === TRUE) {
            try {
                $param = array('nama_user' => $all['nama_user']);

                $get = KopAnggotaUser::where($param)->first();

                $find = KopAnggotaUser::find($get->id);

                if ($get->status_password == 1) {
                    $credentials = $request->only('nama_user', 'password');
                    $token = JWTAuth::attempt($credentials);

                    if ($token) {
                        $check = Hash::check($all['password'], $get->password);

                        if ($check) {
                            $find->last_login = $last_login;
                            $find->token = $token;

                            $find->save();

                            $res = array(
                                'status' => TRUE,
                                'data' => $all,
                                'msg' => 'Login Berhasil! Anda akan dialihkan ke halaman Dashboard!',
                                'token' => $token,
                                'error' => NULL
                            );
                        } else {
                            $res = array(
                                'status' => FALSE,
                                'data' => $all,
                                'msg' => 'Maaf! Password masih salah',
                                'error' => $validate['errors'],
                                'token' => $token
                            );
                        }
                    } else {
                        $res = array(
                            'status' => FALSE,
                            'data' => $all,
                            'msg' => 'Maaf! Login tidak berhasil',
                            'error' => NULL,
                            'token' => $token
                        );
                    }
                } else {
                    $creds = array(
                        'nama_user' => $all['nama_user'],
                        'password' => $all['nama_user']
                    );

                    $token = JWTAuth::attempt($creds);

                    $find->password = Hash::make($all['password']);
                    $find->last_login = $last_login;
                    $find->status_password = 1;
                    $find->token = $token;

                    $find->save();

                    $res = array(
                        'status' => TRUE,
                        'data' => $all,
                        'msg' => 'Login Berhasil! Anda akan dialihkan ke halaman Dashboard!',
                        'token' => $token,
                        'error' => NULL
                    );
                }
            } catch (JWTException $e) {
                $res = array(
                    'status' => FALSE,
                    'data' => $all,
                    'msg' => $e->getMessage(),
                    'error' => $validate['errors'],
                    'token' => $token
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $all,
                'msg' => $validate['msg'],
                'error' => $validate['errors'],
                'token' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function dashboard(Request $request)
    {
        $all = $request->all();

        $get = KopAnggota::member_dashboard($all['nama_user']);

        $data = array(
            'no_anggota' => $get->no_anggota,
            'nama_anggota' => $get->nama_anggota,
            'nama_rembug' => $get->nama_rembug,
            'nama_desa' => $get->nama_desa,
            'simpok' => $get->simpok * 1,
            'simwa' => $get->simwa * 1,
            'simsuk' => $get->simsuk * 1,
            'saldo_outstanding' => $get->saldo_outstanding * 1,
            'saldo_tab_berencana' => $get->saldo_tab_berencana * 1
        );

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!',
            'error' => NULL
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function history_saving(Request $request)
    {
        $all = $request->all();

        $no_anggota = $all['no_anggota'];
        $jenis_trx = $all['jenis_trx'];
        $from_date = $all['from_date'];
        $thru_date = $all['thru_date'];

        if ($jenis_trx == 1) { // SIMPANAN POKOK
            $get_credit = KopTrxAnggota::get_credit_member($no_anggota, 11, $from_date);
            $get_debet = KopTrxAnggota::get_debet_member($no_anggota, 11, $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);

            $saldo_awal = $credit - $debet;
            $saldo_akhir = $saldo_awal;

            $get_history = KopTrxAnggota::get_history_member($no_anggota, [11, 11], $from_date, $thru_date);
        } else if ($jenis_trx == 2) { // SIMPANAN WAJIB
            $get_credit = KopTrxAnggota::get_credit_member($no_anggota, 12, $from_date);
            $get_debet = KopTrxAnggota::get_debet_member($no_anggota, 12, $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);

            $saldo_awal = $credit - $debet;
            $saldo_akhir = $saldo_awal;

            $get_history = KopTrxAnggota::get_history_member($no_anggota, [12, 12], $from_date, $thru_date);
        } else if ($jenis_trx == 3) { // SIMPANAN WAJIB
            $get_credit = KopTrxAnggota::get_credit_member($no_anggota, 13, $from_date);
            $get_debet = KopTrxAnggota::get_debet_member($no_anggota, 22, $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);

            $saldo_awal = $credit - $debet;
            $saldo_akhir = $saldo_awal;

            $get_history = KopTrxAnggota::get_history_member($no_anggota, [13, 22], $from_date, $thru_date);
        } else { // SIMPANAN BERENCANA
            $get_credit = KopTrxAnggota::get_credit_member($no_anggota, 21, $from_date);
            $get_debet = KopTrxAnggota::get_debet_member($no_anggota, 21, $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);

            $saldo_awal = $credit - $debet;
            $saldo_akhir = $saldo_awal;

            $get_history = KopTrxAnggota::get_history_member($no_anggota, [21, 21], $from_date, $thru_date);
        }

        $data = array();

        for ($i = 0; $i < count($get_history); $i++) {
            $trx_date = $get_history[$i]->trx_date;
            $amount = $get_history[$i]->amount;
            $flag_debet_credit = $get_history[$i]->flag_debet_credit;
            $description = $get_history[$i]->description;

            if ($flag_debet_credit == 'C') {
                $history_credit = $amount;
                $setor = $history_credit;
                $tarik = 0;
            } else {
                $history_debet = $amount;
                $setor = 0;
                $tarik = $history_debet;
            }

            if ($i == 0) {
                $saldo_awal = $saldo_awal;
            } else {
                $saldo_awal = $saldo_akhir;
            }

            $saldo_akhir += $setor - $tarik;

            $data[] = array(
                'trx_date' => $trx_date,
                'saldo_awal' => $saldo_awal,
                'setor' => $setor * 1,
                'tarik' => $tarik * 1,
                'saldo_akhir' => $saldo_akhir,
                'keterangan' => $description
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!',
            'error' => NULL
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function financing(Request $request)
    {
        $all = $request->all();

        $get_financing = KopPembiayaan::get_financing_member($all['no_anggota']);

        $data = array();

        for ($i = 0; $i < count($get_financing); $i++) {
            $no_rekening = $get_financing[$i]->no_rekening;
            $no_anggota = $get_financing[$i]->no_anggota;
            $nama_produk = $get_financing[$i]->nama_produk;
            $tanggal_akad = $get_financing[$i]->tanggal_akad;
            $pokok = $get_financing[$i]->pokok;
            $margin = $get_financing[$i]->margin;
            $jangka_waktu = $get_financing[$i]->jangka_waktu;
            $status_rekening = $get_financing[$i]->status_rekening;

            if ($status_rekening == 0) {
                $status = 'Pengajuan';
            } else if ($status_rekening == 1) {
                $status = 'Aktif';
            } else if ($status_rekening == 2) {
                $status = 'Lunas';
            } else {
                $status = 'Menunggu Verifikasi Anggota Keluar';
            }

            $data[] = array(
                'nomrek' => $no_rekening,
                'noanggota' => $no_anggota,
                'produk' => $nama_produk,
                'tgl_droping' => $tanggal_akad,
                'pokok' => $pokok,
                'margin' => $margin,
                'jk_waktu' => $jangka_waktu,
                'status' => $status
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!',
            'error' => NULL
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function history_financing(Request $request)
    {
        $all = $request->all();

        $get_history = KopKartuAngsuran::get_history_financing($all['no_rekening']);

        for ($i = 0; $i < count($get_history); $i++) {
            $tgl_angsuran = $get_history[$i]->tgl_angsuran;
            $tgl_bayar = $get_history[$i]->tgl_bayar;
            $angsuran_ke = $get_history[$i]->angsuran_ke;
            $angsuran_pokok = $get_history[$i]->angsuran_pokok;
            $angsuran_margin = $get_history[$i]->angsuran_margin;
            $saldo_pokok = $get_history[$i]->saldo_pokok;
            $saldo_margin = $get_history[$i]->saldo_margin;

            $data[] = array(
                'tgl_angsuran' => $tgl_angsuran,
                'tgl_bayar' => $tgl_bayar,
                'angsuran_ke' => $angsuran_ke,
                'angsuran_pokok' => $angsuran_pokok * 1,
                'angsuran_margin' => $angsuran_margin * 1,
                'saldo_pokok' => $saldo_pokok * 1,
                'saldo_margin' => $saldo_margin * 1
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!',
            'error' => NULL
        );

        $response = response()->json($res, 200);

        return $response;
    }
}
