<?php

namespace App\Transformers;

use App\Models\Reading;
use League\Fractal\TransformerAbstract;

class ReadingsTransformer extends TransformerAbstract
{
    public function transform(Reading $reading)
    {
        return $reading->attributesToArray();
    }
}