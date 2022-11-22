<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopKatgoriPar;

class KatgoriParSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $katgoripar = new KopKatgoriPar;

        $data = [
            [
                'jumlah_hari_1' => '8',
                'jumlah_hari_2' => '37',
                'kategori_par' => '1 - 30',
                'cpp' => 10,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'jumlah_hari_1' => '38',
                'jumlah_hari_2' => '97',
                'kategori_par' => '31 - 90',
                'cpp' => 50,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'jumlah_hari_1' => '98',
                'jumlah_hari_2' => '999999999',
                'kategori_par' => '> 90',
                'cpp' => 100,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $katgoripar::insert($data);

        $this->command->info('Kategori PAR berhasil diinput');
    }
}
