<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models\KopUser;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new KopUser;
        $user->nama_user = 'ummar';
        $user->role_user = 1;
        $user->akses_user = 1;
        $user->kode_cabang = '10101';
        $user->kode_pgw = '2022091229';
        $user->password = Hash::make('easycoOk');
        $user->created_by = 1;

        $user->save();

        $this->command->info('User berhasil diinput');
    }
}
