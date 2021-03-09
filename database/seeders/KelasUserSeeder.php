<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KelasUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $j = 1;
        for ($i=3; $i <= 7; $i++) {
            \DB::table('kelas_user')->insert([
                'user_id' => $i,
                'kelas_id' => $j,
                'created_at' => \Carbon\Carbon::now(),
            ]);

            $j++;
        }
    }
}
