<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopKecamatan;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kecamatan = new KopKecamatan();

        $data = [
            [
                'kode_kecamatan' => '360303',
                'kode_kota' => '3603',
                'nama_kecamatan' => 'Tigaraksa'
            ],
            [
                'kode_kecamatan' => '360306',
                'kode_kota' => '3603',
                'nama_kecamatan' => 'Cikupa'
            ],
            [
                'kode_kecamatan' => '367101',
                'kode_kota' => '3671',
                'nama_kecamatan' => 'Serpong'
            ],
            [
                'kode_kecamatan' => '367103',
                'kode_kota' => '3671',
                'nama_kecamatan' => 'Ciputat'
            ]
        ];

        $kecamatan::insert($data);

        $this->command->info('Kecamatan berhasil diinput');
    }
}
