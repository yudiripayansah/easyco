<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopRembug;

class RembugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rembug = new KopRembug();

        $data = [
            [
                'kode_rembug' => '101010001',
                'kode_cabang' => '10101',
                'kode_desa' => '36710102',
                'kode_petugas' => '101010001',
                'nama_rembug' => '001 MELATI',
                'tgl_pembentukan' => '2022-09-01',
                'hari_transaksi' => '1',
                'jam_transaksi' => '09:00',
                'status_aktif' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_rembug' => '101020001',
                'kode_cabang' => '10102',
                'kode_desa' => '32010101',
                'kode_petugas' => '101020001',
                'nama_rembug' => '002 CEMPAKA',
                'tgl_pembentukan' => '2022-01-10',
                'hari_transaksi' => '1',
                'jam_transaksi' => '08:00',
                'status_aktif' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_rembug' => '101010002',
                'kode_cabang' => '10101',
                'kode_desa' => '36710102',
                'kode_petugas' => '101010002',
                'nama_rembug' => '002 KAMBOJA',
                'tgl_pembentukan' => '2022-01-10',
                'hari_transaksi' => '3',
                'jam_transaksi' => '08:00',
                'status_aktif' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_rembug' => '101010003',
                'kode_cabang' => '10101',
                'kode_desa' => '36710102',
                'kode_petugas' => '101010003',
                'nama_rembug' => '003 MAWAR',
                'tgl_pembentukan' => '2022-01-10',
                'hari_transaksi' => '3',
                'jam_transaksi' => '08:00',
                'status_aktif' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_rembug' => '101020002',
                'kode_cabang' => '10102',
                'kode_desa' => '32010101',
                'kode_petugas' => '101020002',
                'nama_rembug' => '002 TULIP',
                'tgl_pembentukan' => '2022-01-10',
                'hari_transaksi' => '3',
                'jam_transaksi' => '08:00',
                'status_aktif' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $rembug::insert($data);

        $this->command->info('Rembug berhasil diinput');
    }
}
