<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;

    public $primaryKey = 'slug';

    public $incrementing = false;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_active',
        'actions', // available actions to use on feature_role pivot
    ];

    protected $casts = [
        'is_active'=> 'boolean',
        'actions'=> 'array'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'feature_role', 'feature_slug', 'role_id', 'slug', 'id')
            ->using(FeatureRole::class)
            ->withPivot('role_id', 'feature_slug', 'abilities');
    }
}
