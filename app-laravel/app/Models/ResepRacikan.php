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

    public function racikanObat()
    {
        return $this->belongsToMany(Obat::class, 'racikan_obat', 'racikan_id', 'obat_id')
            ->withPivot('obat_id', 'quantity');
    }
}
