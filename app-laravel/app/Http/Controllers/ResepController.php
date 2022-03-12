<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Support\Builder\ResepNonRacikan;
use App\Support\Builder\ResepNonRacikanBuilder;
use App\Support\Builder\ResepRacikanBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Resep::query();

        // Filter
        if ($request->has('search')) {
            $query->where('nama_pasien', 'like', "%{$request->search}%")
                ->orWhere('nama_dokter', 'like', "%{$request->search}%")
                ->orWhere('tempat_periksa', 'like', "%{$request->search}%");
        }

        // Order
        if ($request->has('sort')) {
            $sortArray = json_decode($request->get('sort'), true);

            if (!$sortArray) {
                $query->orderBy('created_at', 'desc');
            }

            foreach ($sortArray as $column => $direction) {

                if (!$direction) {
                    continue;
                }

                $query->orderBy($column, $direction);
            }
        }

        $result = $query->paginate($request->get('per_page', 15));
        // $result = $users->simplePaginate($request->get('per_page', 15));

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_pasien'=> ['required'],
            'nama_dokter'=> ['required'],
            'tempat_periksa'=> ['nullable'],
            'tanggal_periksa'=> ['required', 'date'],
            'catatan'=> ['nullable'],
            'list_obat'=> ['required', 'array'],
            'list_obat.*.obat'=> ['required'],
            'list_obat.*.quantity'=> ['required', 'numeric'],
            'list_obat.*.type'=> ['required', 'in:racikan,nonracikan'],
            'list_obat.*.signa'=> ['required']
        ]);

        DB::beginTransaction();
        try {
            
            $newResep = Resep::create($request->all());

            $listObat = collect($request->list_obat);

            $listObat->each(function($item) use ($newResep){
                
                if ($item['type'] === 'nonracikan') {
                    (new ResepNonRacikanBuilder($newResep))->attachObat($item);
                }

                if ($item['type'] === 'racikan') {
                    (new ResepRacikanBuilder($newResep))->attachObat($item);
                }
                
            });
            
            DB::commit();

            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil membuat data resep',
                'data'=> Resep::find($newResep->id)
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resep  $resep
     * @return \Illuminate\Http\Response
     */
    public function show(Resep $resep)
    {
        return response()->json([
            'status'=> true,
            'message'=> 'Berhasil memuat data resep',
            'data'=> $resep
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resep  $resep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resep $resep)
    {
        $this->validate($request, [
            'nama_pasien'=> ['required'],
            'nama_dokter'=> ['required'],
            'tempat_periksa'=> ['nullable'],
            'tanggal_periksa'=> ['required', 'date'],
            'catatan'=> ['nullable'],
            'is_draft'=> ['required', 'boolean'],
            'list_obat'=> ['required', 'array'],
            'list_obat.*.obat'=> ['required'],
            'list_obat.*.quantity'=> ['required', 'numeric'],
            'list_obat.*.type'=> ['required', 'in:racikan,nonracikan'],
            'list_obat.*.signa'=> ['required']
        ]);

        DB::commit();
        try {
            
            $resep->update($request->all());

            $listObat = collect($request->list_obat);

            $listObat->each(function($item) use ($resep){
                
                if ($item['type'] === 'nonracikan') {
                    (new ResepNonRacikanBuilder($resep))->attachObat($item);
                }

                if ($item['type'] === 'racikan') {
                    (new ResepRacikanBuilder($resep))->attachObat($item);
                }
            });
            
            DB::commit();

            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil mengubah data resep',
                'data'=> Resep::find($resep->id)
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resep  $resep
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resep $resep)
    {
        DB::beginTransaction();
        try {
            
            DB::table('resep_obat')->where('resep_id', $resep->id)->delete();

            $resep->delete();
            
            DB::commit();

            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil menghapus data resep',
                'data'=> null
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resep  $resep
     * @param  string  $type
     * @param  string  $entityId
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroyItem(Resep $resep, string $type, string $entityId)
    {
        if ($type === 'nonracikan') {
            (new ResepNonRacikanBuilder($resep))->dettachObat($entityId);
        }

        if ($type === 'racikan') {
            (new ResepRacikanBuilder($resep))->dettachObat($entityId);
        }

        return response()->json([
            'status'=> true,
            'message'=> 'Berhasil menghapus item obat dalam resep',
            'data'=> Resep::find($resep->id)
        ]);
    }
}
