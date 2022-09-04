<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopCabang;
use Illuminate\Support\Carbon;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cabang = new KopCabang;

        $data = [
            [
                'kode_cabang' => '00000',
                'nama_cabang' => 'PUSAT KONSOLIDASI',
                'induk_cabang' => '00000',
                'jenis_cabang' => 0,
                'pimpinan_cabang' => 'Khaerudin',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_cabang' => '10000',
                'nama_cabang' => 'BANTEN',
                'induk_cabang' => NULL,
                'jenis_cabang' => 1,
                'pimpinan_cabang' => 'Man. Area Banten',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_cabang' => '10100',
                'nama_cabang' => 'TANGERANG SELATAN',
                'induk_cabang' => '10000',
                'jenis_cabang' => 2,
                'pimpinan_cabang' => 'Man. Area Tangsel',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_cabang' => '10101',
                'nama_cabang' => 'KCP SERPONG',
                'induk_cabang' => '10100',
                'jenis_cabang' => 3,
                'pimpinan_cabang' => 'Ade Setiawan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_cabang' => '99999',
                'nama_cabang' => 'PUSAT OPERASIONAL',
                'induk_cabang' => '10100',
                'jenis_cabang' => 1,
                'pimpinan_cabang' => 'Herdi Kusuma',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $cabang::insert($data);

        $this->command->info('Cabang berhasil diinput');
    }
}
