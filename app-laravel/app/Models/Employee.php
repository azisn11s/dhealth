<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'nik',
        'mobile_phone',
        'full_address',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
