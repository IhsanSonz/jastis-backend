<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => \Carbon\Carbon::now()->toISOString(),
                'password' => bcrypt("admin"),
                'remember_token' => \Str::random(10),
                'created_at' => \Carbon\Carbon::now()->toISOString(),
                'updated_at' => \Carbon\Carbon::now()->toISOString(),
            ],
            [
                'name' => 'guru',
                'email' => 'guru@gmail.com',
                'email_verified_at' => now()->toISOString(),
                'password' => bcrypt("guru"),
                'remember_token' => \Str::random(10),
                'created_at' => \Carbon\Carbon::now()->toISOString(),
                'updated_at' => \Carbon\Carbon::now()->toISOString(),
            ],
        ]);

        for ($i = 1; $i <= 5; $i++) {
            \DB::table('users')->insert([
                'name' => 'murid' . $i,
                'email' => 'murid' . $i . '@gmail.com',
                'email_verified_at' => now()->toISOString(),
                'password' => bcrypt("murid" . $i),
                'remember_token' => \Str::random(10),
                'created_at' => \Carbon\Carbon::now()->toISOString(),
                'updated_at' => \Carbon\Carbon::now()->toISOString(),
            ]);
        }
    }
}
