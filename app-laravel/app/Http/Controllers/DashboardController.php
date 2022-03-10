<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Team;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function counterCompany()
    {
        $counter = Company::count();

        return response()->json([
            'success'=> true,
            'message'=> 'Counter company has been loaded!',
            'data'=> $counter
        ]);
    }

    public function counterEmployee()
    {
        $counter = Employee::count();

        return response()->json([
            'success'=> true,
            'message'=> 'Counter employee has been loaded!',
            'data'=> $counter
        ]);
    }

    public function counterDoctor()
    {
        $counter = Doctor::whereIsActive(true)->count();

        return response()->json([
            'success'=> true,
            'message'=> 'Counter doctor has been loaded!',
            'data'=> $counter
        ]);
    }

    public function counterTeam()
    {
        $counter = Team::whereIsActive(true)->count();

        return response()->json([
            'success'=> true,
            'message'=> 'Counter team has been loaded!',
            'data'=> $counter
        ]);
    }
}
