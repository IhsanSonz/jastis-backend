<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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

        for ($i=0; $i < 5; $i++) { 
            \DB::table('events')->insert([
                'user_id' => 2,
                'title' => $faker->sentence,
                'desc' => $faker->text,
                'date_end' => $faker->dateTimeBetween('now', '+1 year'),
            ]);
        }
    }
}
