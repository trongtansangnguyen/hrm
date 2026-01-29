<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveController extends Controller
{
    public function index()
    {
        return view('employee-leaves');
    }

    public function store(Request $request)
    {
        return view('employee-leaves');
    }
}
