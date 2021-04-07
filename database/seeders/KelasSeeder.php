<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name', 'admin')->first();
        for ($i = 1; $i <= 5; $i++) {
            \DB::table('kelas')->insert([
                'user_id' => $user->_id,
                'name' => 'TKI-' . $i,
                'code' => \Str::random(5),
                'created_at' => \Carbon\Carbon::now()->toISOString(),
                'updated_at' => \Carbon\Carbon::now()->toISOString(),
            ]);
        }
    }
}
