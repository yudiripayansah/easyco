<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopRembug;

class RembugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rembug = new KopRembug();
        $rembug->kode_rembug = '101010001';
        $rembug->kode_cabang = '10101';
        $rembug->kode_desa = '36710102';
        $rembug->kode_petugas = '101010001.01';
        $rembug->nama_rembug = '001 Melati';
        $rembug->tgl_pembentukan = '2022-09-01';
        $rembug->hari_transaksi = 1;
        $rembug->jam_transaksi = '09:00';
        $rembug->created_by = 1;

        $rembug->save();

        $this->command->info('Rembug berhasil diinput');
    }
}
