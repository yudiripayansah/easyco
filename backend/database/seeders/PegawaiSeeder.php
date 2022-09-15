<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopPegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawai = new KopPegawai();
        $pegawai->kode_cabang = '10101';
        $pegawai->kode_pgw = '2022091229';
        $pegawai->nama_pgw = 'Muhammad Ummar';
        $pegawai->jenis_kelamin = 'P';
        $pegawai->alamat_pgw = 'Bandung';
        $pegawai->no_ktp = '3271040905910006';
        $pegawai->no_hp = '087870087958';
        $pegawai->jabatan = 'Staff IT';
        $pegawai->tgl_gabung = '2022-09-01';
        $pegawai->created_by = 1;

        $pegawai->save();

        $this->command->info('Pegawai berhasil diinput');
    }
}
