<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $user->nama_user = 'amin';
        $user->role_user = 1;
        $user->akses_user = 1;
        $user->kode_cabang = '99999';
        $user->kode_pgw = 1;
        $user->password = \Hash::make('easycoOk');
        $user->created_by = 1;

        $user->save();

        $this->command->info('User berhasil diinput');
    }
}
