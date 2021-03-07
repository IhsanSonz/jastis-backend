<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskUserSeeder extends Seeder
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
            \DB::table('task_user')->insert([
                'user_id' => $i,
                'task_id' => $j,
                'data' => $faker->text,
            ]);

            $j++;
        }
    }
}
