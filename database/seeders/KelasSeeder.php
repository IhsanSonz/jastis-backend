<?php

namespace Database\Seeders;

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
        for ($i=1; $i <= 5; $i++) { 
            \DB::table('kelas')->insert([
                'user_id' => 2,
                'name' => 'TKI-' . $i,
            ]);
        }
    }
}
