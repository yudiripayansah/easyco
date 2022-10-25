<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopAnggota;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anggota = new KopAnggota;

        $data = [
            [
                'id_anggota' => bin2hex(random_bytes(16)),
                'kode_cabang' => '10101',
                'kode_rembug' => '101010001',
                'no_anggota' => '1010100000001',
                'nama_anggota' => 'Amin Hasan',
                'jenis_kelamin' => 'P',
                'ibu_kandung' => 'Siti Sholehah',
                'tempat_lahir' => 'Pekalongan',
                'tgl_lahir' => '1984-09-01',
                'no_ktp' => '3271010100010001',
                'tgl_gabung' => '2022-09-01',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_anggota' => bin2hex(random_bytes(16)),
                'kode_cabang' => '10101',
                'kode_rembug' => '101010001',
                'no_anggota' => '1010100000002',
                'nama_anggota' => 'Yudi Ripayansah',
                'jenis_kelamin' => 'P',
                'ibu_kandung' => 'Fathonah',
                'tempat_lahir' => 'Bogor',
                'tgl_lahir' => '1993-09-01',
                'no_ktp' => '3271010100010002',
                'tgl_gabung' => '2022-09-01',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_anggota' => bin2hex(random_bytes(16)),
                'kode_cabang' => '10101',
                'kode_rembug' => '101010001',
                'no_anggota' => '1010100000003',
                'nama_anggota' => 'Danu Atmadja',
                'jenis_kelamin' => 'P',
                'ibu_kandung' => 'Marlin',
                'tempat_lahir' => 'Bogor',
                'tgl_lahir' => '1997-09-01',
                'no_ktp' => '3271010100010003',
                'tgl_gabung' => '2022-09-01',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $anggota::insert($data);

        $this->command->info('Anggota berhasil diinput');
    }
}
