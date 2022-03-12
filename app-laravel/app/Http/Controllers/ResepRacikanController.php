<?php

namespace App\Http\Controllers;

use App\Models\ResepRacikan;
use App\Models\Signa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ResepRacikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ResepRacikan::query();

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
            'nama_racikan'=> ['required', 'min:3'],
            'signa_id'=> ['required', 'exists:signa_m,signa_id'],
            'racikan'=> ['required', 'array'],
            'racikan.*.obat_id'=> ['required', 'exists:obatalkes_m,obatalkes_id'],
            'racikan.*.quantity'=> ['required', 'numeric', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            
            $racikanCollection = collect($request->racikan);

            if ($racikanCollection->count() < 2) {
                abort(403, "Racikan minimal teridiri dari 2 obat");
            }

            $newResepRacikan = new ResepRacikan([
                'nama_racikan'=> $request->nama_racikan,
            ]);

            $signa = Signa::findOrFail($request->signa_id);

            $newResepRacikan->signa()->associate($signa)->save();

            $racikanCollection->each(function($item) use ($newResepRacikan){
                $newResepRacikan->racikanObat()->syncWithoutDetaching([
                    $item['obat_id'] => [
                        'quantity'=> $item['quantity'], 
                        'created_at'=> Carbon::now(), 
                        'updated_at'=> Carbon::now() 
                    ]
                ]);
            });
            
            $newResepRacikan->save();

            DB::commit();

            return response()->json([
                'success'=> true,
                'message'=> 'Berhasil membuat racikan obat',
                'data'=> $newResepRacikan->load(['signa', 'racikanObat'])
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResepRacikan  $resepRacikan
     * @return \Illuminate\Http\Response
     */
    public function show(ResepRacikan $resepRacikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResepRacikan  $resepRacikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResepRacikan $resepRacikan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResepRacikan  $resepRacikan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResepRacikan $resepRacikan)
    {
        DB::beginTransaction();
        try {
            
            $resepRacikan->racikanObat()->detach();
            $resepRacikan->delete();

            DB::commit();

            return response()->json([
                'success'=> true,
                'message'=> 'Berhasil menghapus resep racikan',
                'data'=> null
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
