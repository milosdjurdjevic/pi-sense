<?php
/**
 * Created by IntelliJ IDEA.
 * User: milos
 * Date: 14.5.18.
 * Time: 21.54
 */

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