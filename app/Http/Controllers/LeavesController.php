<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class LeavesController extends Controller
{
    public function index()
    {
        $role = Auth::user()?->role;

        if (in_array($role, [UserRole::ADMIN, UserRole::MANAGER], true)) {
            return redirect()->route('management.leaves.index');
        }

        return redirect()->route('employee-leaves.index');
    }
}
