<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopPar;

class ParSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $par = new KopPar();
        $par->id_par = 'b3b5b2b0b1b2b3b4b5b6b7b8b9b0b1b2';
        $par->no_rekening = '1010100010003220010001';
        $par->tanggal_hitung = '2022-07-18';
        $par->angsuran_terbayar = 49;
        $par->created_by = 1;

        $par->save();

        $this->command->info('PAR berhasil diinput');
    }
}
