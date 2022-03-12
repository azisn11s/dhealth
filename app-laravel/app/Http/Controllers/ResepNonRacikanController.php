<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ResepNonracikan;
use App\Models\Signa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepNonRacikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ResepNonracikan::query()->with([
            'obat'=> function($query){
                $query->select(['obatalkes_id', 'obatalkes_nama']);
            },
            'signa'=> function($query){
                $query->select(['signa_id', 'signa_nama']);
            },
        ]);

        // Filter
        if ($request->has('search')) {
            // $query->where('obatalkes_kode', 'ilike', "%{$request->search}%");
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
            'obat_id'=> ['required', 'exists:obatalkes_m,obatalkes_id'],
            'signa_id'=> ['required', 'exists:signa_m,signa_id'],
            'quantity'=> ['required', 'numeric'],
        ]);

        DB::beginTransaction();
        try {

            $newResepNonRacikan = new ResepNonracikan([
                'quantity'=> $request->quantity
            ]);

            $obat = Obat::findOrFail($request->obat_id);
            $signa = Signa::findOrFail($request->signa_id);
            
            $newResepNonRacikan->obat()->associate($obat);
            $newResepNonRacikan->signa()->associate($signa)->save();

            DB::commit();

            return response()->json([
                'success'=> true,
                'message'=> 'Berhasil membuat resep obat non-racikan',
                'data'=> $newResepNonRacikan
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResepNonracikan  $resepNonracikan
     * @return \Illuminate\Http\Response
     */
    public function show(ResepNonracikan $resepNonracikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResepNonracikan  $resepNonracikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResepNonracikan $resepNonracikan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResepNonracikan  $resepNonracikan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResepNonracikan $resepNonracikan)
    {
        //
    }
}
