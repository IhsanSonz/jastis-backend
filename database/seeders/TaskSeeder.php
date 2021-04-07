<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user = User::where('name', 'admin')->first();
        $kelas = Kelas::get();

        foreach ($kelas as $class) {
            \DB::table('tasks')->insert([
                'user_id' => $user->_id,
                'kelas_id' => $class->_id,
                'title' => $faker->sentence,
                'desc' => $faker->text,
                'date_start' => \Carbon\Carbon::now(),
                'date_end' => \Carbon\Carbon::now()->addMonth(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
