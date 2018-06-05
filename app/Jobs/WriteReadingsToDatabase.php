<?php

namespace App\Jobs;

use App\Models\Reading;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WriteReadingsToDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $client;

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

        Reading::create([
            'temperature' => $reading->temperature,
            'humidity' => $reading->humidity,
            'created_at' => Carbon::now('GMT+2'),
            'updated_at' => Carbon::now(),
        ]);
    }
}
