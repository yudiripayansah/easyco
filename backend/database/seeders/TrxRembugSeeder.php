<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopTrxRembug;

class TrxRembugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trxrembug = new KopTrxRembug();
        $trxrembug->kode_rembug = '101010001';
        $trxrembug->kode_petugas = '101010001';
        $trxrembug->trx_date = '2022-07-25';
        $trxrembug->created_by = 1;

        $trxrembug->save();

        $this->command->info('Trx Rembug berhasil diinput');
    }
}
