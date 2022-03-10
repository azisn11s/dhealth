<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    protected $fillable = [
        'status',
        'caption',
        'description'
    ];

    protected $primaryKey = 'status';

    public $keyType = 'string';

    public $timestamps = false;

}
