<?php

namespace App\Jobs;

use App\Events\ReadTemperatureEvent;
use App\Models\Program;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $client = new Client(['base_uri' => 'https://sesamoid-jackal-7649.dataplicity.io/']);

        $reading = json_decode($client->request('GET', 'node/reading')->getBody()->getContents());
        $status = json_decode($client->request('GET', 'node/heating-status')->getBody()->getContents());

        $settings = Program::where('is_active', 1)->first();

        // Turn on or off heating
        if ($reading->temperature < $settings->min_temperature) {
                $client->request('GET', 'node/turn-on-heating');
        } else if ($reading->temperature > $settings->max_temperature) {
                $client->request('GET', 'node/turn-off-heating');
        }

        // Make a call if temperature is over tolerance
        if ($reading->temperature <= ($settings->min_temperature - $settings->temperature_tolerance)) {
            Nexmo::calls()->create([
                'to' => [[
                    'type' => 'phone',
                    'number' => '+381600626593'
                ]],
                'from' => [
                    'type' => 'phone',
                    'number' => '+381600626593'
                ],
                'answer_url' => ['https://sesamoid-jackal-7649.dataplicity.io//min-temperature-alert'],
                'event_url' => ['https://sesamoid-jackal-7649.dataplicity.io']
            ]);
        } else if ($reading->temperature >= ($settings->max_temperature + $settings->max)) {
            Nexmo::calls()->create([
                'to' => [[
                    'type' => 'phone',
                    'number' => '+381600626593'
                ]],
                'from' => [
                    'type' => 'phone',
                    'number' => '+381600626593'
                ],
                'answer_url' => ['https://sesamoid-jackal-7649.dataplicity.io//max-temperature-alert'],
                'event_url' => ['https://sesamoid-jackal-7649.dataplicity.io']
            ]);
        }

        event(new ReadTemperatureEvent());
    }
}
