<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obatalkes_m';

    public $primaryKey = 'obatalkes_id';

    public function resepRacikan()
    {
        return $this->belongsToMany(ResepRacikan::class, 'racikan_obat', 'obat_id', 'racikan_id')
            ->withPivot('racikan_id', 'quantity');
    }
}
