<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Transformers\ProgramTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use Helpers;

    protected $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function index()
    {
        $programs = $this->program->all();

        return $this->response->collection($programs, new ProgramTransformer());
    }

    public function activateSetting(Request $request)
    {
        $id = $request->id;

        $programs = $this->program->all();

        foreach ($programs as $program) {
            $program->update([
                'is_active' => 0
            ]);
        }

        $program = $this->program->where('id', $id)->first();
        $program->update([
            'is_active' => 1
        ]);

        return $program;
    }

    public function deleteSetting($id)
    {
        $program = $this->program->where('id', $id)->first();
        $program->delete();

        return 'ok';
    }

    public function createProgram(Request $request)
    {
        $data = $request->only('name', 'min_temperature', 'max_temperature', 'optimal_humidity');

        if ($this->program->create($data))
            return true;

        return false;
    }
}
