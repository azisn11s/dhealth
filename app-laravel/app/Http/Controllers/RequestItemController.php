<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Item;
use App\Models\RequestItem;
use App\Models\RequestItemDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'employee_id'=> ['required', 'exists:employees,id'],
            'request_date'=> ['required', 'date'],
            'description'=> ['nullable'],
            'items'=> ['required', 'array'],
            'items.*.item_id'=> ['required', 'exists:items,id'],
            'items.*.quantity'=> ['required', 'numeric', 'gt:0'],
            'items.*.caption'=> ['nullable', 'max:200']
        ]);

        $employee = Employee::find($request->employee_id);
        $user = auth()->user();

        // return $request->items[0]['quantity'];

        DB::beginTransaction();
        try {

            $newRequestItem = new RequestItem([
                'request_date'=> $request->request_date,
                'description'=> $request->description
            ]);

            $newRequestItem->employee()->associate($employee);
            $newRequestItem->user()->associate($user);
            $newRequestItem->save();
            
            foreach ($request->items as $requestItem) {
                
                $item = Item::find($requestItem['item_id']);
                
                $newRequestItemDetail = new RequestItemDetail([
                    'quantity'=> $requestItem['quantity'],
                    'caption'=> $requestItem['caption'],
                    'status'=> 'request'
                ]);

                $newRequestItemDetail->item()->associate($item);
                $newRequestItem->items()->save($newRequestItemDetail);

            }

            $newRequestItem->save();
            
            DB::commit();

            return response()->json([
                'success'=> true,
                'message'=> 'Request items has been created successfully.',
                'data'=> RequestItem::whereId($newRequestItem->id)->with(['items', 'employee'])->first()
            ]);


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestItem  $requestItem
     * @return \Illuminate\Http\Response
     */
    public function show(RequestItem $requestItem)
    {
        return response()->json([
            'success'=> true,
            'message'=> 'Request item has been loaded successfully',
            'data'=> RequestItem::whereId($requestItem->id)->with(['items', 'employee'])->first()
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestItem  $requestItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestItem $requestItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestItem  $requestItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestItem $requestItem)
    {
        //
    }
}
