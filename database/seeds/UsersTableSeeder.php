<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name'           => 'Admin',
            'email'          => 'admin@admin.com',
            'password'       => bcrypt('admin'),
//            'api_token' => str_random(60),
        ]);

        $faker = Faker::create();

        for($i=0; $i<10; $i++) {
            \App\Models\User::create([
                'name'           => $faker->name,
                'email'          => $faker->email,
                'password'       => bcrypt('test'),
//                'api_token' => str_random(60),
            ]);
        }
    }
}
