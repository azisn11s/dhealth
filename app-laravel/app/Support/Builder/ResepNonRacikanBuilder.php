<?php

namespace App\Support\Builder;

use App\Models\Obat;
use App\Models\Resep;
use App\Models\ResepNonracikan as ModelsResepNonracikan;
use App\Models\Signa;
use App\Support\Interfaces\IResepObat;
use Illuminate\Support\Facades\DB;

class ResepNonRacikanBuilder implements IResepObat
{
    public $resep;

    function __construct(Resep $resep) {
        $this->resep = $resep;
    }

    public function attachObat(array $item)
    {
        DB::beginTransaction();
        try {

            $obat = Obat::findOrFail($item['obat']['code']);
            $signa = Signa::findOrFail($item['signa']['code']);

            $resepNonRacikan = new ModelsResepNonracikan([
                'quantity'=> $item['quantity'],
            ]);          

            $resepNonRacikan->obat()->associate($obat);
            $resepNonRacikan->signa()->associate($signa)->save();
            
            $resepObatItem = [
                'resep_id'=> $this->resep->id,
                'entity_type'=> 'nonracikan',
                'entity_id'=> $resepNonRacikan->id
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
        $resepNonRacikan = ModelsResepNonracikan::findOrFail($entityId);

        DB::beginTransaction();
        try {
            
            $resepObatItem = [
                'resep_id'=> $this->resep->id,
                'entity_type'=> 'nonracikan',
                'entity_id'=> $resepNonRacikan->id
            ];
    
            DB::table('resep_obat')->where($resepObatItem)->delete();
    
            $resepNonRacikan->delete();
    
            
            
            DB::commit();
            
            return;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    
}
