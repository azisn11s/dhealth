<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepRacikan extends Model
{
    protected $table = 'resep_racikan';

    protected $fillable = [
        'nama_racikan',
    ];

    public function signa()
    {
        return $this->belongsTo(Signa::class, 'signa_id', 'signa_id');
    }

    public function obatObatan()
    {
        return $this->hasMany(RacikanObat::class, 'racikan_id', 'id');
    }
}
