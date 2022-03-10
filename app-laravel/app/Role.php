<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'permissions', 'description', 'status'
    ];

    protected $casts = [
        'permissions' => 'array',
        'status'=> 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users');
    }

    public function hasAccess(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission))
                return true;
        }
        return false;
    }

    private function hasPermission(string $permission): bool
    {
        return $this->permissions[$permission] ?? false;
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_role', 'role_id', 'feature_slug', 'id', 'slug')
            ->using(FeatureRole::class)
            ->withPivot('role_id', 'feature_slug', 'abilities');
    }

    public function hasAccessFeature(string $featureSlug, string $ability = "")
    {
        $featureApplied = $this->features->where('slug', $featureSlug)->first();

        if ($featureApplied && $ability) {
            return isset($featureApplied->pivot->abilities[$ability]) && $featureApplied->pivot->abilities[$ability];
        }

        return $featureApplied;
    }
}
