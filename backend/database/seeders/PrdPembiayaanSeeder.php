<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopPrdPembiayaan;

class PrdPembiayaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pembiayaan = new KopPrdPembiayaan();

        $data = [
            [
                'kode_produk' => '001',
                'kode_akad' => '4',
                'kode_gl' => '10103010',
                'nama_produk' => 'Mikro Mitra Usaha',
                'nama_singkat' => 'MMU',
                'periode_angsuran' => 1,
                'jangka_waktu' => 50,
                'biaya_adm' => 10000,
                'flag_wakalah' => 1,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_produk' => '002',
                'kode_akad' => '3',
                'kode_gl' => '10103030',
                'nama_produk' => 'Mandiri Multi Guna',
                'nama_singkat' => 'MMG',
                'periode_angsuran' => 2,
                'jangka_waktu' => 12,
                'biaya_adm' => 20000,
                'flag_wakalah' => 1,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $pembiayaan::insert($data);

        $this->command->info('Produk Pembiayaan berhasil diinput');
    }
}
