<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopKasPetugas;

class KasPetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kaspetugas = new KopKasPetugas();

        $data = [
            [
                'id_user' => '08c3ead1abc849149478a0011791ea84',
                'kode_kas_petugas' => '101010001.01',
                'kode_petugas' => '101010001',
                'kode_gl' => '10101013',
                'nama_kas_petugas' => 'UMMAR.Kas Petugas',
                'jenis_kas_petugas' => '0',
                'status_kas_petugas' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => 'b59a3a872ed02978122e921f649665eb',
                'kode_kas_petugas' => '101020001.01',
                'kode_petugas' => '101020001',
                'kode_gl' => '10101013',
                'nama_kas_petugas' => 'RIZKI.Kas Petugas',
                'jenis_kas_petugas' => '0',
                'status_kas_petugas' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => 'a3dd38121e0ac26bece0331ada658edd',
                'kode_kas_petugas' => '101010002.01',
                'kode_petugas' => '101010002',
                'kode_gl' => '10101013',
                'nama_kas_petugas' => 'ADMIN MSI.Kas Petugas',
                'jenis_kas_petugas' => '0',
                'status_kas_petugas' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => '76987fd7b81a15d385cc91f37f940fd8',
                'kode_kas_petugas' => '101020002.01',
                'kode_petugas' => '101020002',
                'kode_gl' => '10101013',
                'nama_kas_petugas' => 'DANU.Kas Petugas',
                'jenis_kas_petugas' => '0',
                'status_kas_petugas' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => '92715fa82353c854b2af6e0070f165a6',
                'kode_kas_petugas' => '101010003.01',
                'kode_petugas' => '101010003',
                'kode_gl' => '10101013',
                'nama_kas_petugas' => 'AMIN.Kas Petugas',
                'jenis_kas_petugas' => '0',
                'status_kas_petugas' => '1',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $kaspetugas::insert($data);

        $this->command->info('Kas Petugas berhasil diinput');
    }
}
