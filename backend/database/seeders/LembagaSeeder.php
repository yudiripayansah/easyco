<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopLembaga;

class LembagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lembaga = new KopLembaga();
        $lembaga->kode_kop = '20220901';
        $lembaga->nama_kop = 'KSPPS Mitra Sejahtera Raya Indonesia';
        $lembaga->alamat_kop = 'Rajeg - Tangerang';
        $lembaga->nik_kop = '32720220901';
        $lembaga->gl_simpok = '30101010';
        $lembaga->gl_simwa = '30102010';
        $lembaga->gl_simsuk = '20103010';
        $lembaga->created_by = 1;

        $lembaga->save();

        $this->command->info('Lembaga berhasil diinput');
    }
}
