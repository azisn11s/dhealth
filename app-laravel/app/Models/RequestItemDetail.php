<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestItemDetail extends Model
{
    protected $fillable = [
        'quantity',
        'caption',
        'status'
    ];

    public function requestItem()
    {
        return $this->belongsTo(RequestItem::class, 'request_item_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function status()
    {
        return $this->belongsTo(RequestStatus::class, 'status');
    }
}
