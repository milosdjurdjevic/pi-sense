<?php

namespace App\Jobs;

use App\Events\ReadTemperatureEvent;
use App\Models\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Twilio\Rest\Client;

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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sesamoid-jackal-7649.dataplicity.io/node/reading");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));

        $settings = Program::where('is_active', 1)->first();

        // Turn on heating
        if ($response->temperature < $settings->min_temperature) {
            // TODO: Turn on heating
        }

        // Turn off heating
        if ($response->temperature > $settings->max_temperature) {
            // TODO: Turn off heating
        }

        // Make a call if temperature is over tolerance
        if (1) {
            $client = new Twilio(
                getenv('TWILIO_ACCOUNT_SID'),
                getenv('TWILIO_AUTH_TOKEN')
            );

            try {
                $client->calls->create(
                    '+381600626593', // The visitor's phone number
                    getenv('TWILIO_NUMBER') // A Twilio number in your account
                );
            } catch (\Exception $e) {
                // Failed calls will throw
                return $e;
            }

            // return a JSON response
            return array('message' => 'Call incoming!');
        }

        // TODO: Calculate formula for humidity

        event(new ReadTemperatureEvent());
    }
}
