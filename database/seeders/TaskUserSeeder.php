<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

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
        $murid1 = User::where('name', 'murid1')->first();
        $task = Task::first();

        \DB::table('task_users')->insert([
            'user_id' => $murid1->_id,
            'task_id' => $task->_id,
            'data' => $faker->text,
            'created_at' => \Carbon\Carbon::now()->toISOString(),
            'updated_at' => \Carbon\Carbon::now()->toISOString(),
        ]);
    }
}
