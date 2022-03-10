<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'label'
    ];

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class, 'unit_id');
    }
}
