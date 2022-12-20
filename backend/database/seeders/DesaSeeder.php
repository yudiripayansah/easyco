<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopDesa;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desa = new KopDesa();

        $data = [
            [
                'kode_desa' => '36030301',
                'kode_kecamatan' => '360303',
                'nama_desa' => 'PASIR NANGKA',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_desa' => '36030302',
                'kode_kecamatan' => '360303',
                'nama_desa' => 'PETE',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_desa' => '36030601',
                'kode_kecamatan' => '360306',
                'nama_desa' => 'CIBADAK',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_desa' => '36030602',
                'kode_kecamatan' => '360306',
                'nama_desa' => 'BOJONG',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_desa' => '36710101',
                'kode_kecamatan' => '367101',
                'nama_desa' => 'CILENGGANG',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_desa' => '36710102',
                'kode_kecamatan' => '367101',
                'nama_desa' => 'SERPONG',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_desa' => '36710301',
                'kode_kecamatan' => '367103',
                'nama_desa' => 'SAWAH',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_desa' => '36710302',
                'kode_kecamatan' => '367103',
                'nama_desa' => 'SERUA',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_desa' => '32010101',
                'kode_kecamatan' => '320101',
                'nama_desa' => 'PENGASINAN',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $desa::insert($data);

        $this->command->info('Desa berhasil diinput');
    }
}
