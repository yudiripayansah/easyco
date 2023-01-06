<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KopAnggota;
use App\Models\KopAnggotaUser;
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
        $data = $request->all();

        $param = array('nama_user' => $data['nama_user']);

        $validate = KopAnggotaUser::validateUser($data);

        if ($validate['status'] === TRUE) {
            $get = KopAnggotaUser::where($param)->first();

            if ($get) {
                $data = array('nama_user' => $data['nama_user']);

                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => 'Silakkan masukkan Password Anda',
                    'error' => NULL
                );
            } else {
                $param2 = array('no_anggota' => $data['nama_user']);

                $check = KopAnggota::where($param2)->first();

                if ($check) {
                    $insert = array(
                        'kode_cabang' => $check->kode_cabang,
                        'nama_user' => $data['nama_user'],
                        'password' => Hash::make($data['nama_user']),
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
                            'data' => $data,
                            'msg' => 'Silakkan masukkan Password Anda',
                            'error' => NULL
                        );

                        DB::commit();
                    } catch (Exception $e) {
                        DB::rollBack();

                        $res = array(
                            'status' => FALSE,
                            'data' => $data,
                            'msg' => $e->getMessage(),
                            'error' => NULL
                        );
                    }
                } else {
                    $res = array(
                        'status' => FALSE,
                        'data' => $data,
                        'msg' => 'No. Anggota tidak ditemukan',
                        'error' => NULL
                    );
                }
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function check_password(Request $request)
    {
        $data = $request->all();

        $last_login = date('Y-m-d H:i:s');

        $validate = KopAnggotaUser::validatePassword($data);

        if ($validate['status'] === TRUE) {
            try {
                $param = array('nama_user' => $data['nama_user']);

                $get = KopAnggotaUser::where($param)->first();

                $find = KopAnggotaUser::find($get->id);

                if ($get->status_password == 1) {
                    $credentials = $request->only('nama_user', 'password');
                    $token = JWTAuth::attempt($credentials);

                    if ($token) {
                        $check = Hash::check($data['password'], $get->password);

                        if ($check) {
                            $find->last_login = $last_login;
                            $find->token = $token;

                            $find->save();

                            $res = array(
                                'status' => TRUE,
                                'data' => $data,
                                'msg' => 'Login Berhasil! Anda akan dialihkan ke halaman Dashboard!',
                                'token' => $token,
                                'error' => NULL
                            );
                        } else {
                            $res = array(
                                'status' => FALSE,
                                'data' => $data,
                                'msg' => 'Maaf! Password masih salah',
                                'error' => $validate['errors'],
                                'token' => $token
                            );
                        }
                    } else {
                        $res = array(
                            'status' => FALSE,
                            'data' => $data,
                            'msg' => 'Maaf! Login tidak berhasil',
                            'error' => NULL,
                            'token' => $token
                        );
                    }
                } else {
                    $creds = array(
                        'nama_user' => $data['nama_user'],
                        'password' => $data['nama_user']
                    );

                    $token = JWTAuth::attempt($creds);

                    $find->password = Hash::make($data['password']);
                    $find->last_login = $last_login;
                    $find->status_password = 1;
                    $find->token = $token;

                    $find->save();

                    $res = array(
                        'status' => TRUE,
                        'data' => $data,
                        'msg' => 'Login Berhasil! Anda akan dialihkan ke halaman Dashboard!',
                        'token' => $token,
                        'error' => NULL
                    );
                }
            } catch (JWTException $e) {
                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => $e->getMessage(),
                    'error' => $validate['errors'],
                    'token' => $token
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => $validate['msg'],
                'error' => $validate['errors'],
                'token' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
