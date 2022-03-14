<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RacikanObat extends Model
{
    protected $table = 'resep_racikan_obat';

    protected $fillable = [
        'quantity',
    ];

    public function resepRacikan()
    {
        return $this->belongsTo(ResepRacikan::class, 'racikan_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'obatalkes_id');
    }
}
