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
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = DB::table('resep_racikan AS com')
            ->limit(15)
            ->orderBy('created_at', 'desc')
            ->select(['com.id AS code', 'com.nama_racikan AS label']);

        if ($request->has('term')) {
            $query->whereRaw("(com.nama_racikan like '%$request->term%')");
        }

        return response()->json([
            'items'=> $query->get()
        ]); 
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
            'signa'=> ['required'],
            'signa.code'=> ['required', 'exists:signa_m,signa_id'],
            'list_obat'=> ['required', 'array'],
            'list_obat.*.obat'=> ['required'],
            'list_obat.*.obat.code'=> ['required', 'exists:obatalkes_m,obatalkes_id'],
            'list_obat.*.quantity'=> ['required', 'numeric', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            
            $racikanCollection = collect($request->list_obat);

            if ($racikanCollection->count() < 2) {
                abort(403, "Racikan minimal teridiri dari 2 obat");
            }

            $newResepRacikan = new ResepRacikan([
                'nama_racikan'=> $request->nama_racikan,
            ]);

            $signa = Signa::findOrFail($request->signa['code']);

            $newResepRacikan->signa()->associate($signa)->save();

            $racikanCollection->each(function($item) use ($newResepRacikan){
                $newResepRacikan->racikanObat()->syncWithoutDetaching([
                    $item['obat']['code'] => [
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
