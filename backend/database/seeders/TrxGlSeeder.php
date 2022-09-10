<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KopTrxGl;

class TrxGlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trxgl = new KopTrxGl();
        $trxgl->id_trx_gl = '651e4771319843468d0a7974be549f0a';
        $trxgl->kode_cabang = '10101';
        $trxgl->trx_date = '2022-09-30';
        $trxgl->voucher_date = '2022-09-30';
        $trxgl->trx_type = 0;
        $trxgl->created_by = 1;

        $trxgl->save();

        $this->command->info('Trx GL berhasil diinput');
    }
}
