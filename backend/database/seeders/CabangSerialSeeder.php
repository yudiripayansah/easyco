<?php

namespace Database\Seeders;

use App\Models\KopCabangSerial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CabangSerialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CabangSerial = new KopCabangSerial;

        $data = [
            [
                'kode_cabang' => '10101',
                'no_serial' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $CabangSerial::insert($data);

        $this->command->info('Cabang Serial berhasil diinput');
    }
}
