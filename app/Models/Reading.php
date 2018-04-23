<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'temperature', 'humidity', 'temperature_tolerance', 'humidity_tolerance', 'created_at', 'updated_at',
    ];
}
