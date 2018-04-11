<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TestController extends Controller
{
    public function index()
    {
//        $a = shell_exec('');
//        $command = escapeshellcmd('/home/pi/Code/resources/assets/python/readings.py');
        $output = shell_exec('/home/pi/Code/resources/assets/python/readings.py');
        print_r('aaa');
        print_r($output); die;
//        dd($a);
        $process = new Process('/home/pi/Code/resources/assets/python/readings.py');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
