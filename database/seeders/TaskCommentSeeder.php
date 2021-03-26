<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=1; $i <= 5; $i++) { 
            \DB::table('task_comments')->insert([
                'user_id' => 2,
                'task_id' => $i,
                'data' => 'Tunggu apalagi?',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        for ($i=1; $i <= 5; $i++) { 
            \DB::table('task_comments')->insert([
                'user_id' => $i + 2,
                'task_id' => $i,
                'data' => $faker->sentence(10, true),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
