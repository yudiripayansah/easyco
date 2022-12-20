<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopPegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawai = new KopPegawai();

        $data = [
            [
                'kode_cabang' => '10101',
                'kode_pgw' => '101010001',
                'nama_pgw' => 'MUHAMMAD UMMAR',
                'jenis_kelamin' => 'P',
                'alamat_pgw' => 'BANDUNG',
                'no_ktp' => '3271040905910006',
                'no_hp' => '087870087958',
                'jabatan' => 'KABAG ADM',
                'tgl_gabung' => '2022-09-01',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_cabang' => '10102',
                'kode_pgw' => '101020002',
                'nama_pgw' => 'DANU',
                'jenis_kelamin' => 'P',
                'alamat_pgw' => 'PERUMAHAN BOGOR RAYA',
                'no_ktp' => '3271234567890123',
                'no_hp' => '082198862841',
                'jabatan' => 'KACAB',
                'tgl_gabung' => '2019-01-05',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_cabang' => '10102',
                'kode_pgw' => '101020001',
                'nama_pgw' => 'RIZKI BILLAR',
                'jenis_kelamin' => 'P',
                'alamat_pgw' => 'PERUMAHAN BOJONG GEDE',
                'no_ktp' => '3271234567890321',
                'no_hp' => '082198862842',
                'jabatan' => 'KABAG ADM',
                'tgl_gabung' => '2022-01-05',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_cabang' => '10101',
                'kode_pgw' => '101010002',
                'nama_pgw' => 'ADMIN MSI',
                'jenis_kelamin' => 'P',
                'alamat_pgw' => 'PERUMAHAN RAJEG',
                'no_ktp' => '3271234567890123',
                'no_hp' => '082198862841',
                'jabatan' => 'KACAB',
                'tgl_gabung' => '2022-01-10',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_cabang' => '10101',
                'kode_pgw' => '101010003',
                'nama_pgw' => 'AMIN',
                'jenis_kelamin' => 'P',
                'alamat_pgw' => 'PERUMAHAN CIBANTENG',
                'no_ktp' => '3271234567890123',
                'no_hp' => '082198862841',
                'jabatan' => 'KACAB',
                'tgl_gabung' => '2019-01-10',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $pegawai::insert($data);

        $this->command->info('Pegawai berhasil diinput');
    }
}
