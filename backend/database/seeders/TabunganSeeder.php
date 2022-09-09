<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopTabungan;

class TabunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabungan = new KopTabungan;

        $data = [
            [
                'kode_produk' => '001',
                'no_anggota' => '101010001000122',
                'no_rekening' => '1010100010001220010001',
                'jangka_waktu' => 0,
                'periode_setoran' => 1,
                'setoran' => 0,
                'tanggal_buka' => '2022-09-01',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_produk' => '002',
                'no_anggota' => '101010001000122',
                'no_rekening' => '1010100010002220020001',
                'jangka_waktu' => 36,
                'periode_setoran' => 2,
                'setoran' => 500000,
                'tanggal_buka' => '2022-09-01',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $tabungan::insert($data);

        $this->command->info('Tabungan berhasil diinput');
    }
}
