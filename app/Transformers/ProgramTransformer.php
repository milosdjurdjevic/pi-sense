<?php

namespace App\Transformers;

use App\Models\Program;
use League\Fractal\TransformerAbstract;

class ProgramTransformer extends TransformerAbstract
{
    public function transform(Program $program)
    {
        return $program->attributesToArray();
    }
}