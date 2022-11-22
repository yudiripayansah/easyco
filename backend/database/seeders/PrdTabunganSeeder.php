<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopPrdTabungan;

class PrdTabunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabungan = new KopPrdTabungan();

        $data = [
            [
                'kode_produk' => '001',
                'kode_gl' => '20103010',
                'nama_produk' => 'Simpanan Sukarela',
                'nama_singkat' => 'SISUKA',
                'jenis_tabungan' => 0,
                'periode_setoran' => 1,
                'minimal_kontrak' => 0,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_produk' => '002',
                'kode_gl' => '20201010',
                'nama_produk' => 'Simpanan Masa Depan',
                'nama_singkat' => 'SIMAPAN',
                'jenis_tabungan' => 1,
                'periode_setoran' => 2,
                'minimal_kontrak' => 36,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $tabungan::insert($data);

        $this->command->info('Produk Tabungan berhasil diinput');
    }
}
