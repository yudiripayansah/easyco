<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KopAnggota;
use App\Models\KopKartuAngsuran;
use App\Models\KopKasPetugas;
use App\Models\KopLembaga;
use App\Models\KopPelunasan;
use App\Models\KopPembiayaan;
use App\Models\KopTabungan;
use App\Models\KopTrxAnggota;
use App\Models\KopTrxKasPetugas;
use App\Models\KopTrxRembug;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxRembug extends Controller
{
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    function read(Request $request)
    {
        $kode_cabang = $request->branch_code;
        $kode_petugas = $request->fa_code;

        if ($request->from_date) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($request->thru_date) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $data = array();

        $show = KopTrxRembug::get_all_transaction($kode_cabang, $kode_petugas, '', $from_date, $thru_date, 1);

        $grand_total_penerimaan = 0;
        $grand_total_penarikan = 0;

        foreach ($show as $sh) {
            $kas_awal = KopTrxAnggota::total_droping($sh['id_trx_rembug']);
            $penerimaan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'C');
            $penarikan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'D');

            $grand_total_penerimaan += $penerimaan['amount'];
            $grand_total_penarikan += $penarikan['amount'];

            $data[] = array(
                'id_trx_rembug' => $sh['id_trx_rembug'],
                'nama_rembug' => $sh['nama_rembug'],
                'nama_cabang' => $sh['nama_cabang'],
                'trx_date' => $sh['trx_date'],
                'nama_kas_petugas' => $sh['nama_kas_petugas'],
                'kas_awal' => $kas_awal['kas_awal'],
                'infaq' => $sh['infaq'],
                'total_penerimaan' => $penerimaan['amount'],
                'total_penarikan' => $penarikan['amount']
            );
        }

        $grand = array(
            'total_penerimaan' => $grand_total_penerimaan,
            'total_penarikan' => $grand_total_penarikan
        );

        $res = array(
            'status' => true,
            'data' => $data,
            'grand_total' => $grand
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function verifikasi(Request $request)
    {
        $id_trx_rembug = $request->id_trx_rembug;

        $data = KopTrxRembug::get_rembug_verification($id_trx_rembug);
        $penerimaan = KopTrxRembug::total_cashflow_verification($id_trx_rembug, 'C');
        $penarikan = KopTrxRembug::total_cashflow_verification($id_trx_rembug, 'D');
        $detail = KopTrxRembug::get_detail($id_trx_rembug);

        $data['penerimaan'] = (int)$penerimaan['amount'];
        $data['penarikan'] = (int)$penarikan['amount'];

        $res = array(
            'status' => true,
            'data' => $data,
            'detail' => $detail
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function proses_verifikasi(Request $request)
    {
        $id_trx_rembug = $request->id_trx_rembug;

        $param = array('id_trx_rembug' => $id_trx_rembug);

        $show = KopTrxAnggota::where($param)->get();
        $trx_rembug = KopTrxRembug::where($param)->first();

        $param_petugas = array('kode_petugas' => $trx_rembug['kode_petugas']);
        $kas_petugas = KopKasPetugas::where($param_petugas)->first();

        foreach ($show as $sh) {
            $id = $sh['id'];
            $no_anggota = $sh['no_anggota'];
            $no_rekening = $sh['no_rekening'];
            $trx_date = $sh['trx_date'];
            $amount = $sh['amount'];
            $trx_type = $sh['trx_type'];

            $param_anggota = array('no_anggota' => $no_anggota);
            $anggota = KopAnggota::where($param_anggota)->first();

            $param_tabungan = array('no_rekening' => $no_rekening);
            $tabungan = KopTabungan::where($param_tabungan)->first();

            $param_pembiayaan = array('no_rekening' => $no_rekening);
            $pembiayaan = KopPembiayaan::where($param_pembiayaan)->first();

            // ANGGOTA KELUAR
            if ($anggota['status'] == 3) {
                $get = KopAnggota::find($anggota['id']);
                $get->status = 2;
                $get->save();
            }

            // SETORAN SIMPOK
            if ($trx_type == 11) {
                if ($amount > 0) {
                    $get = KopAnggota::find($anggota['id']);
                    $simpok = $anggota['simpok'] + $amount;
                    $get->simpok = $simpok;
                    $get->save();
                }
            }

            // SETORAN SIMWA
            if ($trx_type == 12) {
                if ($amount > 0) {
                    $get = KopAnggota::find($anggota['id']);
                    $simwa = $anggota['simwa'] + $amount;
                    $get->simwa = $simwa;
                    $get->save();
                }
            }

            // SETORAN SUKARELA
            if ($trx_type == 13) {
                if ($amount > 0) {
                    $get = KopAnggota::find($anggota['id']);
                    $simsuk = $anggota['simsuk'] + $amount;
                    $get->simsuk = $simsuk;
                    $get->save();
                }
            }

            // SETORAN TABER
            if ($trx_type == 21) {
                if ($amount > 0) {
                    $get = KopTabungan::find($tabungan['id']);
                    $saldo = $tabungan['saldo'] + $amount;
                    $get->saldo = $saldo;
                    $get->save();
                }
            }

            // PENARIKAN SUKARELA
            if ($trx_type == 22) {
                if ($amount > 0) {
                    $get = KopAnggota::find($anggota['id']);
                    $simsuk = $anggota['simsuk'] - $amount;
                    $get->simsuk = $simsuk;
                    $get->save();
                }
            }

            // PENCAIRAN PEMBIAYAAN
            if ($trx_type == 31) {
                if ($amount > 0) {
                    $get = KopPembiayaan::find($pembiayaan['id']);
                    $get->status_rekening = 1;
                    $get->save();
                }
            }

            // SETORAN ANGSURAN POKOK
            if ($trx_type == 32) {
                if ($amount > 0) {
                    $freq = round($amount / $pembiayaan['angsuran_pokok']);
                    $get = KopPembiayaan::find($pembiayaan['id']);
                    $get->jtempo_angsuran_last = $pembiayaan['jtempo_angsuran_next'];
                    $get->counter_angsuran = $pembiayaan['counter_angsuran'] + $freq;
                    $get->saldo_pokok = $pembiayaan['saldo_pokok'] - $amount;
                    $get->jtempo_angsuran_next = date('Y-m-d', strtotime($pembiayaan['jtempo_angsuran_next'] . ' + ' . $freq . ' WEEKS'));

                    $get->save();

                    $param_angsuran1 = array('no_rekening' => $no_rekening);
                    $counter1 = $pembiayaan['counter_angsuran'] + 1;
                    $counter2 = $pembiayaan['counter_angsuran'] + $freq;

                    $angsuran = KopKartuAngsuran::where($param_angsuran1)->whereBetween('angsuran_ke', [$counter1, $counter2])->get();

                    foreach ($angsuran as $angs) {
                        $get2 = KopKartuAngsuran::find($angs['id']);
                        $get2->flag_bayar = 1;
                        $get2->tgl_bayar = $trx_date;
                        $get2->save();
                    }

                    // PELUNASAN
                    if (($pembiayaan['counter_angsuran'] + $freq) >= $pembiayaan['jangka_waktu']) {
                        // INSERT kop_pelunasan
                        $data = array(
                            'id_trx_rembug' => $id_trx_rembug,
                            'no_rekening' => $no_rekening,
                            'saldo_pokok' => $pembiayaan['saldo_pokok'],
                            'saldo_margin' => $pembiayaan['saldo_margin'],
                            'saldo_catab' => $pembiayaan['saldo_catab'],
                            'saldo_minggon' => $pembiayaan['saldo_margin'],
                            'potongan_margin' => 0,
                            'flag_catab' => 1,
                            'status_pelunasan' => 1,
                            'tanggal_pelunasan' => $trx_date,
                            'jenis_pembayaran' => 0,
                            'kode_kas_petugas' => $kas_petugas['kode_kas_petugas'],
                            'created_by' => $trx_rembug['created_by']
                        );

                        KopPelunasan::create($data);

                        // UPDATE DATA MASTER
                        $get3 = KopPembiayaan::find($pembiayaan['id']);
                        $get3->status_rekening = 2;
                        $get3->saldo_pokok = 0;

                        $get3->save();
                    }
                }
            }

            // SETORAN ANGSURAN MARGIN
            if ($trx_type == 33) {
                if ($amount > 0) {
                    $get = KopPembiayaan::find($pembiayaan['id']);
                    $get->saldo_margin = $pembiayaan['saldo_margin'] - $amount;
                    $get->save();

                    // PELUNASAN
                    if (($pembiayaan['counter_angsuran'] + $freq) >= $pembiayaan['jangka_waktu']) {
                        // UPDATE DATA MASTER
                        $get2 = KopPembiayaan::find($pembiayaan['id']);
                        $get2->saldo_margin = 0;

                        $get2->save();
                    }
                }
            }

            // SETORAN ANGSURAN CATAB
            if ($trx_type == 34) {
                if ($amount > 0) {
                    $get = KopPembiayaan::find($pembiayaan['id']);
                    $get->saldo_catab = $pembiayaan['angsuran_catab'] + $amount;
                    $get->save();

                    $get = KopAnggota::find($anggota['id']);
                    $simwa = $anggota['simwa'] + $amount;
                    $get->simwa = $simwa;
                    $get->save();
                }
            }

            $upd = KopTrxAnggota::find($id);
            $upd->verified_by = $trx_rembug['kode_petugas'];
            $upd->verified_at = date('Y-m-d H:i:s');
            $upd->save();
        }

        try {
            $update = KopTrxRembug::find($trx_rembug['id']);
            $update->verified_by = $trx_rembug['kode_petugas'];
            $update->verified_at = date('Y-m-d H:i:s');
            $update->save();

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
                'data' => $show,
                'msg' => $e->getMessage()
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function reject(Request $request)
    {
        $id = $request->id_trx_rembug;

        if ($id) {
            $trx_rembug = KopTrxRembug::where('id_trx_rembug', $id);
            $trx_anggota = KopTrxAnggota::where('id_trx_rembug', $id);

            DB::beginTransaction();

            try {
                $trx_anggota->delete();
                $trx_rembug->delete();

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
                'msg' => 'Gagal!'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function transaksi_majelis(Request $request)
    {
        $kode_cabang = $request->branch_code;
        $kode_petugas = $request->fa_code;
        $kode_rembug = $request->cm_code;

        if ($request->from_date) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($request->thru_date) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $data = array();

        $show = KopTrxRembug::get_all_transaction($kode_cabang, $kode_petugas, $kode_rembug, $from_date, $thru_date, 0);

        foreach ($show as $sh) {
            $penerimaan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'C');
            $penarikan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'D');

            if ($sh['verified_by'] <> null) {
                $status = 'Ya';
            } else {
                $status = 'Tidak';
            }

            $data[] = array(
                'trx_date' => $sh['trx_date'],
                'nama_rembug' => $sh['nama_rembug'],
                'nama_petugas' => $sh['nama_pgw'],
                'total_penerimaan' => $penerimaan['amount'] + $sh['infaq'],
                'total_penarikan' => $penarikan['amount'],
                'status_verifikasi' => $status
            );
        }

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function read_trx_kas_petugas(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'kop_trx_kas_petugas.voucher_date';
        $search = NULL;
        $total = 0;
        $totalPage = 1;
        $status = '~';
        $kode_kas_petugas = '';
        $from = NULL;
        $to = NULL;

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

        if ($request->search) {
            $search = strtoupper($request->search);
        }

        if ($request->kode_kas_petugas) {
            $kode_kas_petugas = $request->kode_kas_petugas;
        }

        if ($request->status) {
            $status = $request->status;
        }

        if ($request->from) {
            $from = str_replace('/', '-', $request->from);
            $from = date('Y-m-d', strtotime($from));
        }

        if ($request->to) {
            $to = str_replace('/', '-', $request->to);
            $to = date('Y-m-d', strtotime($to));
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopTrxKasPetugas::select('kop_trx_kas_petugas.*', 'a.nama_kas_petugas', 'b.nama_kas_petugas', DB::raw("fn_get_saldoawal_kaspetugas('" . $kode_kas_petugas . "','" . $from . "') AS saldo_awal"))
            ->join('kop_kas_petugas AS a', 'a.kode_kas_petugas', 'kop_trx_kas_petugas.kode_kas_petugas')
            ->join('kop_kas_petugas AS b', 'b.kode_kas_petugas', 'kop_trx_kas_petugas.kode_kas_teller')
            ->orderBy('kop_trx_kas_petugas.trx_date')
            ->orderBy('kop_trx_kas_petugas.jenis_trx')
            ->orderBy('kop_trx_kas_petugas.created_at');

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($status && $status != '~') {
            $read->where('kop_trx_kas_petugas.status_trx', $status);
        }

        if ($kode_kas_petugas != '') {
            $read->where('kop_trx_kas_petugas.kode_kas_petugas', $kode_kas_petugas);
        }

        if ($search) {
            $read->where('a.nama_kas_petugas', 'LIKE', '%' . $search . '%')
                ->orWhere('b.nama_kas_petugas', 'LIKE', '%' . $search . '%');
        }

        if ($from && $to) {
            $read->whereBetween('kop_trx_kas_petugas.voucher_date', [$from, $to]);
        }

        $read = $read->get();

        foreach ($read as $baca) {
            $saldo = $baca->saldo_awal;
        }

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;

            if ($rd->debit_credit == 'D') {
                $saldo += $rd->jumlah_trx;
            } else {
                $saldo -= $rd->jumlah_trx;
            }

            $rd->saldo = $saldo;
        }

        if ($search || $kode_kas_petugas || $status || ($from && $to)) {
            $total = KopTrxKasPetugas::orderBy($sortBy, $sortDir)
                ->join('kop_kas_petugas AS a', 'a.kode_kas_petugas', 'kop_trx_kas_petugas.kode_kas_petugas')
                ->join('kop_kas_petugas AS b', 'b.kode_kas_petugas', 'kop_trx_kas_petugas.kode_kas_teller');

            if ($search) {
                $total->where('a.nama_kas_petugas', 'LIKE', '%' . $search . '%')
                    ->orWhere('b.nama_kas_petugas', 'LIKE', '%' . $search . '%');
            }

            if ($status && $status != '~') {
                $total->where('kop_trx_kas_petugas.status_trx', $status);
            }

            if ($kode_kas_petugas != '') {
                $total->where('kop_trx_kas_petugas.kode_kas_petugas', $kode_kas_petugas);
            }

            if ($from && $to) {
                $total->whereBetween('kop_trx_kas_petugas.voucher_date', [$from, $to]);
            }

            $total = $total->count();
        } else {
            $total = KopTrxKasPetugas::all()->count();
        }

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        $res = array(
            'status' => TRUE,
            'data' => $read,
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

    public function proses_kas_petugas(Request $request)
    {
        $data = $request->all();

        if ($data['jenis_trx'] == 1) {
            $data['debit_credit'] = 'D';
        } else {
            $data['debit_credit'] = 'C';
        }

        $data['trx_date'] = date('Y-m-d');
        $data['created_at'] = date('Y-m-d H:i:s');

        $validate = KopTrxKasPetugas::validateAdd($data);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopTrxKasPetugas::create($data);
                $find = KopTrxKasPetugas::find($create->id);

                $res = array(
                    'status' => TRUE,
                    'data' => $find,
                    'msg' => 'Berhasil!',
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
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function check_unverified()
    {
        $getLembaga = KopLembaga::first();
        $get = KopTrxRembug::check_unverified($getLembaga->periode_awal, $getLembaga->periode_akhir);

        $data = array(
            'periode_akhir' => $getLembaga->periode_akhir,
            'jumlah' => $get->jumlah
        );

        if ($get->jumlah > 0) {
            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => 'Masih ada ' . $get->jumlah . ' Transaksi Majelis yang belum diverifikasi',
                'error' => NULL
            );
        } else {
            $res = array(
                'status' => TRUE,
                'data' => $data,
                'msg' => NULL,
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
