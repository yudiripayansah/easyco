<?php

namespace App\Http\Controllers;

use App\Models\KopAnggota;
use App\Models\KopKartuAngsuran;
use App\Models\KopPembiayaan;
use App\Models\KopRembug;
use App\Models\KopTabungan;
use App\Models\KopTrxAnggota;
use App\Models\KopTrxKasPetugas;
use App\Models\KopTrxRembug;
use App\Models\KopUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TplController extends Controller
{
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    function check_username(Request $request)
    {
        $username = $request->nama_user;

        $param = array('nama_user' => $username);

        $get = KopUser::where($param);

        $count = $get->count();

        $get = $get->first();

        if ($count > 0) {
            if ($get->status_user == 1) {
                $data = array('nama_user' => $get->nama_user);

                $res = array(
                    'status' => TRUE,
                    'data' => $data,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => NULL,
                    'msg' => 'Maaf! Username sudah tidak aktif',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Username tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function rembug(Request $request)
    {
        $kode_petugas = $request->kode_petugas;
        $hari_transaksi = $request->hari_transaksi;

        $read = KopRembug::tpl_rembug($kode_petugas, $hari_transaksi);

        $count = $read->count();

        if ($count > 0) {
            $data = array();

            foreach ($read as $rd) {
                $data[] = array(
                    'kode_rembug' => $rd->kode_rembug,
                    'nama_rembug' => $rd->nama_rembug,
                    'nama_desa' => $rd->nama_desa,
                    'jumlah' => $rd->jumlah
                );
            }

            $res = array(
                'status' => TRUE,
                'data' => $data,
                'msg' => 'Berhasil!',
                'error' => NULL
            );
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Data tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function member(Request $request)
    {
        $kode_rembug = $request->kode_rembug;
        $today = $request->today;

        if ($today == '~') {
            $trx_date = date('Y-m-d');
        } else {
            $trx_date = $today;
        }

        $read = KopAnggota::tpl_member($kode_rembug);

        $count = $read->count();

        if ($count > 0) {
            $data = array();

            foreach ($read as $rd) {
                $penerimaan = KopTrxAnggota::tpl_cashflow_credit($rd->no_anggota, $trx_date)->first();
                $penarikan = KopTrxAnggota::tpl_cashflow_debet($rd->no_anggota, $trx_date)->first();

                $data[] = array(
                    'no_anggota' => $rd->no_anggota,
                    'nama_anggota' => $rd->nama_anggota,
                    'kode_rembug' => $rd->kode_rembug,
                    'nama_rembug' => $rd->nama_rembug,
                    'total_penerimaan' => $penerimaan->total_penerimaan,
                    'total_penarikan' => $penarikan->total_penarikan
                );
            }

            $res = array(
                'status' => TRUE,
                'data' => $data,
                'msg' => 'Berhasil!',
                'error' => NULL
            );
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => 'Maaf! Data tidak ditemukan',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function deposit(Request $request)
    {
        $no_anggota = $request->no_anggota;

        // ANGSURAN
        $getFinancing = KopPembiayaan::tpl_deposit($no_anggota)->first();
        $rekening_angsuran = (isset($getFinancing->no_rekening) ? $getFinancing->no_rekening : '');
        $angsuran = (isset($getFinancing->angsuran) ? $getFinancing->angsuran : 0);
        $angsuran_pokok = (isset($getFinancing->angsuran_pokok) ? $getFinancing->angsuran_pokok : 0);
        $angsuran_margin = (isset($getFinancing->angsuran_margin) ? $getFinancing->angsuran_margin : 0);
        $angsuran_catab = (isset($getFinancing->angsuran_catab) ? $getFinancing->angsuran_catab : 0);
        $freq = (isset($getFinancing->angsuran) ? 1 : 0);

        // PENCAIRAN
        $getDroping = KopPembiayaan::tpl_droping($no_anggota)->first();
        $rekening_pencairan = (isset($getDroping->no_rekening) ? $getDroping->no_rekening : 0);
        $pokok = (isset($getDroping->pokok) ? $getDroping->pokok : 0);
        $biaya_administrasi = (isset($getDroping->biaya_administrasi) ? $getDroping->biaya_administrasi : 0);
        $biaya_asuransi_jiwa = (isset($getDroping->biaya_asuransi_jiwa) ? $getDroping->biaya_asuransi_jiwa : 0);
        $biaya_asuransi_jaminan = (isset($getDroping->biaya_asuransi_jaminan) ? $getDroping->biaya_asuransi_jaminan : 0);
        $biaya_notaris = (isset($getDroping->biaya_notaris) ? $getDroping->biaya_notaris : 0);
        $tabungan_persen = (isset($getDroping->tabungan_persen) ? $getDroping->tabungan_persen : 0);
        $dana_kebajikan = (isset($getDroping->dana_kebajikan) ? $getDroping->dana_kebajikan : 0);

        if ($rekening_angsuran == '') {
            $no_rekening = $rekening_pencairan;
        } else {
            $no_rekening = $rekening_angsuran;
        }

        // SIMPANAN WAJIB
        $param = array('no_anggota' => $no_anggota);
        $getMember = KopAnggota::where($param)->first();
        $simwa = $getMember->simwa;
        $simsuk = $getMember->simsuk;

        // PEMBIAYAAN
        $show = KopPembiayaan::tpl_financing($no_anggota);

        $hit = $show->count();

        $financing = array();

        if ($hit > 0) {
            foreach ($show as $sh) {
                $financing[] = array(
                    'nama_produk' => $sh['nama_singkat'],
                    'counter_angsuran' => $sh['counter_angsuran'],
                    'jangka_waktu' => $sh['jangka_waktu'],
                    'pokok' => str_replace('.', '', number_format($sh['pokok'], 0, ',', '.'))
                );
            }
        } else {
            $financing[] = array(
                'nama_produk' => NULL,
                'counter_angsuran' => 0,
                'jangka_waktu' => 0,
                'pokok' => 0
            );
        }

        // BERENCANA
        $read = KopTabungan::tpl_saving($no_anggota);

        $count = $read->count();

        $saving = array();

        if ($count > 0) {
            foreach ($read as $rd) {
                $saving[] = array(
                    'nama_produk' => $rd['nama_singkat'],
                    'no_rekening' => $rd['no_rekening'],
                    'setoran' => str_replace('.', '', number_format($rd['setoran'], 0, ',', '.')),
                    'freq_saving' => (isset($rd['setoran']) ? 1 : 0),
                    'counter_angsuran' => $rd['counter_angsuran'],
                    'jangka_waktu' => $rd['jangka_waktu']
                );
            }
        } else {
            $saving[] = array(
                'nama_produk' => NULL,
                'no_rekening' => NULL,
                'setoran' => 0,
                'freq_saving' => 0,
                'counter_angsuran' => 0,
                'jangka_waktu' => 0
            );
        }

        $data = array(
            'no_rekening' => $no_rekening,
            'angsuran' => [
                'amount' => str_replace('.', '', number_format($angsuran, 0, ',', '.')),
                'detail' => [
                    [
                        'id' => '32',
                        'nama' => 'angsuran pokok',
                        'amount' => str_replace('.', '', number_format($angsuran_pokok, 0, ',', '.'))
                    ],
                    [
                        'id' => '33',
                        'nama' => 'angsuran margin',
                        'amount' => str_replace('.', '', number_format($angsuran_margin, 0, ',', '.'))
                    ],
                    [
                        'id' => '34',
                        'nama' => 'angsuran catab',
                        'amount' => str_replace('.', '', number_format($angsuran_catab, 0, ',', '.'))
                    ]
                ]
            ],
            'frekuensi' => $freq,
            'simwa' => str_replace('.', '', number_format($simwa, 0, ',', '.')),
            'simsuk' => str_replace('.', '', number_format($simsuk, 0, ',', '.')),
            'pembiayaan' => $financing,
            'berencana' => $saving,
            'pokok' => str_replace('.', '', number_format($pokok, 0, ',', '.')),
            'biaya_administrasi' => str_replace('.', '', number_format($biaya_administrasi, 0, ',', '.')),
            'biaya_asuransi_jiwa' => str_replace('.', '', number_format($biaya_asuransi_jiwa, 0, ',', '.')),
            'biaya_asuransi_jaminan' => str_replace('.', '', number_format($biaya_asuransi_jaminan, 0, ',', '.')),
            'biaya_notaris' => str_replace('.', '', number_format($biaya_notaris, 0, ',', '.')),
            'tabungan_persen' => str_replace('.', '', number_format($tabungan_persen, 0, ',', '.')),
            'dana_kebajikan' => str_replace('.', '', number_format($dana_kebajikan, 0, ',', '.'))
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

    function process_deposit(Request $request)
    {
        $uuid = collect(DB::select('SELECT uuid() AS id_trx_rembug'))->first()->id_trx_rembug;

        $kode_cabang = $request->kode_cabang;
        $kode_rembug = $request->kode_rembug;
        $kode_petugas = $request->kode_petugas;
        $kode_kas_petugas = $request->kode_kas_petugas;
        $trx_date = str_replace('/', '-', $request->trx_date);
        $trx_date = date('Y-m-d', strtotime($trx_date));
        $no_anggota = $request->no_anggota;
        $no_rekening = $request->no_rekening;
        $angsuran = $request->angsuran;
        $setoran_sukarela = $request->setoran_sukarela;
        $setoran_simpanan_wajib = $request->setoran_simpanan_wajib;
        $penarikan_sukarela = $request->penarikan_sukarela;

        $no_rekening_tabungan = $request->no_rekening_tabungan;
        $amount_tabungan = $request->amount_tabungan;

        $pokok = $request->pokok;

        $count = count($no_rekening_tabungan);

        $data_trx_rembug = array(
            'id_trx_rembug' => $uuid,
            'kode_rembug' => $kode_rembug,
            'kode_petugas' => $kode_petugas,
            'trx_date' => $trx_date,
            'created_by' => $kode_petugas
        );

        $data_trx_anggota = array();

        // ANGSURAN PEMBIAYAAN
        for ($a = 0; $a < count($angsuran); $a++) {
            if ($angsuran[$a]['amount'] > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => $no_rekening,
                    'trx_date' => $trx_date,
                    'amount' => $angsuran[$a]['amount'],
                    'flag_debet_credit' => 'C',
                    'trx_type' => $angsuran[$a]['id'],
                    'description' => 'Bayar ' . $angsuran[$a]['nama'],
                    'created_by' => $kode_petugas
                );
            }
        }

        // PENCAIRAN
        if ($pokok > 0) {
            $data_droping = array(
                'status_droping' => 1,
                'droping_by' => $kode_petugas,
                'droping_at' => date('Y-m-d H:i:s')
            );
        } else {
            $data_droping = array(
                'status_droping' => 0,
                'droping_by' => NULL,
                'droping_at' => NULL
            );
        }

        // SETORAN SUKARELA
        if ($setoran_sukarela > 0) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => NULL,
                'trx_date' => $trx_date,
                'amount' => $setoran_sukarela,
                'flag_debet_credit' => 'C',
                'trx_type' => '13',
                'description' => 'Bayar Simsuk',
                'created_by' => $kode_petugas
            );
        }

        // SETORAN SIMPANAN WAJIB
        if ($setoran_simpanan_wajib > 0) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => NULL,
                'trx_date' => $trx_date,
                'amount' => $setoran_simpanan_wajib,
                'flag_debet_credit' => 'C',
                'trx_type' => '12',
                'description' => 'Bayar Simwa',
                'created_by' => $kode_petugas
            );
        }

        // PENARIKAN SUKARELA
        if ($penarikan_sukarela > 0) {
            $data_trx_anggota[] = array(
                'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                'id_trx_rembug' => $uuid,
                'no_anggota' => $no_anggota,
                'no_rekening' => NULL,
                'trx_date' => $trx_date,
                'amount' => $penarikan_sukarela,
                'flag_debet_credit' => 'D',
                'trx_type' => '22',
                'description' => 'Penarikan Tabungan',
                'created_by' => $kode_petugas
            );
        }

        for ($i = 0; $i < $count; $i++) {
            if ($amount_tabungan[$i] > 0) {
                $data_trx_anggota[] = array(
                    'id_trx_anggota' => collect(DB::select('SELECT uuid() AS id_trx_anggota'))->first()->id_trx_anggota,
                    'id_trx_rembug' => $uuid,
                    'no_anggota' => $no_anggota,
                    'no_rekening' => $no_rekening_tabungan[$i],
                    'trx_date' => $trx_date,
                    'amount' => $amount_tabungan[$i],
                    'flag_debet_credit' => 'C',
                    'trx_type' => '21',
                    'description' => 'Setoran Tabungan',
                    'created_by' => $kode_petugas
                );
            }
        }

        $validate = KopTrxRembug::validateAdd($data_trx_rembug);
        $validate2 = KopTrxAnggota::validateAdd($data_trx_anggota);

        DB::beginTransaction();

        if ($validate['status'] === TRUE or $validate2['status'] === TRUE) {
            try {
                KopTrxRembug::create($data_trx_rembug);
                KopTrxAnggota::insert($data_trx_anggota);
                KopPembiayaan::where('no_rekening', '=', $no_rekening)->update($data_droping);

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data_trx_rembug,
                    'msg' => $e->getMessage(),
                    'error' => NULL
                );
            }
        } else {
            $msg = array(
                'validate' => $validate['msg'],
                'validate2' => $validate2['msg']
            );

            $error = array(
                'error' => $validate['errors'],
                'error2' => $validate2['errors']
            );

            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => $msg,
                'error' => $error
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function process_cash(Request $request)
    {
        $kode_kas_petugas = $request->kode_kas_petugas;
        $nama_rembug = $request->nama_rembug;
        $total_setoran = $request->total_setoran;
        $total_penarikan = $request->total_penarikan;
        $total_infaq = $request->total_infaq;
        $voucher_date = $request->voucher_date;
        $created_by = $request->kode_petugas;

        $validate_fill = array(
            'kode_kas_petugas' => $kode_kas_petugas,
            'nama_rembug' => $nama_rembug,
            'total_setoran' => $total_setoran,
            'total_penarikan' => $total_penarikan,
            'total_infaq' => $total_infaq,
            'voucher_date' => $voucher_date,
            'created_by' => $created_by
        );

        $data_trx_kas_petugas = array();

        $data_trx_kas_petugas[] = array(
            'kode_kas_petugas' => $kode_kas_petugas,
            'jenis_trx' => 2,
            'debit_credit' => 'D',
            'jumlah_trx' => ($total_setoran + $total_infaq),
            'trx_date' => date('Y-m-d'),
            'voucher_date' => $voucher_date,
            'keterangan' => 'PENERIMAAN MAJELIS ' . $nama_rembug,
            'created_by' => $created_by
        );

        $data_trx_kas_petugas[] = array(
            'kode_kas_petugas' => $kode_kas_petugas,
            'jenis_trx' => 3,
            'debit_credit' => 'C',
            'jumlah_trx' => $total_penarikan,
            'trx_date' => date('Y-m-d'),
            'voucher_date' => $voucher_date,
            'keterangan' => 'PENARIKAN MAJELIS ' . $nama_rembug,
            'created_by' => $created_by
        );

        $validate = KopTrxKasPetugas::validateAdd($validate_fill);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                KopTrxKasPetugas::insert($data_trx_kas_petugas);

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!',
                    'error' => NULL
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data_trx_kas_petugas,
                    'msg' => $e->getMessage(),
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => NULL,
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    function penerimaan_angsuran(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'kop_trx_anggota.trx_anggota';
        $total = 0;
        $totalPage = 1;
        $cabang = '~';
        $petugas = '~';
        $rembug = '~';
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

        if ($request->cabang) {
            $cabang = $request->cabang;
        }

        if ($request->petugas) {
            $petugas = $request->petugas;
        }

        if ($request->rembug) {
            $rembug = $request->rembug;
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

        $read = KopTrxAnggota::select('ktr.trx_date', 'kp.no_rekening', 'ka.nama_anggota', 'kr.nama_rembug', 'kp.angsuran_pokok', DB::raw('COALESCE(a.byr_pokok,0) AS byr_pokok'), DB::raw('COALESCE(b.byr_margin,0) AS byr_margin'))
            ->join('kop_trx_rembug AS ktr', 'ktr.id_trx_rembug', 'kop_trx_anggota.id_trx_rembug')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'ktr.kode_rembug')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kop_trx_anggota.no_anggota')
            ->join('kop_pembiayaan AS kp', 'kp.no_rekening', 'kop_trx_anggota.no_rekening')
            ->leftjoin(DB::raw("(SELECT no_rekening,trx_date,SUM(amount) AS byr_pokok FROM kop_trx_anggota WHERE trx_type = '32' AND flag_debet_credit = 'C' GROUP BY no_rekening,trx_date) AS a"), function ($join) {
                $join->on('a.no_rekening', 'kp.no_rekening')->where('a.trx_date', DB::raw('CAST(ktr.trx_date AS DATE)'));
            })
            ->leftjoin(DB::raw("(SELECT no_rekening,trx_date,SUM(amount) AS byr_margin FROM kop_trx_anggota WHERE trx_type = '33' AND flag_debet_credit = 'C' GROUP BY no_rekening,trx_date) AS b"), function ($join) {
                $join->on('b.no_rekening', 'kp.no_rekening')->where('b.trx_date', DB::raw('CAST(ktr.trx_date AS DATE)'));
            })
            ->whereBetween('ktr.trx_date', [$from, $to]);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($cabang <> '~') {
            $read->where('kr.kode_cabang', $cabang);
        }

        if ($petugas <> '~') {
            $read->where('kr.kode_petugas', $petugas);
        }

        if ($rembug <> '~') {
            $read->where('kr.kode_rembug', $rembug);
        }

        $read = $read->groupBy('ktr.trx_date', 'kp.no_rekening', 'ka.nama_anggota', 'kr.nama_rembug', 'kp.angsuran_pokok', 'a.byr_pokok', 'b.byr_margin')->get();

        $res = array(
            'status' => TRUE,
            'data' => $read,
            'page' => $page,
            'perPage' => $perPage,
            'sortDir' => $sortDir,
            'sortBy' => $sortBy,
            'total' => $total,
            'totalPage' => $totalPage,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function kartu_angsuran(Request $request)
    {
        $no_rekening = '~';

        if ($request->no_rekening) {
            $no_rekening = $request->no_rekening;
        }

        $read = KopPembiayaan::select('kop_pembiayaan.no_rekening', 'ka.nama_anggota', 'kr.nama_rembug', 'kd.nama_desa', 'kpp.nama_produk', 'kop_pembiayaan.tanggal_akad', 'kop_pembiayaan.tanggal_mulai_angsur', 'kop_pembiayaan.pokok', 'kop_pembiayaan.margin', 'kop_pembiayaan.jangka_waktu', 'kop_pembiayaan.periode_jangka_waktu', 'kop_pembiayaan.angsuran_pokok', 'kop_pembiayaan.angsuran_margin')
            ->join('kop_pengajuan AS kpg', 'kpg.no_pengajuan', 'kop_pembiayaan.no_pengajuan')
            ->join('kop_anggota AS ka', 'ka.no_anggota', 'kpg.no_anggota')
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'ka.kode_rembug')
            ->join('kop_desa AS kd', 'kd.kode_desa', 'kr.kode_desa')
            ->join('kop_prd_pembiayaan AS kpp', 'kpp.kode_produk', 'kop_pembiayaan.kode_produk')
            ->where('kop_pembiayaan.no_rekening', $no_rekening)->where('kop_pembiayaan.status_rekening', 1)->get();

        $kartu = array();

        foreach ($read as $rd) {
            $card = KopKartuAngsuran::select('kop_kartu_angsuran.*', 'kpg.nama_pgw')
                ->leftjoin('kop_trx_rembug AS ktr', 'ktr.id_trx_rembug', 'kop_kartu_angsuran.id_trx_rembug')
                ->leftjoin('kop_pegawai AS kpg', 'kpg.kode_pgw', 'ktr.kode_petugas')
                ->where('no_rekening', $rd->no_rekening)
                ->orderBy('angsuran_ke', 'ASC')
                ->get();

            foreach ($card as $cd) {
                $kartu[] = array(
                    'trx_date' => $cd->tgl_angsuran,
                    'tgl_bayar' => $cd->tgl_bayar,
                    'angsuran_ke' => $cd->angsuran_ke,
                    'jumlah' => ($cd->angsuran_pokok + $cd->angsuran_margin),
                    'angsuran_pokok' => $cd->angsuran_pokok,
                    'angsuran_margin' => $cd->angsuran_margin,
                    'petugas' => $cd->nama_pgw
                );
            }

            $rd->detail = $kartu;
        }

        $res = array(
            'status' => TRUE,
            'data' => $read,
            'page' => NULL,
            'perPage' => NULL,
            'sortDir' => NULL,
            'sortBy' => NULL,
            'total' => NULL,
            'totalPage' => NUll,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function transaksi_majelis(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'kop_trx_rembug.trx_date';
        $total = 0;
        $totalPage = 1;
        $cabang = '~';
        $petugas = '~';
        $rembug = '~';
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

        if ($request->cabang) {
            $cabang = $request->cabang;
        }

        if ($request->petugas) {
            $petugas = $request->petugas;
        }

        if ($request->rembug) {
            $rembug = $request->rembug;
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

        $read = KopTrxRembug::select('kop_trx_rembug.trx_date', 'kr.nama_rembug', DB::raw('COALESCE(a.setoran,0) AS setoran'), DB::raw('COALESCE(b.penarikan,0) AS penarikan'), DB::raw('COALESCE(SUM(kta.amount),0) AS pencairan'))
            ->join('kop_rembug AS kr', 'kr.kode_rembug', 'kop_trx_rembug.kode_rembug')
            ->leftjoin('kop_trx_anggota AS kta', function ($join) {
                $join->on('kta.id_trx_rembug', 'kop_trx_rembug.id_trx_rembug')->where('kta.trx_type', 31);
            })
            ->leftjoin(DB::raw("(SELECT id_trx_rembug,SUM(amount) AS setoran FROM kop_trx_anggota WHERE flag_debet_credit = 'C' GROUP BY id_trx_rembug) AS a"), function ($join) {
                $join->on('a.id_trx_rembug', 'kop_trx_rembug.id_trx_rembug');
            })
            ->leftjoin(DB::raw("(SELECT id_trx_rembug,SUM(amount) AS penarikan FROM kop_trx_anggota WHERE flag_debet_credit = 'D' GROUP BY id_trx_rembug) AS b"), function ($join) {
                $join->on('b.id_trx_rembug', 'kop_trx_rembug.id_trx_rembug');
            })
            ->whereBetween('kop_trx_rembug.trx_date', [$from, $to]);

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($cabang <> '~') {
            $read->where('kr.kode_cabang', $cabang);
        }

        if ($petugas <> '~') {
            $read->where('kr.kode_petugas', $petugas);
        }

        if ($rembug <> '~') {
            $read->where('kr.kode_rembug', $rembug);
        }

        $read = $read->groupBy('kop_trx_rembug.trx_date', 'kr.nama_rembug', 'a.setoran', 'b.penarikan')->get();

        $res = array(
            'status' => TRUE,
            'data' => $read,
            'page' => $page,
            'perPage' => $perPage,
            'sortDir' => $sortDir,
            'sortBy' => $sortBy,
            'total' => $total,
            'totalPage' => $totalPage,
            'msg' => 'List data available'
        );

        $response = response()->json($res, 200);

        return $response;
    }
}
