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
            'min_temperature' => '20',
            'max_temperature' => '30',
            'optimal_humidity' => '70',
            'temperature_tolerance' => '5',
            'humidity_tolerance' => '10',
            'is_active' => '1',
        ]);

        \App\Models\Program::create([
            'name' => 'Melon',
            'min_temperature' => '25',
            'max_temperature' => '30',
            'optimal_humidity' => '65',
            'temperature_tolerance' => '10',
            'humidity_tolerance' => '10',
            'is_active' => '0',
        ]);

        \App\Models\Program::create([
            'name' => 'Tomato',
            'min_temperature' => '18',
            'max_temperature' => '25',
            'optimal_humidity' => '50',
            'temperature_tolerance' => '8',
            'humidity_tolerance' => '10',
            'is_active' => '0',
        ]);
    }
}
