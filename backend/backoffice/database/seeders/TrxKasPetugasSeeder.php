<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KopTrxKasPetugas;

class TrxKasPetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trxkaspetugas = new KopTrxKasPetugas();
        $trxkaspetugas->id_trx_kas_petugas = bin2hex(random_bytes(16));
        $trxkaspetugas->kode_kas_petugas = '101010001.01';
        $trxkaspetugas->id_trx_rembug = '75150b84ca4b4e9f82855c914ae67923';
        $trxkaspetugas->jenis_trx = 2;
        $trxkaspetugas->debit_credit = 'C';
        $trxkaspetugas->jumlah_trx = '50000';
        $trxkaspetugas->trx_date = '2022-07-25';
        $trxkaspetugas->voucher_date = '2022-07-25';
        $trxkaspetugas->voucher_ref = '101010001';
        $trxkaspetugas->keterangan = 'TRX REMBUG (101010001)';
        $trxkaspetugas->created_by = 1;

        $trxkaspetugas->save();

        $this->command->info('Trx Kas Petugas berhasil diinput');
    }
}
