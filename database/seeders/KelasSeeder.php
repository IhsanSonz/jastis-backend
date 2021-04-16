<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
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
        $faker = Faker::create();
        $user = User::where('name', 'admin')->first();

        for ($i = 1; $i <= 5; $i++) {
            \DB::table('kelas')->insert([
                'user_id' => $user->_id,
                'name' => 'TKI-' . $i,
                'subject' => $faker->sentence,
                'desc' => $faker->paragraph,
                'code' => \Str::random(5),
                'color' => ltrim($faker->hexcolor, '#'),
                'created_at' => \Carbon\Carbon::now()->toISOString(),
                'updated_at' => \Carbon\Carbon::now()->toISOString(),
            ]);
        }
    }
}
