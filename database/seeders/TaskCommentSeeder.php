<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

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
        $admin = User::where('name', 'admin')->first();
        $tasks = Task::get();

        foreach ($tasks as $task) {
            \DB::table('task_comments')->insert([
                'user_id' => $admin->_id,
                'task_id' => $task->_id,
                'data' => $faker->sentence(10, true),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
