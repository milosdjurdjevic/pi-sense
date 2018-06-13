<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'min_temperature', 'max_temperature', 'is_active', 'optimal_humidity', 'temperature_tolerance'
    ];
}
