<?php

namespace App\Http\Controllers;

use App\Events\ReadTemperatureEvent;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function fire()
    {
        event(new ReadTemperatureEvent());

        return 'event fired';
    }
}
