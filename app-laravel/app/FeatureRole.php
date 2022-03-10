<?php

namespace App;

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
