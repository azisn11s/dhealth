<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FeatureRole extends Pivot
{
    protected $fillable = [
        'abilities'
    ];

    protected $casts = [
        'abilities'=> 'array'
    ];
}
