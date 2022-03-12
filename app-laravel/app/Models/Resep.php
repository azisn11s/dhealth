<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resep extends Model
{
    protected $table = 'resep';

    protected $fillable = [
        'nama_pasien',
        'nama_dokter',
        'tanggal_periksa',
        'tempat_periksa',
        'is_draft',
        'catatan'
    ];

    protected $dates = [
        'tanggal_periksa'
    ];

    protected $casts = [
        'is_draft'=> 'boolean'
    ];

    protected $appends = [
        'resep_obat'
    ];

    /**
     * Resep Obat
     * Pivot table: resep_obat
     */
    public function getResepObatAttribute()
    {
        $items = DB::table('resep_obat')
            ->where('resep_id', $this->id)
            ->get()
            ->map(function($item){
                if ($item->entity_type == 'racikan') {
                    $item->obat = ResepRacikan::find($item->entity_id);
                    return $item;
                }
                if ($item->entity_type == 'nonracikan') {
                    $item->obat = ResepNonracikan::find($item->entity_id);
                    return $item;
                }
            });

        return $items;
    }
}
