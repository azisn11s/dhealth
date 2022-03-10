<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::query()->with([
            'department'
        ]);

        // Filter
        if ($request->has('search')) {
            $employees->where('full_name', 'ilike', "%{$request->search}%");
        }

        // Order
        if ($request->has('sort')) {
            $sortArray = json_decode($request->get('sort'), true);

            if (!$sortArray) {
                $employees->orderBy('created_at', 'desc');
            }

            foreach ($sortArray as $column => $direction) {

                if (!$direction) {
                    continue;
                }

                $employees->orderBy($column, $direction);
            }
        }

        $result = $employees->paginate($request->get('per_page', 15));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'success'=> true,
            'message'=> 'Employee has been loaded successfully',
            'data'=> $employee->load('department')
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    /**
     * Get collection of companies
     * 
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $employeeQuery = DB::table('employees AS com')
            ->join('departments AS dept', 'com.department_id', 'dept.id')
            ->limit(15)
            ->whereNull('com.deleted_at')
            ->orderBy('com.created_at', 'desc')
            ->selectRaw("com.id AS code, com.full_name AS label, com.nik, dept.name AS department_name");
            // ->addSelect(DB::raw(""));

        if ($request->has('term')) {
            $employeeQuery->whereRaw("(com.full_name ilike '%$request->term%' OR com.nik ilike '%$request->term%')")
                ->orWhereRaw("dept.name ilike '%$request->term%'");
        }

        return response()->json([
            'items'=> $employeeQuery->get()
        ]);        
    }
}
