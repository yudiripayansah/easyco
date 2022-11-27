<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KopTrxAnggota;

class TrxAnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trxanggota = new KopTrxAnggota();
        $trxanggota->id_trx_anggota = bin2hex(random_bytes(16));
        $trxanggota->no_anggota = '1010100000001';
        $trxanggota->no_rekening = '1010100010002220010001';
        $trxanggota->trx_date = '2022-07-25';
        $trxanggota->amount = 50000;
        $trxanggota->flag_debet_credit = 'C';
        $trxanggota->trx_type = 1;
        $trxanggota->description = 'SETORAN SUKARELA';
        $trxanggota->created_by = 1;

        $trxanggota->save();

        $this->command->info('Trx Anggota berhasil diinput');
    }
}
