<?php

namespace App\Http\Controllers;

use App\Events\ReadTemperatureEvent;
use App\Jobs\ReadTemperatureJob;
use App\Jobs\WriteReadingsToDatabase;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function fire()
    {
        ReadTemperatureJob::dispatch();

        return 'event fired';
    }

    public function fireWrite()
    {
        WriteReadingsToDatabase::dispatch();

        return 'event fired';
    }
}
