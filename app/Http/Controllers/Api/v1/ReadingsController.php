<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Reading;
use App\Transformers\ReadingsTransformer;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;

class ReadingsController extends Controller
{
    use Helpers;

    protected $readings;

    public function __construct(Reading $reading)
    {
        $this->readings = $reading;
    }

    public function index()
    {
        $stats = $this->readings->whereDate('created_at', '>=', Carbon::now()->subDay(10))->get();

        return $this->response->collection($stats, new ReadingsTransformer());
    }
}
