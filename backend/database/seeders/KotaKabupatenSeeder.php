<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
                'nama_kota' => 'Kab. Tangerang',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_kota' => '3671',
                'nama_kota' => 'Kota Tangerang',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $kotakab::insert($data);

        $this->command->info('Kota Kabupaten berhasil diinput');
    }
}
