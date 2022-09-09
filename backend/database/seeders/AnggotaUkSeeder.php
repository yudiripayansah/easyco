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
                'no_anggota' => '101010001000122'
            ],
            [
                'no_anggota' => '101010001000222'
            ],
            [
                'no_anggota' => '101010001000322'
            ]
        ];

        $anggotauk::insert($data);

        $this->command->info('Anggota UK berhasil diinput');
    }
}
