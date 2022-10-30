<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopTrxGlDetail;

class TrxGlDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trxgldetail = new KopTrxGlDetail;

        $data = [
            [
                'id_trx_gl_detail' => bin2hex(random_bytes(16)),
                'id_trx_gl' => '651e4771319843468d0a7974be549f0a',
                'kode_gl' => '10101012',
                'flag_dc' => 'D',
                'amount' => 50000,
                'description' => 'Beli Aqua Galon',
                'trx_sequence' => 1
            ],
            [
                'id_trx_gl_detail' => bin2hex(random_bytes(16)),
                'id_trx_gl' => '651e4771319843468d0a7974be549f0a',
                'kode_gl' => '10101013',
                'flag_dc' => 'C',
                'amount' => 50000,
                'description' => 'Beli Aqua Galon',
                'trx_sequence' => 2
            ]
        ];



        $trxgldetail::insert($data);

        $this->command->info('Trx GL Detail berhasil diinput');
    }
}
