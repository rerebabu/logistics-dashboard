<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProximityLog extends Model
{
    protected $fillable = [
        'lat',
        'lng',
        'radius',
        'distance',
        'within_range',
    ];
}
