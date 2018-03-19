<?php
/**
 * Created by IntelliJ IDEA.
 * User: milos
 * Date: 17.3.18.
 * Time: 19.34
 */

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