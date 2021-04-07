<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
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
            \DB::table('events')->insert([
                'user_id' => $user->_id,
                'kelas_id' => $class->_id,
                'title' => $faker->sentence,
                'desc' => $faker->text,
                'created_at' => \Carbon\Carbon::now()->toISOString(),
                'updated_at' => \Carbon\Carbon::now()->toISOString(),
            ]);
        }
    }
}
