<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * Resep Obat
     * Pivot table: resep_obat
     */
    // public function resepObat()
    // {
    //     # code...
    // }
}
