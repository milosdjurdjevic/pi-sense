<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Transformers\ProgramTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Validator;

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

        return response()->json(['program' => $program]);;
    }

    public function deleteSetting($id)
    {
        $program = $this->program->where('id', $id)->first();
        $program->delete();

        return 'ok';
    }

    public function createProgram(Request $request)
    {
        $data = $request->only('name', 'min_temperature', 'max_temperature', 'temperature_tolerance');
        $data['optimal_humidity'] = 0;

        if ($this->program->create($data))
            return response()->json(['success' => true]);

        return response()->json(['success' => false]);;
    }

    public function show($id)
    {
        $program = $this->program->where('id', $id)->first();

        if (!$program)
            return $this->errorBadRequest('No user found!');

        return $this->response->item($program, new ProgramTransformer());
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), [
            'name' => 'required',
            'min_temperature' => 'required',
            'max_temperature' => 'required',
            'temperature_tolerance' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator->messages());
        }

        $attributes = [
            'name' => $request->get('name'),
            'min_temperature' => $request->get('min_temperature'),
            'max_temperature' => $request->get('max_temperature'),
            'temperature_tolerance' => $request->get('temperature_tolerance'),

        ];
        $program = $this->program->where('id', $id)->first();

        if (!$program->update($attributes))
            return $this->response->error('Update failed');

        return $this->response->noContent();
    }
}