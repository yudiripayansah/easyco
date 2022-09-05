<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $anggota = new KopAnggota();
        $anggota->kode_cabang = '10101';
        $anggota->kode_rembug = '101010001';
        $anggota->no_anggota = '101010001000122';
        $anggota->nama_anggota = 'Herlan Fahmi';
        $anggota->jenis_kelamin = 'P';
        $anggota->ibu_kandung = 'Tidak Diketahui';
        $anggota->tempat_lahir = 'Tidak Diketahui';
        $anggota->tgl_lahir = '1991-05-09';
        $anggota->no_ktp = '3271040905910009';
        $anggota->tgl_gabung = date('Y-m-d');
        $anggota->created_by = 1;

        $anggota->save();

        $this->command->info('Anggota berhasil diinput');
    }
}
