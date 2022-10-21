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
                'no_anggota' => '1010100000001'
            ],
            [
                'no_anggota' => '1010100000002'
            ],
            [
                'no_anggota' => '1010100000003'
            ]
        ];

        $anggotauk::insert($data);

        $this->command->info('Anggota UK berhasil diinput');
    }
}
