<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaskKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 5; $i++) { 
            \DB::table('task_kelas')->insert([
                'kelas_id' => $i,
                'task_id' => $i,
            ]);
        }
    }
}
