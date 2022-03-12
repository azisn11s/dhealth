<?php

namespace App\Support\Builder;

use App\Models\RacikanObat;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\Signa;
use App\Support\Interfaces\IResepObat;
use Illuminate\Support\Facades\DB;

class ResepRacikanBuilder implements IResepObat
{
    public $resep;

    function __construct(Resep $resep) {
        $this->resep = $resep;
    }

    public function attachObat(array $item)
    {
        DB::beginTransaction();
        try {

            $racikan = ResepRacikan::findOrFail($item['id']);
            
            $resepObatItem = [
                'resep_id'=> $this->resep->id,
                'entity_type'=> 'racikan',
                'entity_id'=> $racikan->id
            ];
            
            DB::table('resep_obat')->updateOrInsert($resepObatItem, $resepObatItem);

            DB::commit();

            return;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}