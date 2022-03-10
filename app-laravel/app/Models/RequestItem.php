<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    protected $fillable = [
        'request_date',
        'description'
    ];

    public function items()
    {
        return $this->hasMany(RequestItemDetail::class, 'request_item_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }       

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
