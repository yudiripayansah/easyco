<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
                'nama_kecamatan' => 'Tigaraksa',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_kecamatan' => '360306',
                'kode_kota' => '3603',
                'nama_kecamatan' => 'Cikupa',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_kecamatan' => '367101',
                'kode_kota' => '3671',
                'nama_kecamatan' => 'Serpong',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_kecamatan' => '367103',
                'kode_kota' => '3671',
                'nama_kecamatan' => 'Ciputat',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $kecamatan::insert($data);

        $this->command->info('Kecamatan berhasil diinput');
    }
}
