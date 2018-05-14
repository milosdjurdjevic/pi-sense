<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Reading;
use App\Transformers\ReadingsTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

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
        $stats = $this->readings->all();

        return $this->response->collection($stats, new ReadingsTransformer());
    }
}
