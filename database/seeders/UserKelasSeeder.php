<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('name', 'admin')->first();
        $murid1 = User::where('name', 'murid1')->first();
        $kelas = Kelas::where('name', 'TKI-1')->first();

        \DB::table('user_kelas')->insert([
            'user_id' => $admin->_id,
            'kelas' => $kelas->_id,
            'role' => 'guru',
            'created_at' => \Carbon\Carbon::now()->toISOString(),
            'updated_at' => \Carbon\Carbon::now()->toISOString(),
        ]);

        \DB::table('user_kelas')->insert([
            'user_id' => $murid1->_id,
            'kelas' => $kelas->_id,
            'role' => 'murid',
            'created_at' => \Carbon\Carbon::now()->toISOString(),
            'updated_at' => \Carbon\Carbon::now()->toISOString(),
        ]);
    }
}
