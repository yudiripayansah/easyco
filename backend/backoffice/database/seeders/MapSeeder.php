<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopMap;

class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $map = new KopMap();

        $data = [
            [
                'no_pengajuan' => '22.10101.0002',
                'no_map' => '10101000100022220220825130527',
                'status_map' => 1,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'no_pengajuan' => '22.10101.0003',
                'no_map' => '10101000100032220210802151312',
                'status_map' => 1,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $map::insert($data);

        $this->command->info('MAP berhasil diinput');
    }
}
