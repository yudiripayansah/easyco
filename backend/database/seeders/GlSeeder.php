<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\KopGl;

class GlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gl = new KopGl();

        $data = [
            [
                'kode_gl' => '10101011',
                'group_gl' => '10101000',
                'tipe_gl' => 1,
                'default_saldo' => 'D',
                'nama_gl' => 'Kas Besar',
                'created_by' => 1
            ],
            [
                'kode_gl' => '10101012',
                'group_gl' => '10101000',
                'tipe_gl' => 1,
                'default_saldo' => 'D',
                'nama_gl' => 'Kas Teller',
                'created_by' => 1
            ],
            [
                'kode_gl' => '10101013',
                'group_gl' => '10101000',
                'tipe_gl' => 1,
                'default_saldo' => 'D',
                'nama_gl' => 'Kas Petugas',
                'created_by' => 1
            ],
            [
                'kode_gl' => '20103010',
                'group_gl' => '20103000',
                'tipe_gl' => 2,
                'default_saldo' => 'C',
                'nama_gl' => 'Simpanan Sukarela',
                'created_by' => 1
            ],
            [
                'kode_gl' => '30101010',
                'group_gl' => '30101000',
                'tipe_gl' => 3,
                'default_saldo' => 'C',
                'nama_gl' => 'Simpanan Pokok',
                'created_by' => 1
            ],
            [
                'kode_gl' => '40100010',
                'group_gl' => '40100000',
                'tipe_gl' => 4,
                'default_saldo' => 'C',
                'nama_gl' => 'Pendapatan Margin Murabahah',
                'created_by' => 1
            ],
            [
                'kode_gl' => '50101010',
                'group_gl' => '50000000',
                'tipe_gl' => 5,
                'default_saldo' => 'D',
                'nama_gl' => 'Bonus Simpanan',
                'created_by' => 1
            ]
        ];

        $gl::insert($data);

        $this->command->info('GL berhasil diinput');
    }
}
