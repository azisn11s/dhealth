<?php namespace App\Support\Interfaces;

use App\Models\Resep;

interface IResepObat {
    
    /**
     * Attach obat-obatan kedalam resep
     * 
     * @param array $items | List obat (Racikan atau Non-racikan)
     */
    public function attachObat(array $items);

}