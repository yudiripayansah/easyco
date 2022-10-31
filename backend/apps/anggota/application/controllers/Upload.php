<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_upload');
        date_default_timezone_set('Asia/Jakarta');
    }

    function member()
    {
        $member = file_get_contents('php://input');

        $decode = json_decode($member);

        $count = count($decode);

        $data = array();

        for ($i = 0; $i < $count; $i++) {
            $data[] = array(
                'noanggota' => $decode[$i]->noanggota,
                'nama' => $decode[$i]->nama,
                'majelis' => $decode[$i]->majelis,
                'desa' => $decode[$i]->desa,
                'status' => $decode[$i]->status,
                'simpok' => $decode[$i]->simpok,
                'simwa' => $decode[$i]->simwa,
                'sukarela' => $decode[$i]->sukarela,
                'umroh' => $decode[$i]->umroh,
                'qurban' => $decode[$i]->qurban,
                'pendidikan' => $decode[$i]->pendidikan
            );
        }

        $this->db->trans_begin();
        $this->model_upload->delete('kis_anggota');
        $this->model_upload->insert_batch('kis_anggota', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            $result = array(
                'status' => TRUE,
                'message' => 'Data berhasil diupload!'
            );
        } else {
            $this->db->trans_rollback();

            $result = array(
                'status' => FALSE,
                'message' => 'Data gagal diupload!'
            );
        }

        echo json_encode($result);
    }

    function deposito()
    {
        $deposito = file_get_contents('php://input');

        $decode = json_decode($deposito);

        $count = count($decode);

        $data = array();

        for ($i = 0; $i < $count; $i++) {
            $data[] = array(
                'nomrek' => $decode[$i]->nomrek,
                'noanggota' => $decode[$i]->noanggota,
                'status' => $decode[$i]->status,
                'produk' => $decode[$i]->produk,
                'tgl_buka' => $decode[$i]->tgl_buka,
                'jk_waktu' => $decode[$i]->jk_waktu,
                'tgl_jtempo' => $decode[$i]->tgl_jtempo,
                'saldo' => $decode[$i]->saldo,
                'bagihasil' => $decode[$i]->bagihasil
            );
        }

        $this->db->trans_begin();
        $this->model_upload->delete('kis_deposito');
        $this->model_upload->insert_batch('kis_deposito', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            $result = array(
                'status' => TRUE,
                'message' => 'Data berhasil diupload!'
            );
        } else {
            $this->db->trans_rollback();

            $result = array(
                'status' => FALSE,
                'message' => 'Data gagal diupload!'
            );
        }

        echo json_encode($result);
    }

    function financing()
    {
        $financing = file_get_contents('php://input');

        $decode = json_decode($financing);

        $count = count($decode);

        $data = array();

        for ($i = 0; $i < $count; $i++) {
            $data[] = array(
                'nomrek' => $decode[$i]->nomrek,
                'noanggota' => $decode[$i]->noanggota,
                'status' => $decode[$i]->status,
                'tgl_droping' => $decode[$i]->tgl_akad,
                'produk' => $decode[$i]->produk,
                'pokok' => $decode[$i]->pokok,
                'margin' => $decode[$i]->margin,
                'jk_waktu' => $decode[$i]->jk_waktu,
                'cnt_bayar' => $decode[$i]->cnt_bayar,
                'bayar_pkk' => $decode[$i]->bayar_pkk,
                'bayar_mgn' => $decode[$i]->bayar_mgn,
                'saldo_pkk' => $decode[$i]->saldo_pkk,
                'saldo_mgn' => $decode[$i]->saldo_mgn
            );
        }

        $this->db->trans_begin();
        $this->model_upload->delete('kis_pembiayaan');
        $this->model_upload->insert_batch('kis_pembiayaan', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            $result = array(
                'status' => TRUE,
                'message' => 'Data berhasil diupload!'
            );
        } else {
            $this->db->trans_rollback();

            $result = array(
                'status' => FALSE,
                'message' => 'Data gagal diupload!'
            );
        }

        echo json_encode($result);
    }

    function transaction_deposito()
    {
        ini_set('memory_limit', '1G');

        $transaction_deposito = file_get_contents('php://input');

        $decode = json_decode($transaction_deposito);

        $count = count($decode);

        $data = array();

        for ($i = 0; $i < $count; $i++) {
            $data[] = array(
                'notran' => $decode[$i]->notran,
                'nomrek' => $decode[$i]->nomrek,
                'nourut' => $decode[$i]->nourut,
                'trx_date' => $decode[$i]->trx_date,
                'saldo_awal' => $decode[$i]->saldo_awal,
                'amount_trx' => $decode[$i]->jumlah,
                'saldo' => $decode[$i]->saldo
            );
        }

        $this->db->trans_begin();
        $this->model_upload->delete('kis_trx_deposito');
        $this->model_upload->insert_batch('kis_trx_deposito', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            $result = array(
                'status' => TRUE,
                'message' => 'Data berhasil diupload!'
            );
        } else {
            $this->db->trans_rollback();

            $result = array(
                'status' => FALSE,
                'message' => 'Data gagal diupload!'
            );
        }

        echo json_encode($result);
    }

    function transaction_financing()
    {
        ini_set('memory_limit', '1G');

        $transaction_financing = file_get_contents('php://input');

        $decode = json_decode($transaction_financing);

        $count = count($decode);

        $data = array();

        for ($i = 0; $i < $count; $i++) {
            $data[] = array(
                'notran' => $decode[$i]->id_trx,
                'nomrek' => $decode[$i]->nomrek,
                'tgl_jtempo' => $decode[$i]->tgl_jtempo,
                'angs_ke' => $decode[$i]->angs_ke,
                'angs_pokok' => $decode[$i]->angs_pkk,
                'angs_margin' => $decode[$i]->angs_mgn,
                'saldo_pokok' => $decode[$i]->saldo_pkk,
                'saldo_margin' => $decode[$i]->saldo_mgn,
                'sts_bayar' => $decode[$i]->sts_bayar,
                'tgl_bayar' => $decode[$i]->tgl_bayar
            );
        }

        $this->db->trans_begin();
        $this->model_upload->delete('kis_trx_pembiayaan');
        $this->model_upload->insert_batch('kis_trx_pembiayaan', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            $result = array(
                'status' => TRUE,
                'message' => 'Data berhasil diupload!'
            );
        } else {
            $this->db->trans_rollback();

            $result = array(
                'status' => FALSE,
                'message' => 'Data gagal diupload!'
            );
        }

        echo json_encode($result);
    }

    function transaction_saving()
    {
        ini_set('memory_limit', '1G');

        $transaction_saving = file_get_contents('php://input');

        $decode = json_decode($transaction_saving);

        $count = count($decode);

        $data = array();

        for ($i = 0; $i < $count; $i++) {
            $data[] = array(
                'notran' => $decode[$i]->notran,
                'noanggota' => $decode[$i]->noanggota,
                'trx_date' => $decode[$i]->trx_date,
                'jenis_trx' => $decode[$i]->jenis_trx,
                'saldo_awal' => $decode[$i]->saldo_awal,
                'dc_trx' => $decode[$i]->dc_trx,
                'amount_trx' => $decode[$i]->amount_trx,
                'saldo' => $decode[$i]->saldo,
                'keterangan' => $decode[$i]->keterangan
            );
        }

        $this->db->trans_begin();
        $this->model_upload->delete('kis_trx_simpanan');
        $this->model_upload->insert_batch('kis_trx_simpanan', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            $result = array(
                'status' => TRUE,
                'message' => 'Data berhasil diupload!'
            );
        } else {
            $this->db->trans_rollback();

            $result = array(
                'status' => FALSE,
                'message' => 'Data gagal diupload!'
            );
        }

        echo json_encode($result);
    }
}
