<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $j = 1;

        for ($i=3; $i <= 7; $i++) { 
            \DB::table('event_user')->insert([
                'user_id' => $i,
                'event_id' => $j,
                'data' => $faker->text,
                'created_at' => \Carbon\Carbon::now(),
            ]);

            $j++;
        }
    }
}
