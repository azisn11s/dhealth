<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepNonracikan extends Model
{
    protected $table = 'resep_nonracikan';

    protected $fillable = [
        'quantity'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'obatalkes_id');
    }

    public function signa()
    {
        return $this->belongsTo(Signa::class, 'signa_id', 'signa_id');
    }
}
