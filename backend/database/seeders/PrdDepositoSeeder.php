<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopPrdDeposito;

class PrdDepositoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deposito = new KopPrdDeposito();

        $data = [
            [
                'kode_produk' => '001',
                'kode_gl' => '20104010',
                'nama_produk' => 'SIMPANAN BERJANGKA',
                'nama_singkat' => 'SIMJAKA',
                'periode_setoran' => 1,
                'jangka_waktu' => 12,
                'minimal_setoran' => 500000,
                'nisbah' => 1,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_produk' => '002',
                'kode_gl' => '20201010',
                'nama_produk' => 'SIMPANAN MASA DEPAN',
                'nama_singkat' => 'SIMAPAN',
                'periode_setoran' => 0,
                'jangka_waktu' => 3,
                'minimal_setoran' => 300000,
                'nisbah' => 1,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $deposito::insert($data);

        $this->command->info('Produk Deposito berhasil diinput');
    }
}
