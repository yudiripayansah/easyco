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
        $anggotauk->no_anggota = '101010001000122';

        $anggotauk->save();

        $this->command->info('Anggota UK berhasil diinput');
    }
}
