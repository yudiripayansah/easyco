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
        $trxanggota->no_anggota = '101010001000322';
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
