<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Obat::query();

        // Filter
        if ($request->has('search')) {
            $query->where('obatalkes_kode', 'ilike', "%{$request->search}%")
                ->orWhere('obatalkes_nama', 'ilike', "%{$request->search}%")
                ->orWhere('additional_data', 'ilike', "%{$request->search}%");
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
        $query = DB::table('obatalkes_m AS com')
            ->limit(15)
            ->orderBy('created_date', 'desc')
            ->select(['com.obatalkes_id AS code', 'com.obatalkes_nama AS label']);

        if ($request->has('term')) {
            $query->whereRaw("(com.obatalkes_kode like '%$request->term%' OR com.obatalkes_nama like '%$request->term%')");
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function show(Obat $obat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obat $obat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obat $obat)
    {
        //
    }
}
