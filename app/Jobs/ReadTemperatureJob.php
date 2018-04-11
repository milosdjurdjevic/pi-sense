<?php

namespace App\Jobs;

use App\Events\ReadTemperatureEvent;
use App\Models\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReadTemperatureJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "https://sesamoid-jackal-7649.dataplicity.io:3000/reading");
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $response = json_decode(curl_exec($ch));
//
//        $settings = Program::where('is_active', 1)->first();
//
//        if ($response->temperature < $settings->min_temperature) {
//            // TODO: Turn on heating
//        }
//        if ($response->temperature > $settings->max_temperature) {
//            // TODO: Turn off heating
//        }

        // TODO: Calculate formula for humidity

        event(new ReadTemperatureEvent());
    }
}
