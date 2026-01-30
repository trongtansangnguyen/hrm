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
        $user = Auth::user();
        $employee = $user?->employee?->load('department');

        $leaveRequests = $employee
            ? Leave::where('employee_id', $employee->id)->latest()->get()
            : collect();

        return view('employee-leaves', compact('employee', 'leaveRequests'));
    }

    public function store(Request $request)
    {
        return view('employee-leaves');
    }
}
