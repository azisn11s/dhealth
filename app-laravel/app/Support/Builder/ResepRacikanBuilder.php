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

            $racikan = ResepRacikan::findOrFail($item['obat']['code']);
            
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

    public function dettachObat(string $entityId)
    {
        $resepRacikan = ResepRacikan::findOrFail($entityId);

        DB::beginTransaction();
        try {

            $resepRacikan->racikanObat()->detach();
            
            $resepObatItem = [
                'resep_id'=> $this->resep->id,
                'entity_type'=> 'racikan',
                'entity_id'=> $resepRacikan->id
            ];
    
            DB::table('resep_obat')->where($resepObatItem)->delete();
    
            $resepRacikan->delete();

            
            DB::commit();

            return;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    
}
