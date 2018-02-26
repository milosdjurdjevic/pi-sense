<?php
/**
 * Created by IntelliJ IDEA.
 * User: milos
 * Date: 26.2.18.
 * Time: 23.14
 */

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return $user->attributesToArray();
    }
}