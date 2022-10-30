<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $kaspetugas->id_user = '08c3ead1abc849149478a0011791ea84';
        $kaspetugas->kode_kas_petugas = '101010001.01';
        $kaspetugas->kode_petugas = '101010001';
        $kaspetugas->kode_gl = '10101013';
        $kaspetugas->nama_kas_petugas = 'UMMAR.Kas Petugas';
        $kaspetugas->jenis_kas_petugas = 0;
        $kaspetugas->created_by = 1;

        $kaspetugas->save();

        $this->command->info('Kas Petugas berhasil diinput');
    }
}
