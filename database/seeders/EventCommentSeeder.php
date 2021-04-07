<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventCommentSeeder extends Seeder
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
        $events = Event::get();

        foreach ($events as $event) {
            \DB::table('event_comments')->insert([
                'user_id' => $admin->_id,
                'event_id' => $event->_id,
                'data' => $faker->sentence(10, true),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
