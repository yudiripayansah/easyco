<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopKotaKabupaten;

class KotaKabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kotakab = new KopKotaKabupaten();

        $data = [
            [
                'kode_kota' => '3603',
                'nama_kota' => 'Kab. Tangerang'
            ],
            [
                'kode_kota' => '3671',
                'nama_kota' => 'Kota Tangerang'
            ]
        ];

        $kotakab::insert($data);

        $this->command->info('Kota Kabupaten berhasil diinput');
    }
}
