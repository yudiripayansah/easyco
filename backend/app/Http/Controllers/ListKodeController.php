<?php

namespace App\Http\Controllers;

use App\Models\KopListKode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListKodeController extends Controller
{
    function create(Request $request)
    {
        $data = $request->all();

        $data['nama_kode'] = strtolower($request->nama_kode);

        $validate = KopListKode::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopListKode::create($data);
                $find = KopListKode::find($create->id);

                $res = array(
                    'status' => TRUE,
                    'data' => $find,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => $e->getMessage()
                );
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

    public function read(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'nama_kode';
        $nama_kode = '';
        $search = NULL;
        $total = 0;
        $totalPage = 1;

        if ($request->page) {
            $page = $request->page;
        }

        if ($request->perPage) {
            $perPage = $request->perPage;
        }

        if ($request->sortDir) {
            $sortDir = $request->sortDir;
        }

        if ($request->sortBy) {
            $sortBy = $request->sortBy;
        }

        if ($request->nama_kode) {
            $nama_kode = $request->nama_kode;
        }

        if ($request->search) {
            $search = $request->search;
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopListKode::read($search, $sortBy, $sortDir, $offset, $perPage, $nama_kode);

        $data = array();

        foreach ($read as $rd) {
            $data[] = array(
                'id' => $rd->id,
                'kode_value' => $rd->kode_value,
                'nama_kode' => $rd->nama_kode,
                'kode_display' => $rd->kode_display
            );
        }

        $total = $read->count();

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'page' => $page,
            'perPage' => $perPage,
            'sortDir' => $sortDir,
            'sortBy' => $sortBy,
            'search' => $search,
            'total' => $total,
            'totalPage' => $totalPage,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $get = KopListKode::find($id);

            if ($get) {
                $res = array(
                    'status' => TRUE,
                    'data' => $get,
                    'msg' => 'Berhasil!'
                );
            } else {
                $res = array(
                    'status' => FALSE,
                    'msg' => 'Maaf! Data tidak ditemukan'
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'msg' => 'Maaf! List Kode tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopListKode::find($request->id);
        $validate = KopListKode::validateUpdate($request->all());

        $get->kode_value = $request->kode_value;
        $get->nama_kode = strtolower($request->nama_kode);
        $get->kode_display = $request->kode_display;

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $get->save();

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => $e->getMessage()
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $data = KopListKode::find($id);

            DB::beginTransaction();

            try {
                $data->delete();

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => $e->getMessage()
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'msg' => 'Maaf! List Kode tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function get_report_setup(Request $request)
    {
        $kode = $request->kode;

        $param = array('nama_kode' => 'report_code');

        $get = KopListKode::where($param)->orderBy('kode_value', 'ASC')->get();

        if ($get->count() > 0) {
            $data = array();

            if ($kode == 0) {
                foreach ($get as $gt) {
                    if ($gt->kode_value == 10 or $gt->kode_value == 11) {
                        $url_pdf = 'https://easycop.kopikoding.com/report/print_balance_sheet_pdf/';
                        $url_xls = 'https://easycop.kopikoding.com/report/print_balance_sheet_xls/';
                    } elseif ($gt->kode_value == 20 or $gt->kode_value == 21) {
                        $url_pdf = 'https://easycop.kopikoding.com/report/print_profit_loss_pdf/';
                        $url_xls = 'https://easycop.kopikoding.com/report/print_profit_loss_xls/';
                    }

                    $data[] = array(
                        'kode_value' => $gt->kode_value,
                        'kode_display' => $gt->kode_display,
                        'url_pdf' => $url_pdf,
                        'url_xls' => $url_xls
                    );
                }

                $data[] = array(
                    'kode_value' => 30,
                    'kode_display' => 'Trial Balance',
                    'url_pdf' => 'https://easycop.kopikoding.com/report/print_trial_balance_pdf/',
                    'url_xls' => 'https://easycop.kopikoding.com/report/print_trial_balance_xls/'
                );
            } else {
                foreach ($get as $gt) {
                    if ($gt->kode_value == 10 or $gt->kode_value == 11) {
                        $url_pdf = 'https://easycop.kopikoding.com/report/print_balance_sheet_current_pdf/';
                        $url_xls = 'https://easycop.kopikoding.com/report/print_balance_sheet_current_xls/';
                    } elseif ($gt->kode_value == 20 or $gt->kode_value == 21) {
                        $url_pdf = 'https://easycop.kopikoding.com/report/print_profit_loss_current_pdf/';
                        $url_xls = 'https://easycop.kopikoding.com/report/print_profit_loss_current_xls/';
                    }

                    $data[] = array(
                        'kode_value' => $gt->kode_value,
                        'kode_display' => $gt->kode_display,
                        'url_pdf' => $url_pdf,
                        'url_xls' => $url_xls
                    );
                }

                $data[] = array(
                    'kode_value' => 30,
                    'kode_display' => 'Trial Balance',
                    'url_pdf' => 'https://easycop.kopikoding.com/report/print_trial_balance_current_pdf/',
                    'url_xls' => 'https://easycop.kopikoding.com/report/print_trial_balance_current_xls/'
                );
            }

            $res = array(
                'status' => true,
                'data' => $data,
                'msg' => null
            );
        } else {
            $res = array(
                'status' => false,
                'data' => null,
                'msg' => 'Data tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function get_rekap_by(Request $request)
    {
        $get = KopListKode::where('nama_kode', 'rekap_by')
            ->orderBy('kode_value', 'ASC')
            ->get();

        $data = array();

        foreach ($get as $gt) {
            $data[] = array(
                'kode_value' => $gt->kode_value,
                'nama_kode' => $gt->nama_kode,
                'kode_display' => $gt->kode_display
            );
        }

        $res = array(
            'status' => true,
            'data' => $data,
            'msg' => null
        );

        $response = response()->json($res, 200);

        return $response;
    }
}
