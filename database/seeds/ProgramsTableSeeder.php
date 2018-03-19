<?php

use Illuminate\Database\Seeder;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Program::create([
            'name' => 'Watermelon',
            'min_temperature' => '28',
            'max_temperature' => '35',
            'optimal_humidity' => '70',
            'is_active' => '1',
        ]);

        \App\Models\Program::create([
            'name' => 'Melon',
            'min_temperature' => '25',
            'max_temperature' => '30',
            'optimal_humidity' => '65',
            'is_active' => '0',
        ]);

        \App\Models\Program::create([
            'name' => 'Tomato',
            'min_temperature' => '18',
            'max_temperature' => '25',
            'optimal_humidity' => '50',
            'is_active' => '0',
        ]);
    }
}
