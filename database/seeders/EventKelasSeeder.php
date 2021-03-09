<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 5; $i++) { 
            \DB::table('event_kelas')->insert([
                'kelas_id' => $i,
                'event_id' => $i,
                'created_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
