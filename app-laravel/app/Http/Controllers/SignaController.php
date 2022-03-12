<?php

namespace App\Http\Controllers;

use App\Models\Signa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Signa::query();

        // Filter
        if ($request->has('search')) {
            $query->where('signa_kode', 'ilike', "%{$request->search}%")
                ->orWhere('signa_nama', 'ilike', "%{$request->search}%")
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
        $query = DB::table('signa_m AS com')
            ->limit(15)
            ->orderBy('created_date', 'desc')
            ->select(['com.signa_id AS code', 'com.signa_nama AS label']);

        if ($request->has('term')) {
            $query->whereRaw("(com.signa_kode like '%$request->term%' OR com.signa_nama like '%$request->term%')");
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
     * @param  \App\Models\Signa  $signa
     * @return \Illuminate\Http\Response
     */
    public function show(Signa $signa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Signa  $signa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signa $signa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Signa  $signa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signa $signa)
    {
        //
    }
}
