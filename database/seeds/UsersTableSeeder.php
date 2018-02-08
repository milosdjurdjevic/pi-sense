<?php

use Illuminate\Database\Seeder;

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

        for($i=0; $i<15; $i++) {
            \App\Models\User::create([
                'name'           => 'Test' . str_random(5),
                'email'          => 'test' . str_random(5) . '@test.com',
                'password'       => app('hash')->make('test'),
//                'api_token' => str_random(60),
            ]);
        }
    }
}
