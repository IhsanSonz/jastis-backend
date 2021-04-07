<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            KelasSeeder::class,
            TaskSeeder::class,
            EventSeeder::class,
            UserKelasSeeder::class,
            TaskUserSeeder::class,
            EventCommentSeeder::class,
            TaskCommentSeeder::class,
        ]);
    }
}
