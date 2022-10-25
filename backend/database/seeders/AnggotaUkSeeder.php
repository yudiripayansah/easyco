<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopAnggotaUk;

class AnggotaUkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anggotauk = new KopAnggotaUk();

        $data = [
            [
                'id_anggota_uk' => bin2hex(random_bytes(16)),
                'no_anggota' => '1010100000001'
            ],
            [
                'id_anggota_uk' => bin2hex(random_bytes(16)),
                'no_anggota' => '1010100000002'
            ],
            [
                'id_anggota_uk' => bin2hex(random_bytes(16)),
                'no_anggota' => '1010100000003'
            ]
        ];

        $anggotauk::insert($data);

        $this->command->info('Anggota UK berhasil diinput');
    }
}
